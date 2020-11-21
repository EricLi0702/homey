<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravolt\Avatar\Avatar;
use App\Building;
use Mail;
use DateTime;

class RegisterController extends Controller
{
    use RegistersUsers;

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
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function registered(Request $request, User $user)
    {
        if ($user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();

            return response()->json(['status' => trans('verification.sent')]);
        }

        return response()->json($user);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            // 'phone' => 'required|regex:/(01)[0-9]{9}/',
            'phone' => 'required',
            'password' => 'required|min:6|confirmed',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phoneNumber' => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function verify(Request $request){
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $user = User::where('email', '=', $email)->where('phoneNumber', '=', $phone)->first();
        if ($user == null) {

            return response()->json([
                'msg' => 'user not found'
            ], 401);
        }
        else{
            $isExist = false;
            //Verification email with code to User
            $to_name = $user->name;
            $to_email = $user->email;
            $code = mt_rand(100000, 999999);
            $user['vercode'] = $code;
            $user->save();

            $data = array(
                'name' => 'Please confirm your code', 
                'body' => $code,
            );
            
            Mail::send('emails.verification', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                        ->subject('Homey Verify Email');
                $message->from('test@testservice.com','Homey');
            });

            $building = Building::where([['id', '=', $user->buildingId]])->first();

            return response()->json([
                'msg' => 'ok',
                'dong' => $building->number,
                'ho' => $user->ho
            ], 200);
             
        }
    }

    public function verifycode(Request $request){
        $verCode = $request->code;
        $userData = $request->userData;
        $name = $userData['name'];
        $email = $userData['email'];
        $phone = $userData['phone'];

        $user = User::where('email', '=', $email)->where('phoneNumber', '=', $phone)->first();
        if($verCode == $user['vercode']){
            //email verified (in here we can make user email verified.)
            $dt = new DateTime();
            $dt->format('Y-m-d H:i:s');
            $user['email_verified_at'] = $dt;
            $user->save();
            return response()->json([
                'msg' => 'ok'
            ], 200);
        }
        else{
            return response()->json([
                'msg' => 'verification code is incorrect!'
            ], 401);
        }
    }

    public function setpassword(Request $request){
        $password = $request->password;
        $userData = $request->userData;
        $name = $userData['name'];
        $email = $userData['email'];
        $phone = $userData['phone'];
        $user = User::where('email', '=', $email)->where('phoneNumber', '=', $phone)->first();
        $user['password'] = bcrypt($password);
        $user->save();
        return response()->json([
            'msg' => 'ok'
        ], 200);
    }


    public function verifycodeResetPass(Request $request){
        $verCode = $request->code;
        $email = $request->userEmail;

        $user = User::where('email', '=', $email)->first();
        if($verCode == $user['vercode']){
            return response()->json([
                'msg' => 1
            ], 200);
        }
        else{
            return response()->json([
                'msg' => 0
            ], 401);
        }
    }

    public function setpasswordResetPass(Request $request){
        $password = $request->password;
        $email = $request->userEmail;
        $user = User::where('email', '=', $email)->first();
        $user['password'] = bcrypt($password);
        $user->save();
        return response()->json([
            'msg' => 'ok'
        ], 200);
    }

    public function sendResetCodeToEmail(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', '=', $email)->first();
        if ($user == null) {
            return response()->json([
                'msg' => 0
            ], 404);
        }
        if ($user->email_verified_at == null){
            return response()->json([
                'msg' => 1
            ], 422);
        }
        else{
            //Verification email with code to User
            $to_name = $user->name;
            $to_email = $user->email;
            $code = mt_rand(100000, 999999);
            $user['vercode'] = $code;
            $user->save();

            $data = array(
                'name' => 'Please confirm your code', 
                'body' => $code,
            );
            
            Mail::send('emails.verification', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                        ->subject('Homey Verify Email');
                $message->from('test@testservice.com','Homey');
            });

            return response()->json([
                'msg' => 2
            ], 200);
             
        }
    }
}
