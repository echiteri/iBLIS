<?php namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Requests\CommodityRequest;

use App\Models\Commodity;
use App\Models\Metric;

use Auth;
use Session;
use Lang;

class CommodityController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commodities = Commodity::all();
		return view('commodity.index')->with('commodities', $commodities);
	}


	public function create()
	{
		$metrics = Metric::orderBy('name', 'ASC')->lists('name', 'id');
		return view('commodity.create')->with('metrics', $metrics);
	}

	public function store(CommodityRequest $request)
	{
		$commodity = new Commodity;
		$commodity->name = $request->name;
		$commodity->description = $request->description;
		$commodity->metric_id = $request->unit_of_issue;
		$commodity->unit_price = $request->unit_price;
		$commodity->item_code = $request->item_code;
		$commodity->storage_req = $request->storage_req;
		$commodity->min_level = $request->min_level;
		$commodity->max_level = $request->max_level;

		$commodity->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_commodity', $commodity ->id);
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
		$metrics = Metric::orderBy('name', 'ASC')->lists('name', 'id');
		$commodity = Commodity::find($id);

		//Open the Edit View and pass to it the $commodity
		return view('commodity.edit')->with('metrics', $metrics)->with('commodity', $commodity);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(CommodityRequest $request, $id)
	{
		$commodity = Commodity::find($id);
		$commodity->name = $request->name;
		$commodity->description = $request->description;
		$commodity->metric_id = $request->unit_of_issue;
		$commodity->unit_price = $request->unit_price;
		$commodity->item_code = $request->item_code;
		$commodity->storage_req = $request->storage_req;
		$commodity->min_level = $request->min_level;
		$commodity->max_level = $request->max_level;

		$commodity->save();
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_commodity', $commodity ->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		//Soft delete the item
		$commodity = Commodity::find($id);
		$commodity->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}
