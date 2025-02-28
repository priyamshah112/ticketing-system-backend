<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\UserDetails;
use App\Models\ErrorLog;
use App\Models\User;
use App\Traits\ExceptionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProfileController extends Controller
{

    use ExceptionLog;

    public function viewProfile(Request $request)
    {
        try{
            $userDetail = User::with('userDetails')->find($request->user()->id);
            return ProfileResource::make($userDetail)->additional(['success' => true]);
        } catch (\Exception $ex) {
            $this->exceptionHandle($ex, 'viewProfile');
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }
    }

    public function updateProfile(Request $request)
    {
        $userid = $request->user()->id;
        try{
            $validator = Validator::make($request->all(), [
                "image_name" => "required|file|max:512",
            ]);

            if ($validator->fails()) {
                $responseArr['success'] = false;
                $responseArr['message'] = $this->errorMessages($validator);
                return response()->json($responseArr, 422);
            }

            $image = $request->image_name;
            $now = Carbon::now()->format('YmdHis');


            if ($image)
            {
                $photoExtention = $image->getClientOriginalExtension();
                $photo_name = $now.'.'.$photoExtention;
                $image->storeAs('/public/image', $photo_name);
            }
            else
            {
                $photo_name = "";
            }

            $userData = [
                'image_name' => $photo_name,
            ];
            UserDetails::where('user_id',$userid)->update($userData);

            return response()->json(['success' => true, 'message' => 'Profile Updated']);
        } catch (\Exception $ex) {
            $this->exceptionHandle($ex, 'updateProfile');
            return response()->json(['success' => false, 'message' => ErrorLog::ExceptionMessage]);
        }

       } 
}
