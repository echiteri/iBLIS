<?php

class HumastarController extends \BaseController {

	/**
	* Load the index page with some data from DB
	*
	*/
	public function index()
	{
		$humastarTests = Test::whereHas('testType', function($query){
				$query->where('name', 'like', '%HB%')->take(5);
		})->get();
		return  View::make('humastar.index')->with('humastarTests', $humastarTests);
	}

	/**
	* Loads the page for upload functionality
	*/
	public function upload()
	{
		return View::make("humastar.upload");
	}

	/**
	* Process ASTM file that is uploaded
	*
	*/
	public function processASTM()
	{
		//read contents
		$astm = Input::file('astm')->getRealPath();
		$results = File::get($astm);
		//Validate file
		//Get the juicy details
		
		dd(explode('P|', $results));
		//Match to test and measure id's
		//Present to use for final validation
	}

	/**
	* Recieves a list of tests and generates an ASTM.
	* 
	* @param an array of tests
	* @return ASTM string
	*/
	public function generateASTMWorksheet($humastarTests)
	{
		//Loop through tests 
		//Limit 20?
		foreach ($humastarTests as $key => $humastarTest) {
			$date = date('Y-m-d');
			$header = "H|\^&|||HSX00^V1.0|||||Host||P|1|$date\r\n";
			
			$name = $humastarTests->visit->patient->name;
			$specimenId  = $humastarTests->getSpecimenId();
			$sequence = 1;
			$sampleDetails = "P|$sequence||$specimenId||BIOCHEM|$name|||||||||||||||||||||||||||\r\n";
			$comments = "C|1|||\r\n";
			$measureDetails = '';

			//Loop through the measures
			foreach ($humastarTests->testResults as $key => $testResult) {
				$measureName = $testResult->measure->name;
				$specimenName = $testResult->test->specimen->specimenType->name;
				$measureDetails .=  "O|1|||$measureName|False||||||||||$specimenName|||||||||||||||\r\n";
			}
			echo $header . $sampleDetails . $comments . $measureDetails;
		}
	}
}