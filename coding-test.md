# Censornet PHP coding test
## Abstract
Create a micro-service in PHP without using a predefined framework such as Laravel,
Symfony, etc. to list entries from an SQL database table.

You are free to use any Composer packages required to complete the task
not including, as previously mentioned, full framework bundles.

## Setup
### Database
Create a table similar to the schema defined below, using an RDBMS of your choice
(note that we use PostgreSQL here at Censornet and the following table schema is
written with that in mind but any similar package is suitable e.g. MySQL).

```postgresql
CREATE TABLE vegetables (
  "id" INT8 NOT NULL,
  "name" VARCHAR(256) NOT NULL,
  "classification" VARCHAR(256) NOT NULL,
  "description" TEXT,
  "edible" BOOLEAN NOT NULL DEFAULT true,
  PRIMARY KEY ("id")
) WITH (OIDS=FALSE);

CREATE UNIQUE INDEX "vegetable_id_key" ON "vegetables" USING BTREE ("id" "pg_catalog"."int8_ops");

CREATE SEQUENCE vegetable_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE 
    NO MAXVALUE 
    CACHE 1;

ALTER TABLE vegetable_id_seq OWNER TO postgres;

ALTER SEQUENCE vegetable_id_seq OWNED BY vegetables.id;

ALTER TABLE ONLY vegetables ALTER COLUMN id SET DEFAULT nextval('vegetable_id_seq'::REGCLASS);
```
### Script
You are welcome to set up your script however you see fit although it is recommended
that for simplicity you stick to PSR-2 coding standards and PSR-4 for ease of autoloading.

## The Task
Create an application that lists the entries in the vegetables database table
both by command line e.g. by running a command similar to

```bash
php index.php --list-veg
```

and by using a RESTful endpoint e.g.
```
GET /vegetables
```

The commandline option should output all entries in the table in a readable format on
a unix commandline - imagine it as a developer utility to ensure a service layer
was functioning correctly.

The HTTP endpoint should return well formed JSON.

## Suggestions
The following are suggestions and their implementation/usage or not will have no bearing 
on the outcome of the test if suitable alternatives are used instead:

* https://github.com/mrjgreen/phroute A simple fast router
* https://github.com/thephpleague/container A nice simple DI container
* http://sabre.io/http/ Handy HTTP library

## Requirements
Sufficient documentation to use the application should be provided, there is no 
need to generate browser docs for the API endpoint though. A simple markdown file 
will suffice.

Code should be documented where needed

Automated tests should be included where suitable, 100% code coverage is not expected.

Please use PHP7.0 or above. 
