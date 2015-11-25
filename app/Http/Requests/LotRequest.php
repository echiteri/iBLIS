<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Lot;

class LotRequest extends Request {

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
            'number' => 'required|unique:lots,number,'.$id,
			'instrument' => 'required|non_zero_key'
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('lot');
		$number = $this->input('number');
		return Lot::where(compact('id', 'number'))->exists() ? $id : '';
	}
}