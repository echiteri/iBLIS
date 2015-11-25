<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\SupplierRequest;

use App\Models\Supplier;

use Response;
use Auth;
use Session;
use Lang;

class SupplierController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		 $suppliers = Supplier::orderBy('name', 'ASC')->get();
		return view('supplier.index')->with('suppliers', $suppliers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('supplier.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SupplierRequest $request)
	{
		$supplier = new Supplier;
		$supplier->name = $request->name;
		$supplier->phone_no = $request->phone_no;
		$supplier->email = $request->email;
		$supplier->physical_address = $request->physical_address;
		$supplier->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_supplier', $supplier ->id);
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
		$suppliers = Supplier::find($id);

		//Open the Edit View and pass to it the $patient
		return view('supplier.edit')->with('suppliers', $suppliers);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(SupplierRequest $request, $id)
	{
		$supplier = Supplier::find($id);
		$supplier->name = $request->name;
		$supplier->phone_no = $request->phone_no;
		$supplier->email = $request->email;
		$supplier->physical_address = $request->physical_address;
		$supplier->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_supplier', $supplier ->id);		
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
		$supplier = Supplier::find($id);
		$supplier->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}
