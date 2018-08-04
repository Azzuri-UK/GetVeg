<?php
ini_set("display_errors", 1);
/**
 * Created by PhpStorm.
 * User: Justin Carter
 * Date: 03/08/2018
 * Time: 22:53
 */

require __DIR__ . '/../vendor/autoload.php';

// Parse the db config data from an ini file to keep it out of code
$db = parse_ini_file("./config/db.ini");

$container = new League\Container\Container;

// Add our route controllers to the container
$container->add(GetVeg\Routes\Home::class);
$container
    ->add(GetVeg\Routes\Vegetables::class)
    ->addMethodCall('setModel', [\GetVeg\Models\Vegetables::class]);

// Add the model and call the setter for the database connection
$container
    ->add(GetVeg\Models\Vegetables::class)
    ->addMethodCall('setPdo', [PDO::class]);

// Add PDO to the container for DB access using the values from the ini file.
$container
    ->add(PDO::class)
    ->addArgument("pgsql:dbname='" . $db['dbname'] . "';host='" . $db['host'] . "'")
    ->addArgument($db['user'])
    ->addArgument($db['password']);

$router = new Phroute\Phroute\RouteCollector();

// Define our routes and controllers
$router->controller('/', $container->get(\GetVeg\Routes\Home::class));
$router->controller('/vegetables', $container->get(\GetVeg\Routes\Vegetables::class));

$dispatcher = new Phroute\Phroute\Dispatcher($router->getData());

// Check if the code is being called from the CLI or not
if (PHP_SAPI == "cli") {
    $request = explode('-', $argv[1]);
    $requestMethod = strtoupper($request[2]);
    $requestUri = $request[3];
} else {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = $_SERVER['REQUEST_URI'];
}

try {
    $response = $dispatcher->dispatch($requestMethod, $requestUri);
} catch (Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    $response = [
        "success" => false,
        "error" => "You have specified an invalid endpoint"
    ];
} catch (Phroute\Phroute\Exception\HttpMethodNotAllowedException $e) {
    $response = [
        "success" => false,
        "error" => $requestMethod . " is not permitted on this endpoint"
    ];
} catch (Exception $e) {
    $response = [
        "success" => false,
        "error" => $e->getMessage()
    ];
}

// Adjust the output depending on if its being called from CLI or a browser
if (PHP_SAPI == "cli") {
    // Check if there is an error and show it if there is
    if (array_key_exists("error", $response)) {
        print $response['error'];
    } else {
        // Format the output into a table
        $mask = "|%3.3s |%-15.15s |%-15.15s |%-30.30s | %-6.6s  |\n";
        printf($mask, 'Id', 'Name', 'Classification', 'Description', 'Edible');
        printf($mask, '-----', '-------------------', '---------------', '------------------------------', '----------');
        foreach ($response['data'] as $key => $value) {
            printf($mask, $value['id'], $value['name'], $value['classification'], $value['description'],
                $value['edible'] ? "true" : "false");
        }
    }
} else {
    // If its a browser return json data
    echo json_encode($response);
}
?>