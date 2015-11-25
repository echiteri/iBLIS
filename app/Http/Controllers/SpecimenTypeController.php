<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SpecimenTypeRequest;

use App\Models\SpecimenType;

use Response;
use Auth;
use Session;
use Lang;

/**
 * Contains functions for managing specimen types  
 *
 */
class SpecimenTypeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active specimentypes
			$specimenTypes = SpecimenType::orderBy('name', 'ASC')->get();

		// Load the view and pass the specimentypes
		return view('specimentype.index')->with('specimenTypes', $specimenTypes);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//Create SpecimenType
		return view('specimentype.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SpecimenTypeRequest $request)
	{
		$specimenType = new SpecimenType;
		$specimenType->name = $request->name;
		$specimenType->description = $request->description;
		$specimenType->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_specimenType', $specimenType ->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show a specimentype
		$specimenType = SpecimenType::find($id);

		//Show the view and pass the $specimentype to it
		return view('specimentype.show')->with('specimenType', $specimenType);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the specimentype
		$specimenType = SpecimenType::find($id);

		//Open the Edit View and pass to it the $specimentype
		return view('specimentype.edit')->with('specimenType', $specimenType);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SpecimenTypeRequest $request, $id)
	{
		$specimenType = SpecimenType::find($id);
		$specimenType->name = $request->name;
		$specimenType->description = $request->description;
		$specimenType->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_specimenType', $specimenType ->id);
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
		//Soft delete the specimentype
		$specimenType = SpecimenType::find($id);
		$inUseByTesttype = $specimenType->testTypes->toArray();
		$inUseBySpecimen = $specimenType->specimen->toArray();
		if (empty($inUseByTesttype) && empty($inUseBySpecimen)) {
		    // The specimen type is not in use
			$specimenType->delete();
		} else {
		    // The specimen type is in use
		    return Redirect::route('specimentype.index')
		    	->with('message', trans('messages.failure-specimen-type-in-use'));
		}
		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}