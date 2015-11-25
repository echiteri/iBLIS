<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TopupRequest;

class TopUpRequestRequest extends Request {

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
            'commodity' => 'required:topup_requests,commodity_id,'.$id,
			'lab_section' => 'required:topup_requests,test_category_id,'.$id,
			'order_quantity' => 'required:topup_requests,order_quantity,'.$id,
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('topup');
		return TopupRequest::where(compact('id'))->exists() ? $id : '';
	}
}