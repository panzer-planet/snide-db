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
 class CollectionObjectTest extends PHPUnit_Framework_TestCase{
	
	/**
     * @covers					\Hub\CollectionObject::__construct
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	public function testCanConstructBlankCollection(){
		$adminC = new Hub\AdministratorCollection();
		$this->assertInstanceOf('Hub\\CollectionObject',$adminC);
	
	}
	
	 /**
    * @covers					\Hub\CollectionObject::__construct
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     * @expectedException \Hub\CollectionObjectInvalidConstructorArgumentsException
     */
    public function testExceptionIsRaisedForInvalidConstructorArguments()
    {
        new Hub\AdministratorCollection(3, [1,2],'sfdsfsd',null);
    }
	
	/**
    * @covers					\Hub\CollectionObject::__construct
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     * @expectedException \Hub\CollectionObjectInvalidConstructorArgumentsException
     */
	public function testExceptionIsRaisedForInvalidArrayConstructorArgument()
    {
     
		new Hub\AdministratorCollection([3, [1,2],'sfdsfsd',null]);
    }
	
	 
	/**
     * @covers					\Hub\CollectionObject::add
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	
	public function testCanAddObject(){
		$adminC = new Hub\AdministratorCollection();
		$admin = new Hub\Administrator();
		$admin->first_name = 'TestVal';
		#when object is iterated upon it should return its objects
		$adminC->add($admin);
		
		foreach($adminC->get_contents() as $admin){
			$this->assertEquals('TestVal',$admin->first_name);
		}
	}
	
	/**
     * @covers					\Hub\CollectionObject::set_contents
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	public function testCanGetContents(){
		
		$adminC = new Hub\AdministratorCollection([new Hub\Administrator(),new Hub\Administrator()]);
		$data = $adminC->get_contents();
		foreach($data as $admin){

			$this->assertInstanceOf('Hub\\Administrator',$admin);
		}
	
	}
	
	/**
     * @covers					\Hub\CollectionObject::set_contents
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	 public function testCanSetContents(){
		$adminC = new Hub\AdministratorCollection();
		$adminC->set_contents([new Hub\Administrator(['first_name' => 'werner']),new Hub\Administrator(['first_name' => 'werner'])]);
		foreach($adminC as $admin){
			
			$this->assertInstanceOf('Hub\\Administrator',$admin);
			$this->assertEquals($admin->first_name,'werner');
		}
	 }
	 
	/**
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
	 * @uses					\Iterator
     */
	public function testCanGetContentsUsingIteration(){
		
		$adminC = new Hub\AdministratorCollection([new Hub\Administrator(),new Hub\Administrator()]);
		
		foreach($adminC as $admin){

			$this->assertInstanceOf('Hub\\Administrator',$admin);
		}
	
	}
	
	/**
     * @covers					\Hub\CollectionObject::load_all
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	public function testCanLoadAll(){
		$adminC = new Hub\AdministratorCollection();
		$adminC->load_all();
		foreach($adminC as $admin){
			$this->assertInstanceOf('Hub\\Administrator',$admin);
		}
		
	}
	
	
	/**
     * @covers					\Hub\CollectionObject::load_where
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	public function testCanLoadWhere(){
		$adminC = new Hub\AdministratorCollection();
		$rows_loaded = $adminC->load_where('email','admin@thehub.co.za');
		if($rows_loaded > 0){
			foreach($adminC as $admin){
				$this->assertInstanceOf('Hub\\Administrator',$admin);
				$this->assertEquals('admin@thehub.co.za',$admin->email);
			}
		}else{
			throw new \Exception();
		}
		
	}
	
	/**
     * @covers					\Hub\CollectionObject::load_where
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	public function testReturnsFalseIfNothingFoundWhenLoadWhere(){
		$adminC = new Hub\AdministratorCollection();
		$rows_loaded = $adminC->load_where('email','adsmin@thehDOESNTEXISTub.co.za');
		$this->assertEquals(false,$rows_loaded);
	}
	
	/**
     * @covers					\Hub\CollectionObject::save
     * @uses					\Hub\CollectionObject
	 * @uses              		\Hub\AdministratorCollection
     */
	public function testCanSaveAndDelete(){
		$adminC = new Hub\AdministratorCollection([
			new Hub\Administrator([
				'first_name' => 'testing123XX@',
				'last_name' => 'testinglast123XX@',
				'email' => 'testingsgfdaffmv@kjbnffa.com',
				'password_hash' => password_hash('b6[an3g',HUB_ENC)
			])
		]);
		$adminC->save();
		$rows_loaded = $adminC->load_where('first_name','testing123XX@');
		if($rows_loaded > 0){
			foreach($adminC as $admin){
				$this->assertEquals('testing123XX@',$admin->first_name);
			}
		}else{
			throw new \Exception('Default Administrator not found in database');
		}
		$adminC->delete();
	}
 }