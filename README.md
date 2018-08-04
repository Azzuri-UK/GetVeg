# GetVeg
The number one source for all of your vegetables.  Except for tomato, we don't talk about tomato!

###Requirements

* PHP 7.2
* Composer
* PostgreSQL 10.2
* A web server configured to rewrite all requests to /src/index.php

##Installation

Clone this repository to the root of your webserver  
Install dependencies via composer

```console
composer install
```

## Configuration

Update /config/db.ini with the details of your database

Run the following in PostgreSQL to create the required database tables

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

Import data.csv into your newly created database table, or populate it with your own data

## Usage
#### HTTP

###### GET /endpoints  
Returns a list of available endpoints

###### GET /vegetables
Returns a list of all vegetables in the database
  
###### GET /vegetables/edible
Returns a list of all edible vegetables in the database

###### GET /vegetables/inedible
Returns a list of all inedible vegetables in the database (TOMATO!)

###### GET /vegetables/vegetable/{vegetableName}
Returns details of a specific vegetable

#### CLI

```console
 php index.php --{REQUEST_TYPE}-{ROUTE}
```

Examples

###### index.php --get-vegetables
###### index.php --get-vegetables/inedible