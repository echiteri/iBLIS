<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Control;

use Response;
use Auth;
use Session;
use Lang;

class ControlRequest extends Request {

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
			'name'   => 'required|unique:controls,name,'.$id,
			'lot'   => 'required|non_zero_key:controls,lot,'.$id,
			'new-measures'   => 'required',
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('control');
		$name = $this->input('name');
		return Control::where(compact('id', 'name'))->exists() ? $id : '';
	}
}