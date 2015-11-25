<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ControlRequest;

use App\Models\Control;

use Response;
use Auth;
use Session;
use Lang;

class ControlController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$controls = Control::orderBy('id')->get();
		return view('control.index')->with('controls', $controls);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$lots = Lot::lists('number', 'id');
		$measureTypes = MeasureType::orderBy('id')->take(2)->get();

		return view('control.create')->with('lots', $lots) ->with('measureTypes', $measureTypes);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ControlRequest $request)
	{
		$control = new Control;
		$control->name = $request->name;
		$control->description = $request->description;
		$control->lot_id = $request->lot;

		if (Input::get('new-measures')) {
			$newMeasures = Input::get('new-measures');
			$controlMeasure = New ControlMeasureController;
			$controlMeasure->saveMeasuresRanges($newMeasures, $control);
		}
		$control->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_control', $control ->id);
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
		$lots = Lot::lists('number', 'id');
		$control = Control::find($id);
		$measureTypes = MeasureType::all();
		return view('control.edit')->with('control',$control)->with('lots', $lots)
				->with('measureTypes', $measureTypes);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ControlRequest $request, $id)
	{
		$$control = Control::find($id);
		$control->name = $request->name;
		$control->description = $request->description;
		$control->lot_id = $request->lot;

		if (Input::get('new-measures')) {
			$inputNewMeasures = Input::get('new-measures');
			$measures = New ControlMeasureController;
			$measureIds = $measures->saveMeasuresRanges($inputNewMeasures, $control);
		}

		if (Input::get('measures')) {
			$inputMeasures = Input::get('measures');
			$measures = New ControlMeasureController;
			$measures->editMeasuresRanges($inputMeasures, $control);
		}
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_control', $control ->id);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//Delete the control
		$control = Control::find($id);
		$control->delete();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}

	/**
	 * Return resultsindex page
	 *
	 * @return Response
	 */
	public function resultsIndex()
	{
		$controls = Control::all();
		return view('control.resultsIndex')->with('controls', $controls);
	}

	/**
	 * Return resultsindex page
	 *
	 * @return Response
	 */
	public function resultsEntry($controlId) 
	{
		$control = Control::find($controlId);
		return view('control.resultsEntry')->with('control', $control);
	}

	/**
	 * Return resultshow page
	 *
	 * @return Response
	 */

	public function resultsList($controlId)
	{
		$control = Control::find($controlId);
		return view('control.resultsList')->with('control',$control);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function resultsEdit($controlTestId)
	{
		$controlTest = ControlTest::find($controlTestId);
		return view('control.resultsEdit', compact('controlTest'));
	}

	/** 
	* Saves control results
	* 
	* @param Input, result inputs
	* @return Validation errors or response
	*/
	public function saveResults($controlId)
	{
		//Validate
		$control = Control::find($controlId);

		$controlTest = new ControlTest();
		$controlTest->entered_by = Auth::user()->id;
		$controlTest->control_id = $controlId;
		$controlTest->save();

		foreach ($control->controlMeasures as $controlMeasure) {
			$controlResult = new ControlMeasureResult;
			$controlResult->results = Input::get('m_'.$controlMeasure->id);
			$controlResult->control_measure_id = $controlMeasure->id;
			$controlResult->control_test_id = $controlTest->id;
			$controlResult->save();
		}
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1));
	}
}
