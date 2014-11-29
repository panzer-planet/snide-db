<?php
/**
 * (c) 2013 CoboltDB
 *
 * @author Werner Roets <cobolt.exe@gmail.com>
 *
 */
	#Debug on/off
	define("DEBUG",true);
	
	#MySQL Database settings
	define("DB_HOST","localhost");
	define("DB_USER",'root');
	define("DB_PASSWORD",'root');
	define("DB_NAME",'german_learning');
	
	define("HUB_TIMEZONE",'Africa/Johannesburg');
	
	define("TABLEOBJECT_DIR", 'core/Tables/');
	define("COLLECTION_DIR",'core/Collections/' );
	
    /* DEVELOPMENT
     ini_set('display_errors',1);
     error_reporting(~0);
    */
    
    /* PRODUCTION
     #ini_set('display_errors',0);
     #error_reporting(E_NONE);
     */