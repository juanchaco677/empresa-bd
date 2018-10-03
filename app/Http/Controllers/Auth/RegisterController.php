<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Campana;
use App\CampanaUsuarios;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'elecciones' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user=new User();
        $user->name= $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->type = $data['type'];
        $user->save();
        $campana=new Campana();
        $campana->elecciones=$data['elecciones'];
        $campana->id_candidato=$user->id;
        $campana->id_ano=1;
        $campana->id_mes=1;
        $campana->dia=30;
        $campana->save();
        $campanaUsuarios=new CampanaUsuarios();
        $campanaUsuarios->id_campana=$campana->id;
        $campanaUsuarios->id_user=$user->id;
        return $user;

    }
}
