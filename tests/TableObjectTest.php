<?php
/**
 * thehub.co.za
 *
 * (c) 2013 WrappinhooD Software
 *
 * @author Werner Roets <werner@wrappinhood.co.za>
 * @author Antony Cosentino <antony@wrappinhood.co.za>
 *
 */
 
 /*
  * This unit test ensures the Hub\TableObject functions correctly. Since
  * Hub\TableObject is an abstract class, and instance of the Hub\Administrator
  * class is used and the default admin user is loaded when necessary
  */
 class TableObjectTest extends PHPUnit_Framework_TestCase{
	
	/**
     * @covers					\Hub\TableObject::__construct
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     * @expectedException \Hub\TableObjectInvalidConstructorArgumentsException
     */
	public function testExceptionIsRaisedForInvalidConstructorArguments(){
		$admin = new Hub\Administrator('notanID');
	}
	
	/**
     * @covers					\Hub\TableObject::__construct
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanBeConstructedWithOneArgument(){
		$admin = new Hub\Administrator(1);
		$this->assertInstanceOf('Hub\\TableObject',$admin);
	}
	
	/**
     * @covers					\Hub\TableObject::__construct
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanBeConstructedWithManyArgument(){
		$admin = new Hub\Administrator(null,'test1@test.com',password_hash('test',HUB_ENC),'Test','Test');
		$this->assertInstanceOf('Hub\\TableObject',$admin);
	}
	
	/**
     * @covers					\Hub\TableObject::__construct
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanBeConstructedWithArrayArgument(){
		$admin = new Hub\Administrator(
			['id' => null,
			'email' =>'test1@test.com',
			'password_hash' => password_hash('test',PASSWORD_BCRYPT),
			'first_name' => 'Test',
			'last_name' => 'Test']);
		$this->assertInstanceOf('Hub\\TableObject',$admin);
	}
	
	/**
     * @covers					\Hub\TableObject::__get
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanGet(){
		$admin = new Hub\Administrator(1);
		$this->assertEquals('admin@thehub.co.za',$admin->email);
	}
	
	/**
     * @covers					\Hub\TableObject::__set
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanSet(){
		$admin = new Hub\Administrator(1);
		$admin->email = 'changedadmin@thehub.co.za';
		$this->assertEquals('changedadmin@thehub.co.za',$admin->email);
	}
	
	/**
     * @covers					\Hub\TableObject::get_data
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanGetData(){
		$admin = new Hub\Administrator(1);
		$data =  $admin->get_data()['email'];
		$this->assertEquals('admin@thehub.co.za',$admin->get_data()['email']);
		
	}
	
	/**
     * @covers					\Hub\TableObject::__construct
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     * @expectedException \Hub\TableObjectRegexNotMatchException
     */
	public function testExceptionIsRaisedForDataNotPassingRegexFilter(){
		$admin = new Hub\Administrator(
			['id' => null,
			'email' =>'incorrect email.com',
			'password_hash' => password_hash('test',PASSWORD_BCRYPT),
			'first_name' => 'Test',
			'last_name' => 'Test']);
			
		$id = $admin->save();
		#clean up
		$admin->delete();
	}
	
	/**
     * @covers					\Hub\TableObject::set_data
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanSetData(){
		$admin = new Hub\Administrator(1);
		$data = [
			'id' => 1, 
			'email' => 'changedadmin@thehub.co.za', 
			'password_hash' => '$2y$10$LAac1aUO6EKUgvggcAq44Oz7oDQahvdIJpkewAmDRMGyvCdnvj',
			'first_name' => 'changedAdmin',
			'last_name' => 'changedAdmin2'
		];
		$admin->set_data($data);
		$this->assertEquals('changedadmin@thehub.co.za',$admin->email);
		$this->assertEquals('changedAdmin',$admin->first_name);
		$this->assertEquals('changedAdmin2',$admin->last_name);
	}

	/**
     * @covers					\Hub\TableObject::load
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanLoad(){
		$admin  = new Hub\Administrator();
		$admin->load(1);
		$this->assertEquals('admin@thehub.co.za',$admin->email);
		$this->assertEquals('Admin',$admin->first_name);
		$this->assertEquals('Admin',$admin->last_name);
	}
	
	/**
     * @covers					\Hub\TableObject::delete
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
	 * @expectedException \Hub\TableObjectRowNotFoundException
     */
	public function testCanDelete(){
		$admin  = new Hub\Administrator();
		$admin->email = 'newadminx@thehub.com';
		$admin->first_name = 'new';
		$admin->last_name = 'admin';
		$admin->password_hash = password_hash('9*&^%((%^4#$%^789&*^%%%^',HUB_ENC);
		$id = $admin->save();
		
		$admin = new Hub\Administrator($id);
		
		$this->assertEquals('newadminx@thehub.com',$admin->email);
		$this->assertEquals('new',$admin->first_name);
		$this->assertEquals('admin',$admin->last_name);
		
		$admin->delete();
		
		#This should throw a TableObjectRowNotFoundException
		$admin  = new Hub\Administrator();
		$admin->load($id);
	}
	
	/**
     * @covers					\Hub\TableObject::save
     * @uses						\Hub\TableObject
	 * @uses              		\Hub\Administrator
     */
	public function testCanSave(){
		$admin  = new Hub\Administrator();
		$admin->email = 'newadminy@thehub.com';
		$admin->first_name = 'new';
		$admin->last_name = 'admin';
		$admin->password_hash = password_hash('9*&^%((%^4#$%^789&*^%%%^',HUB_ENC);
		$id = $admin->save();
		
		$admin = new Hub\Administrator($id);
		$this->assertEquals('newadminy@thehub.com',$admin->email);
		$this->assertEquals('new',$admin->first_name);
		$this->assertEquals('admin',$admin->last_name);
		
		#Clean up
		$admin->delete();
	}
	/**
     * @uses					\Hub\TableObject
	 * @uses              		\Hub\Administrator
	 * @uses					\Iterator
     */
	
	public function testCanIterateProperties(){
		$admin =  new Hub\Administrator(1);
		
		foreach($admin as $k => $v){
			if(empty($k) || empty($v)){
				throw new \Exception('Could not read a property while iterating');
			}
			
		}
		
	}
	

	
	
 }