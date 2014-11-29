<?php
/**
 * (c) 2013 CoboltDB
 *
 * @author Werner Roets <cobolt.exe@gmail.com>
 *
 */

namespace CDB{

		#Collections name must match object name
		# e.g AdministratorCollection = Administrator
		class WordsCollection extends CollectionObject{

		public function __construct(){
			parent::__construct(func_get_args());
		}

	}

}