<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\LotRequest;

use App\Models\Lot;
use App\Models\Instrument;

use Input;
use Response;
use Auth;
use Session;
use Lang;

class LotController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Lists all lots
		$lots = Lot::all();
		return view('lot.index')->with('lots', $lots);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$instruments = Instrument::lists('name', 'id');
		return view('lot.create')->with('instruments', $instruments);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(LotRequest $request)
	{
		$lot = new Lot;
		$lot->number = $request->number;
		$lot->description = $request->description;
		$lot->expiry = $request->expiry;
		$lot->instrument_id = $request->instrument;

		$lot->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_lot', $lot ->id);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$lot = Lot::find($id);
		return view('lot.show')->with('lot', $lot);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$lot = Lot::find($id);
		$instruments = Instrument::lists('name', 'id');
		return view('lot.edit')->with('lot', $lot)->with('instruments', $instruments);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(LotRequest $request, $id)
	{
		$lot = Lot::find($id);
		$lot->number = $request->number;
		$lot->description = $request->description;
		$lot->expiry = $request->expiry;
		$lot->instrument_id = $request->instrument;

		$lot->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_lot', $lot ->id);
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
	 * Remove the specified lot from storage (global UI implementation).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Delete the lot
		$lot = Lot::find($id);
 
		$lot->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}