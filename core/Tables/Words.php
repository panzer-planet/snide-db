<?php
/**
 * (c) 2013 CoboltDB
 *
 * @author Werner Roets <cobolt.exe@gmail.com>
 *
 */

namespace CDB{

	#Class must inherit TableObject
	#Class' name must match table name
    class Words extends TableObject{

		public function __construct(){

			/* Parent constructor must be called first
			 * func_get_args must be passed through if it
			 * needs to accept constructor arguments
			 */
			parent::__construct(func_get_args());

			#This is the name of the database table the object corresponds to.
            $this->table_name = 'words';
			#Primary key can be set but defaults to 'id'
			#Must be called before set_properties
			$this->primary_key = 'word';

			/* The properties are set here with a key => value array
			 * where the keys are the names of the columns of the table
			 * and the values are NULL = false, NOT NULL = true
			 * auto_incrementing fields must be false
			 */
			$this->set_properties([
               'word' => false,
               'gender' => false,
               'plural' => false,
            ]);



			#Set regular expressions filters for columns
			# e.g $this->set_filters(['email' => "^(\w+)@(\w+)"]);


		}
	}
}