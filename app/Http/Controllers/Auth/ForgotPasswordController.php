<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Mail;
use App\User;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

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
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return ['status' => trans($response)];
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json(['email' => trans($response)], 400);
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
