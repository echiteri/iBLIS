<?php
/**
 * Tests the DrugController functions that store, edit and delete drugs 
 * @author  (c) @iLabAfrica, Emmanuel Kitsao, Brian Kiprop, Thomas Mapesa, Anthony Ereng
 */

class HumastarControllerTest extends TestCase {
	
	public function setup()
	{
		parent::setup();
		Artisan::call('migrate');
		Artisan::call('db:seed');
	}

	public function testGenerateASTMWorksheet()
	{
		$astm = new HumastarController;
		$bs = Test::find(5);
		$astm->generateASTMWorksheet($bs);
		$this->assertTrue(true);
	}
}