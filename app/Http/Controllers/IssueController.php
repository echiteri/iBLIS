<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\IssueRequest;

use App\Models\Issue;
use App\Models\TopupRequest;
use App\Models\Receipt;
use App\Models\User;
use App\Models\TestCategory;
use App\Models\Commodity;

use Response;
use Auth;
use Session;
use Lang;

class IssueController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$issues = Issue::all();
		return view('issue.index')->with('issues', $issues);
	}

	/**
	 * Show the form for dispatching the resource to the bench.
	 *
	 * @return Response
	 */
	public function dispatch($id)
	{
		$topupRequest = TopupRequest::find($id);
		$batches = Receipt::where('commodity_id', '=', $topupRequest->issue_id)->lists('batch_no', 'id');
		$users = User::where('id', '!=', Auth::user()->id)->lists('name', 'id');

		return view('issue.create')
				->with('topupRequest', $topupRequest)
				->with('users', $users)
				->with('batches', $batches);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(IssueRequest $request)
	{
		$issue = new Issue;
		$issue->receipt_id = $request->batch_no;
		$issue->topup_request_id = $request->topup_request_id;
		$issue->quantity_issued = $request->quantity_issued;
		$issue->issued_to = $request->receivers_name;
		$issue->remarks = $request->remarks;
		$issue->user_id = Auth::user()->id;
		$issue->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_issue', $issue ->id);
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
		//
		$issue = Issue::find($id);
		$commodities= Commodity::lists('name', 'id');
		$batches = Receipt::lists('batch_no', 'id');
		$users = User::where('id', '!=', Auth::user()->id)->lists('name', 'id');
		$sections = TestCategory::all()->lists('name', 'id');
		//To DO:create function for this
		$available = 0;
		return view('issue.edit')
			->with('commodities', $commodities)
			->with('available', $available)
			->with('users', $users)
			->with('sections', $sections)
			->with('issue', $issue)
			->with('batches', $batches);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(IssueRequest $request, $id)
	{
		$issue = Issue::find($id);
		$issue->receipt_id = $request->batch_no;
		$issue->topup_request_id = $request->topup_request_id;
		$issue->quantity_issued = $request->quantity_issued;
		$issue->issued_to = $request->issued_to;
		$issue->remarks = $request->remarks;
		$issue->user_id = Auth::user()->id;
		$issue->save();
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_issue', $issue ->id);
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
		$issue = Issue::find($id);
		$issue->delete();

		// redirect
		$url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
	}
}