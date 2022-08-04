<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Http\Controllers\APIs\BaseController as BaseController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\User;
use DB;
use Message;
use App\Http\Helpers\FeederHelper;
use URL;

class AuthController extends BaseController
{
   /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user_id = Auth::user()->id;
            $user = User::where("id", $user_id)->with('userRole.roleAccess.manager', "userDetails")->first();
            if($user->enable == 2){
                return $this->jsonResponse([], 2, 'Account is suspended!');
            }
            else{
                //$data['data'] =  $user;
                $this->createTrail(0, 'User', 99);
                $user->enable = 1;
                $user->save();
                $user['token'] =  $user->createToken('MyApp')->accessToken;
                return $this->jsonResponse($user, 1, 'User login successfully.');
            }

        }
        else{
            return $this->jsonResponse([], 2, 'Username or Password is incorred!');
        }
    }

    public function reset_password(Request $request)
    {
        //$request->validate($this->rules(), $this->validationErrorMessages());


        $validator = Validator::make($request->all(), [
            'token' => ['required', 'max:255'],
            'password' => ['required', 'min:8'],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.

        if ($validator->fails()){
            $errors = $this->errorsArray($validator->errors()->toArray());
            return $this->jsonResponse([], 0, implode(",", $errors));
        }

        
        $entry =  DB::select("SELECT * FROM `password_resets` where email = '". $request->email . "' and token = '".$request->token."'");
        //dd($entry);
        if($entry){
            $user = User::where("email", $request->email)->first();//
            //dd($user);
            // if($request->has('userType') && $request->userType == "user"){
            //     $CustomerDetails = FeederHelper::add($request->all(), "CustomerDetails", "CustomerDetails", ['user_id' => $user->id], 2);
            // }

            if($user){
               $op = $user->update(['password'=> bcrypt($request->password)]);
               if($op){
                $delete = DB::select("DELETE FROM `password_resets` where email = '". $request->email . "' and token = '".$request->token."'");
                return $this->jsonResponse($user, 1, 'Password is updated successfully.');
               }
               else{
                return $this->jsonResponse([], 2, 'Operation failed, Please try again!');
               }
            }
            return $this->jsonResponse([], 2, 'User not found!');
        }
        else{
            return $this->jsonResponse([], 2, 'Operation failed, Token expired!');
        }
    }


    // public function forgot() {
    //     $credentials = request()->validate(['email' => 'required|email']);

    //     // $user = User::where("email", $credentials['email'])
    //     // dd($credentials);

    //     $resetLink = Password::sendResetLink($credentials);
    //     dd($resetLink);
    //     return response()->json(["msg" => 'Reset password link sent on your email id.']);
    // }

    public function forgot_password(Request $request){
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $arr=[];
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return $this->jsonResponse([], 2, $validator->errors()->first());
        } else {
            try {
                $user = User::where("email", $request->email)->first();
                if($user){
                    $data['user'] = $user;
                    $token = User::getToken($user);
                    $data['resetLink'] = 'http://'.$request->url.'/reset-password?token='.$token.'&email='.$user->email;
                    $data['baseURL'] = URL::to('/');
                    $data = array(
                        'view' => 'mails.forgetPasswordRequest',
                        'subject' => 'Welcome to RX!',
                        'subject' => 'Password Reset Request!',
                        'to' => $user->email,
                        'reciever' => 'To '.$user->name,
                        'data' => $data
                    );
                    //dd($data);

                    $this->sendMail($data);
                    return $this->jsonResponse([], 1, "Password reset link is sent!");
                }
                else{
                    return $this->jsonResponse([], 2, "User is not match with our system entries!");
                }
            }
            catch (Exception $ex) {
                return $this->jsonResponse([], 2, $ex->getMessage());
            }
        }
        return \Response::json($arr);
    }

}
