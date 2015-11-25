<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\ReceiptRequest;

use App\Models\Receipt;
use App\Models\Supplier;
use App\Models\Commodity;

use Response;
use Auth;
use Session;
use Lang;

class ReceiptController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$receipts = Receipt::all();
		return view('receipt.index')->with('receipts', $receipts);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$commodities = receipt::lists('name', 'id');
		$suppliers = Supplier::lists('name', 'id');
		return view('receipt.create')
				->with('commodities', $commodities)
				->with('suppliers', $suppliers);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ReceiptRequest $request)
	{
		$receipt = new Receipt;
		$receipt->commodity_id = $request->commodity;
		$receipt->supplier_id = $request->supplier;
		$receipt->quantity = $request->quantity;
		$receipt->batch_no = $request->batch_no;
		$receipt->expiry_date= $request->expiry_date;
		$receipt->user_id= Auth::user()->id;

		$receipt->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_receipt', $receipt ->id);
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
		$receipt = Receipt::find($id);
		$suppliers = Supplier::lists('name', 'id');
		$commodities = Commodity::lists('name', 'id');

		return view('receipt.edit')
				->with('receipt', $receipt)
				->with('commodities', $commodities)
				->with('suppliers', $suppliers);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ReceiptRequest $request, $id)
	{
		$receipt = Receipt::find($id);
		$receipt->commodity_id = $request->commodity;
		$receipt->supplier_id = $request->supplier;
		$receipt->quantity = $request->quantity;
		$receipt->batch_no = $request->batch_no;
		$receipt->expiry_date= $request->expiry_date;
		$receipt->user_id= Auth::user()->id;

		$receipt->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_receipt', $receipt ->id);
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
		$receipt = Receipt::find($id);
		$receipt->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}