<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Models\FAQs;
use App\Http\Controllers\Controller;
use App\Http\Helpers\FeederHelper;
<<<<<<< HEAD
=======
use Carbon\Carbon;
>>>>>>> main

class FAQsController extends Controller
{
    public function index(Request $request){
        $faqs = FAQs::where("enable", 1)->get();
        $category = $this->collection2Array(FAQs::select('category')->where("enable", 1)->groupBy('category')->get(), "category");
        return $this->jsonResponse(['faqs' => $faqs, 'cateogry' => $category], 1);
    }
    
    public function dashboard(Request $request){
        $faqs = FAQs::where("enable", 1)->limit(10)->get();
        return $this->jsonResponse(['faqs' => $faqs ], 1);
    }

    public function collection2Array($collection, $key){
        $data = [];
        foreach($collection as $c){
            array_push($data, $c->$key);
        }
        return $data;
    }

    public function add(Request $request){
        $data = $request->all();
        $data['created_at'] = Carbon::now();
        $inventory = FeederHelper::add($data, "FAQs", "FAQs", [
            'question' => $data['question'],
            'answer' => $data['answer'],
        ], 2);
        if($inventory){
            if($data['operation'] == "add")
                return $this->jsonResponse([], 1,"FAQ Added Successfully!");
            else
                return $this->jsonResponse([], 1,"FAQ Updated Successfully!");
        }
        else{
            return $this->jsonResponse([], 2, "There is some internal error, Please try after sometime!");
        }
    }

    public function destroy(Request $request){  
        return FeederHelper::distroy($request, "FAQs", "FAQs", 2 , $request->enable, 2);
    }

}
