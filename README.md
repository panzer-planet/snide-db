### snide-db

> Yet another take on ORM - Werner Roets

# Saving is easy!
```php
$user = new SDB\User(); // Just create table object!
$user->name = "Trevor"; //Set values according to columns!
$user->age = 66
$id = $user->save(); // Save!
//or even more simply
$user = new SDB\User("John",5);
$user->save();
```
# Loading is easy
```php
// To load by primary key:
$produt = new SDB\Product($id);
echo $product->name;
//or you can iterate through properties
foreach($product as $column){
	echo $column;
}
```
# Getting many rows is easy
```php
//
$products = new ProductCollection(); // Create a collection object!
$products->sort_by(['name' => 'asc', 'category' => 'desc']) // You can sort on multiple columns!
->load_where_like(name, "%N"); // You can add where clauses easily!

foreach ( $products as $product){
	echo $product->name; // Inside are table objects!
	$product->quanitity = 0; // Everything out of stock!
}
$products->save(); // Update again!

```

##### Introduction
Do you like the idea of an ORM that has almost nothing to configure
and provides full object orientated access? Look no further! snide-db is
the easiest and fastest to configure ORM out there.

##### Features
- Extremely fast and easy setup, simply enter DB details, generate, use
- Built in model generator, one command generates all models
- Create, load, save, delete and edit records using object properties and methods
- Collection system that features sorting, filtering and bulk delete
- Temporary collections for joins, custom sql and temp tables
- Fully iteratable objects and collections
- Multiple constructor options for personal convenience and style (overloading)
- Add custom model functions to expand your business logic
- Regular Expressions can be used to validate data just before writing
- Safe guarded from SQL injection and other exploits
- Extensive and well documented exception system
- Fully unit tested to ensure reliable performance
- Full API reference included
- No global namespace pollution
- Supports method chaining for sorting and filtering

##### Planned features
Support for joins

##### Quickstart

1. Include the `autoloader.php` file
1. Enter database settings in `config.php`
1. Generate the models by running php `cmd.php`

##### Installation
1. Place the folder that contains this readme in a web-accessible directory.

1. In your application (perhaps `/var/www/index.php`) add:
 include `'snide-db/autoload.php'`;
1. Edit `config.php` so that your timezone and database settings are correct.
1. From the command line, generate the supporting files using `cmd.php`. For example if your database contains the tables: 
	`users`, `posts` and `messages`, run the following command:

` $ php cmd.php model users posts messages`
	
CoboltDB is now configured and you can begin using the database.

