<?php
/**
 * (c) 2013 CoboltDB
 *
 * @author Werner Roets <cobolt.exe@gmail.com>
 *
 */

 require_once 'config.php';


#If no command or no options show help
if( !isset($argv[1]) || !isset($argv[2])  ){
echo '
INVALID COMMAND AND/OR OPTION
';    
show_help();exit;}

#Which command line tool are we using?
 switch($argv[1]){

	case 'table':
		if(!make_table($argv[2])) print 'There was an error creating the table model';

	break;

	case 'collection':
		if(!make_collection($argv[2])) print 'There was an error creating the collection';
	break;

	case 'model':
        $options = [];
        for($i = 2; $i < count($argv); $i++){
            $result = make_table($argv[$i]);
            if($result === false){
                
                print 'There was an error creating the table model';
                continue;
            }
            if(!make_collection($argv[$i])) print 'There was an error creating the collection';
        }
		
	break;

	case 'help':
		show_help();
	break;

	default:
		print 'ERROR: Invalid Command';
		show_help();
	break;
 }

 ###########
 # FUNCTIONS##
 ###########

 function detect($table){
    
    $db = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($db->connect_errno){
        echo ' Failed to connect to databse. Check your database settings inconfig.php';
    }
    $columns = [];
    $result = $db->query('SHOW COLUMNS FROM '.$table);
    if(!$result){ echo('
ERROR: Table "'.$table.'" could not be found
');
    return false;
}
    while($x = $result->fetch_assoc()){
        $columns[] = $x['Field'];
    }
    return $columns ? $columns : false;
 }
 function show_help(){
 $help = <<<TEXT

(c) 2013 CoboltDB

This command line utility provides various tools to maintain and
develop the hub system. Please read the documentation below.

SYNOPSIS

	php cmd.php  [COMMAND] [OPTIONS...]

COMMANDS

    table
        Creates a new hub table model and adds it to the system.
        Column names are determined by querying the database
        e.g php cmd.php table users.
    
    collection
        Creates a new hub collection. The corresponding table must
        exist for it to work but it will be generated either way.
    
    model
        Creates both hub TableObject and CollectionObject for a
        database table giving full functionality

    help
        displays this help message

AUTHORS
	Werner Roets <cobolt.exe@gmail.com>
	
COPYRIGHT
	(c) 2013 CoboltDB. All rights reserved.

TEXT;
print $help;

 }
###################
# MAKE COLLECTION #
###################
 function make_collection($name){
	 $class_name = ucfirst($name);
     
	 $file = fopen(COLLECTION_DIR."{$class_name}Collection.php",'x');
		if(!$file){
			return false;
		}
 $data = <<<DATA
<?php
/**
 * (c) 2013 CoboltDB
 *
 * @author Werner Roets <cobolt.exe@gmail.com>
 *
 */

namespace CDB\Collections{

		#Collections name must match object name
		# e.g AdministratorCollection = Administrator
		class {$class_name}Collection extends CollectionObject{

		public function __construct(){
			parent::__construct(func_get_args());
		}

	}

}
DATA;
fwrite($file,$data);
fclose($file);
return true;
}
#####################
# MAKE TABLE #
#####################
 function make_table($name){

	$class_name = ucfirst($name);
    $columns = detect($name);
    if($columns == false){
        return false;
    }
	$file = fopen(TABLEOBJECT_DIR."{$class_name}.php",'x');
	if(!$file){
		return false;
	}
$data = <<<DATA
<?php
/**
 * (c) 2013 CoboltDB
 *
 * @author Werner Roets <cobolt.exe@gmail.com>
 *
 */

namespace CDB\Tables{

	#Class must inherit TableObject
	#Class' name must match table name

DATA;
fwrite($file, $data);
fwrite($file,	'    class '.$class_name.' extends TableObject{');
$data = <<<DATA


		public function __construct(){

			/* Parent constructor must be called first
			 * func_get_args must be passed through if it
			 * needs to accept constructor arguments
			 */
			parent::__construct(func_get_args());

			#This is the name of the database table the object corresponds to.

DATA;
fwrite($file,$data);
$data = '            $this->table_name = \''.$name.'\';';
fwrite($file,$data);

$data = <<< DATA

			#Primary key can be set but defaults to 'id'
			#Must be called before set_properties
			#\$this->primary_key = 'id';

			/* The properties are set here with a key => value array
			 * where the keys are the names of the columns of the table
			 * and the values are NULL = false, NOT NULL = true
			 * auto_incrementing fields must be false
			 */
			\$this->set_properties([

DATA;
fwrite($file,$data);
$data = '';
foreach($columns as $column){
    $data.= '               \''.$column.'\' => false,
';
}
fwrite($file,$data);

$data = <<< DATA
            ]);



			#Set regular expressions filters for columns
			# e.g \$this->set_filters(['email' => "^(\w+)@(\w+)"]);


		}
	}
}
DATA;
fwrite($file,$data);
fclose($file);
return true;
 }