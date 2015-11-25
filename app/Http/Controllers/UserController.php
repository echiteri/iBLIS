<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\UserRequest;

use App\Models\User;

use Input;
use Response;
use Auth;
use Session;
use Lang;
/**
 *Contains functions for managing users 
 *
 */
class UserController extends Controller {
    
    //Function for user authentication logic
    public function loginAction(){

        if (Input::server("REQUEST_METHOD") == "POST") 
        {
            $validator = Validator::make(Input::all(), array(
                "username" => "required|min:4",
                "password" => "required|min:6"
            ));

            if ($validator->passes())
            {
                $credentials = array(
                    "username" => Input::get("username"),
                    "password" => Input::get("password")
                    );

                if(Auth::attempt($credentials)){
                    return Redirect::route("user.home");
                }

            }
            return Redirect::route('user.login')->withInput(Input::except('password'))
                ->withErrors($validator)
                ->with('message', trans('messages.invalid-login'));
        }

        return view("user.login");
    }

    public function logoutAction(){
        Auth::logout();
        return Redirect::route("user.login");
    }

    public function homeAction(){
        return view('user.home');
    }


    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        // List all the active users
            $users = User::orderBy('name', 'ASC')->get();

        // Load the view and pass the users
        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //Create User
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $user = new User;
        $user->username = $request->username;
        $user->name = $request->full_name;
        $user->gender = $request->gender;
        $user->designation = $request->designation;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
        $id = $user->id;

        if (Input::hasFile('image')) {
            try {
                $extension = Input::file('image')->getClientOriginalExtension();
                $destination = public_path().'/i/users/';
                $filename = "user-$id.$extension";

                $file = Input::file('image')->move($destination, $filename);
                $user->image = "/i/users/$filename";

            } catch (Exception $e) {}
        }
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_user', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //Show a user
        $user = User::find($id);

        //Show the view and pass the $user to it
        return view('user.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //Get the user
        $user = User::find($id);

        //Open the Edit View and pass to it the $user
        return view('user.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(UserRequest $request, $id)
    {
        dd($request);
        $user = User::find($id);
        $user->username = $request->username;
        $user->name = $request->full_name;
        $user->gender = $request->gender;
        $user->designation = $request->designation;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();
        $id = $user->id;

        if (Input::hasFile('image')) {
            try {
                $extension = Input::file('image')->getClientOriginalExtension();
                $destination = public_path().'/i/users/';
                $filename = "user-$id.$extension";

                $file = Input::file('image')->move($destination, $filename);
                $user->image = "/i/users/$filename";

            } catch (Exception $e) {}
        }
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-saved', 1))->with('active_user', $user ->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function updateOwnPassword($id)
    {
        //
        $rules = array(
            'current_password' => 'required|min:6',
            'new_password'  => 'confirmed|required|min:6',
        );

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::route('user.edit', array($id))->withErrors($validator);
        } else {
            // Update
            $user = User::find($id);
            // change password if parameters were entered (changing ones own password)
            if (Hash::check(Input::get('current_password'), $user->password))
            {
                $user->password = Hash::make(Input::get('new_password'));
            }else{
                return Redirect::route('user.edit', array($id))
                        ->withErrors(trans('messages.incorrect-current-passord'));
            }

            $user->save();
        }

        // redirect
        $url = Session::get('SOURCE_URL');
            
        return Redirect::to($url)->with('message', trans('messages.user-profile-edit-success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage (soft delete).
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
        //Soft delete the user
        $user = User::find($id);

        $user->delete();

        // redirect
        $url = session('SOURCE_URL');

        return redirect()->to($url)->with('message', Lang::choice('messages.record-successfully-deleted', 1));
    }
}
