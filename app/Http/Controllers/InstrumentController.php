<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\InstrumentRequest;

use App\Models\Instrument;
use Config;
use Response;
use Auth;
use Session;
use Lang;

/**
 *Contains functions for managing instruments
 *
 */
class InstrumentController extends Controller {

	/**
	 * Display a listing of the instruments.
	 *
	 * @return Response
	 */
	public function index()
	{
		// List all the active instruments
			$instruments = Instrument::paginate(Config::get('kblis.page-items'));

		// Load the view and pass the instruments
		return view('instrument.index')->with('instruments', $instruments);
	}

	/**
	 * Show the form for creating a new instrument.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Get a list of all installed plugins
		$plugins = Instrument::getInstalledPlugins();

		//Create Instrument view
		return view('instrument.create')->with('instruments', $plugins);
	}

	/**
	 * Store a newly created instrument in storage.
	 *
	 * @return Response
	 */
	public function store(InstrumentRequest $resquest)
	{
		$newInstrument = new Instrument();
		$newInstrument->name = $resquest->name;
		$newInstrument->description = $resquest->description;
		$newInstrument->ip = $resquest->ip;
		$newInstrument->hostname = $resquest->hostname;

		$newInstrument->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_instrument', $newInstrument ->id);
	}

	/**
	 * Display the specified instrument.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//Show an instrument
		$instrument = Instrument::find($id);

		//Show the view and pass the $instrument to it
		return view('instrument.show')->with('instrument', $instrument);
	}

	/**
	 * Show the form for editing the specified instrument.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//Get the instrument
		$instrument = Instrument::find($id);

		//Open the Edit View and pass to it the $instrument
		return view('instrument.edit')->with('instrument', $instrument);
	}

	/**
	 * Update the specified instrument.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(InstrumentRequest $resquest, $id)
	{
		$instrument = Instrument::find($id);
		$instrument->name = $resquest->name;
		$instrument->description = $resquest->description;
		$instrument->ip = $resquest->ip;
		$instrument->hostname = $resquest->hostname;
		$instrument->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_instrument', $instrument ->id);
	}

	/**
	 * Remove the specified instrument from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * Remove the specified instruments from storage (global UI implementation).
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Delete the instrument
		$instrument = Instrument::find($id);
 
		$instrument->testTypes()->detach();
		$instrument->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}

	/**
	 * Pull test results from an instrument as JSON.
	 *
	 * @return Response
	 */
	public function getTestResult()
	{
		//Get Instrument Interface Class file
		$testTypeID = Input::get("test_type_id");
		$testType = TestType::find($testTypeID);
		$instrument = $testType->instruments->first();

 		// Fetch the results
		return $instrument->fetchResult($testType);
	}

	/**
	 * Save an imported implemention of the Intrumentation class.
	 *
	 * @param String route
	 * @return Response
	 */
	public function importDriver()
	{
		$route = (Input::get('import_file') !== null)?Input::get('import_file'):"instrument.index";

        $rules = array(
            'import_file' => 'required|max:500'
        );

        $validator = Validator::make(Input::all(), $rules);
        $message = null;

        if ($validator->fails()) {
            return Redirect::route('instrument.index')->withErrors($validator);
        } else {
            if (Input::hasFile('import_file')) {
            	$message = Instrument::saveDriver(Input::file('import_file'));
            }
        }

		return Redirect::route($route)->with('message', $message);
	}
}