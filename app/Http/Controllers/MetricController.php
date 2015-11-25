<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\MetricRequest;

use App\Models\Metric;

use Response;
use Auth;
use Session;
use Lang;

class MetricController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$metrics = Metric::orderBy('name', 'ASC')->get();
		return view('metric.index')->with('metrics', $metrics);
		//return view('inventory.metricsList');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('metric.create');
	}

	public function store(MetricRequest $request)
	{
		$metric = new Metric;
		$metric->name = $request->name;
		$metric->description = $request->description;
		$metric->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_metric', $metric ->id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$metric = Metric::find($id);

		//Open the Edit View and pass to it the $patient
		return view('metric.edit')->with('metric', $metric);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(MetricRequest $request, $id)
	{
		$metric = Metric::find($id);
		$metric->name = $request->name;
		$metric->description = $request->description;
		$metric->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_metric', $metric ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the patient
		$metric = Metric::find($id);
		$metric->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}
