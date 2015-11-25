<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\TopUpRequestRequest;

use App\Models\TopupRequest;
use App\Models\TestCategory;
use App\Models\Receipt;
use App\Models\Commodity;

use Response;
use Auth;
use Session;
use Lang;

class TopUpController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$topupRequests = TopupRequest::all();
		return view('topup.index')->with('topupRequests', $topupRequests);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$receipts = Receipt::all();
		$commodities = Commodity::has('receipts')->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');

		return view('topup.create')
			->with('receipts', $receipts)
			->with('sections', $sections)
			->with('commodities', $commodities);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TopupRequestRequest $request)
	{
		$labTopup = new TopupRequest;
		$labTopup->commodity_id = $request->commodity;
		$labTopup->test_category_id = $request->lab_section;
		$labTopup->order_quantity = $request->order_quantity;
		$labTopup->remarks = $request->remarks;
		$labTopup->user_id = Auth::user()->id;
		$labTopup->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_topUp', $labTopup ->id);
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
		$topupRequest = TopupRequest::find($id);
		$commodities = Commodity::has('receipts')->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');
		return view('topup.edit')
			->with('topupRequest', $topupRequest)
			->with('sections', $sections)
			->with('commodities', $commodities);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(TopupRequestRequest $request, $id)
	{
		$labTopup = TopupRequest::find($id);
		$labTopup->commodity_id = $request->commodity;
		$labTopup->test_category_id = $request->lab_section;
		$labTopup->order_quantity = $request->order_quantity;
		$labTopup->remarks = $request->remarks;
		$labTopup->user_id = Auth::user()->id;
		$labTopup->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_topUp', $labTopup ->id);
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
		$topUp = TopupRequest::find($id);
		$topUp->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}

	/**
	* for autofilling issue form, from db data
	*/
	public function availableStock($id){
		$receipt = TopupRequest::find($id)->available();
		return Response::json(array('availableStock' => $receipt));
	}
}
