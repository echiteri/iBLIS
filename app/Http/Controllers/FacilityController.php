<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\FacilityRequest;

use App\Models\Facility;

use Response;
use Auth;
use Session;
use Lang;

class FacilityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//List all facilities
		$facilities = Facility::orderBy('name', 'asc')->get();
		//Load the view and pass the facilities
		return view('facility.index')->with('facilities',$facilities);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('facility.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(FacilityRequest $request)
	{
		$facility = new Facility;
		$facility->name = $request->name;
		$facility->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_facility', $facility ->id);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the facility
		$facility = Facility::find($id);
		return view('facility.edit')->with('facility', $facility);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(FacilityRequest $request, $id)
	{
		$facility = Facility::find($id);
		$facility->name = $request->name;
		$facility->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_facility', $facility ->id);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Deleting the Item
		$facility = Facility::find($id);

		//Soft delete
		$facility->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}