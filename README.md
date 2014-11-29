CoboltDB - Yet another take on ORM

Introduction
==========
Do you like the idea of an ORM that takes under 30 seconds to configure
and provides full object orientated access? Look no further! CoboltDB is
the easiest and fastest to configure ORM out there.

Features
==========
# Extremely fast and easy setup, simply enter DB details, generate, use
# Built in model generator, one command generates all models
# Create, load, save, delete and edit records using object properties and methods
# Collection system that features sorting, filtering and bulk delete
# Temporary collections for joins, custom sql and temp tables
# Fully iteratable objects and collections
# Multiple constructor options for personal convenience and style (overloading)
# Add custom model functions to expand your business logic
# Regular Expressions can be used to validate data just before writing
# Safe guarded from SQL injection and other exploits
# Extensive and well documented exception system
# Fully unit tested to ensure reliable performance
# Full API reference included
# No global namespace pollution
# Supports method chaining for sorting and filtering

Missing features
===========
Support for joins

Quickstart
==========
1. Include the autoloader.php file
2. Enter database settings in config.php
3. Generate the models by running php cmd.php

Installation
===========
1. Place the folder that contains this readme in a web-accessible directory.

2. In your application (perhaps /var/www/index.php) add:
 include 'cobolt-db/autoload.php'; 
 
3. Edit config.php so that your timezone and database settings are correct.

3. From the command line, generate the supporting files using cmd.php 
For example if your database contains the tables: 
	users, posts and messages
run the following command:
	php cmd.php model  users posts messages
	
CoboltDB is now configured and you can begin using the database.

Example
===========
$user = new CDB\Users();
$user->name = "John";
$id = $user->save();

$user = nw CDB\Users($id);
echo $user->name;
