<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User;

class UserRequest extends Request {

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
            'full_name'   => 'required:users,name,'.$id,
            'username' => 'required|unique:users,username,'.$id,
            'password' => 'required:users,password,'.$id
        ];
	}
	/**
	* @return \Illuminate\Routing\Route|null|string
	*/
	public function ingnoreId(){
		$id = $this->route('user');
		$name = $this->input('full_name');
		return User::where(compact('id', 'name'))->exists() ? $id : '';
	}
}