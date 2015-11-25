<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TestTypeRequest;

use App\Models\TestType;
use App\Models\Measure;
use App\Models\MeasureType;
use App\Models\SpecimenType;
use App\Models\TestCategory;
use App\Models\Organism;

use Response;
use Auth;
use Session;
use Lang;

/**
 *Contains functions for managing test types
 *
 */
class TestTypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active testtypes
			$testtypes = TestType::orderBy('name', 'ASC')->get();

		// Load the view and pass the testtypes
		return view('testtype.index')->with('testtypes', $testtypes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$measures = Measure::orderBy('name')->get();
		$specimentypes = SpecimenType::orderBy('name')->get();
		$testcategory = TestCategory::all();
        $measuretype = MeasureType::all()->sortBy('id');
        $organisms = Organism::orderBy('name')->get();

		//Create TestType
		return view('testtype.create')
					->with('testcategory', $testcategory)
					->with('measures', $measures)
       				->with('measuretype', $measuretype)
					->with('specimentypes', $specimentypes)
					->with('organisms', $organisms);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TestTypeRequest $request)
	{
		$testType = new TestType;
		$testType->name = trim($request->name);
		$testType->description = $request->description;
		$testType->test_category_id = $request->test_category_id;
		$testType->targetTAT = $request->targetTAT;
		$testType->prevalence_threshold = $request->prevalence_threshold;
		$testType->orderable_test = $request->orderable_test;
		$testType->accredited = $request->accredited;

		$testType->save();
		$measureIds = array();
		$inputNewMeasures = $request->new_measures;
		
		$measures = New MeasureController;
		$measureIds = $measures->store($inputNewMeasures);
		$testType->setMeasures($measureIds);
		$testType->setSpecimenTypes($request->specimentypes);
		$testType->setOrganisms($request->organisms);
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_testType', $testType ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show a testtype
		$testType = TestType::find($id);

		//Show the view and pass the $testtype to it
		return view('testtype.show')->with('testType', $testType);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the testtype
		$testtype = TestType::find($id);
		$measures = Measure::all();
        $measuretype = MeasureType::all()->sortBy('id');
		$specimentypes = SpecimenType::orderBy('name')->get();
		$testcategory = TestCategory::all();
		$organisms = Organism::orderBy('name')->get();

		//Open the Edit View and pass to it the $testtype
		return view('testtype.edit')
					->with('testtype', $testtype)
					->with('testcategory', $testcategory)
					->with('measures', $measures)
       				->with('measuretype', $measuretype)
					->with('specimentypes', $specimentypes)
					->with('organisms', $organisms);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TestTypeRequest $request, $id)
	{
		$testtype = TestType::find($id);
		$testType->name = trim($request->name);
		$testType->description = $request->description;
		$testType->test_category_id = $request->test_category_id;
		$testType->targetTAT = $request->targetTAT;
		$testType->prevalence_threshold = $request->prevalence_threshold;
		$testType->orderable_test = $request->orderable_test;
		$testType->accredited = $request->accredited;
		$testType->save();

		$testtype->setOrganisms($request->organisms);
		$testtype->setSpecimenTypes($request->specimentypes);
		$measureIds = array();
		if ($request->new_measures) {
			$inputNewMeasures = $request->new_measures;

			$measures = New MeasureController;
			$measureIds = $measures->store($inputNewMeasures);
		}

		if ($request->measures) {
			$inputMeasures = $request->measures;
			foreach($inputMeasures as $key => $value)
			{
			  $measureIds[] = $key;
			}
			$measures = New MeasureController;
			$measures->update($inputMeasures);
		}
		$testtype->setMeasures($measureIds);
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_testType', $testType ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage (soft delete).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the testtype
		$testtype = TestType::find($id);
        $inUseByTests = $testtype->tests->toArray();

		if (empty($inUseByTests)) {
		    // The test type is not in use
			$testtype->delete();
		} else {
		    // The test type is in use
		    return Redirect::route('testtype.index')
		    	->with('message', 'messages.failure-test-type-in-use');
		}
		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}