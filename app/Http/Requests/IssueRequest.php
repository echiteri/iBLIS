<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Issue;

class IssueRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->ingnoreId();
		return [
            'issued_to' => 'required:issues, issued_to,'.$id,
			'quantity_issued' => 'required:issues, quantity_issued,'.$id,
			'batch_no' => 'required:issues, batch_no,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('issue');
		return Issue::where(compact('id'))->exists() ? $id : '';
	}
}