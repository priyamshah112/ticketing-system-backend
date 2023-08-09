<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Models\UI;
use App\Http\Controllers\Controller;
use App\Http\Helpers\FeederHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UIController extends Controller
{
    public function index(Request $request){
        $usefulInformations = UI::where("enable", 1)->orderBy("id", "ASC")->get();
        return $this->jsonResponse(['usefulInformations' => $usefulInformations], 1);
    }
    
    public function dashboard(Request $request){
        if(isset($request->category)){
            $usefulInformations = UI::where("enable", 1)->where('category', $request->category)->orderBy("created_at", "ASC")->limit(10)->get();            
        }
        else
        {
            $usefulInformations = UI::where("enable", 1)->orderBy("created_at", "ASC")->limit(10)->get();
        }
        return $this->jsonResponse(['usefulInformations' => $usefulInformations], 1);
    }

    public function add(Request $request)
    {
        $data = $request->all();

        $validator  = Validator::make($data,[
            'subject' => 'required',
            'category' => 'required',
            'operation' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $data['created_at'] = Carbon::now();
        
        if(isset($data['operation']) && $data['operation'] == 'add')
        {
            if($data['category'] == 'link')
            {
                $ui = UI::create([
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'link' => $data['link'],
                ]);
            }
            else if($data['category'] == 'file')
            {
                $path = '';
                if(!empty($request->file))
                {                
                    $p = $request->file->store('public/ui');
                    $path = Storage::url($p);
                }
                $ui = UI::create([
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'file' => $path,
                ]);
    
            }
            if($ui){
                return $this->sendSuccess("Useful Information Added Successfully!");
            }
        }
        else
        {
            $ui = UI::find($request->id);
            if(empty($ui))
            {
                $this->sendError("Not Found");
            }

            if($data['category'] == 'link')
            {
                $ui->update([
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'link' => $data['link'],
                    'file' => null,
                    'updated_at' => Carbon::now()
                ]);
            }
            else if($data['category'] == 'file')
            {
                $path = '';
                if(!empty($request->file))
                {                
                    $p = $request->file->store('public/ui');
                    $path = Storage::url($p);
                }
                $ui->update([
                    'subject' => $data['subject'],
                    'category' => $data['category'],
                    'link' => null,
                    'file' => $path,
                    'updated_at' => Carbon::now()
                ]);
    
            }
            if($ui){
                return $this->sendSuccess("Useful Information Updated Successfully!");
            }
        }
    }

    public function destroy(Request $request){  
        return FeederHelper::distroy($request, "UI", "UI", 2);
    }
}
