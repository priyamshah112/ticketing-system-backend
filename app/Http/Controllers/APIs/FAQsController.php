<?php

namespace App\Http\Controllers\APIs;

use Illuminate\Http\Request;
use App\Models\FAQs;
use App\Http\Controllers\Controller;
use App\Http\Helpers\FeederHelper;

class FAQsController extends Controller
{
    public function index(Request $request){
        $faqs = FAQs::where("enable", 1)->get();
        $category = $this->collection2Array(FAQs::select('category')->where("enable", 1)->groupBy('category')->get(), "category");
        return $this->jsonResponse(['faqs' => $faqs, 'cateogry' => $category], 1);
    }

    public function collection2Array($collection, $key){
        $data = [];
        foreach($collection as $c){
            array_push($data, $c->$key);
        }
        return $data;
    }

    public function add(Request $request){
        $inventory = FeederHelper::add($request->all(), "FAQs", "FAQs", [], 2);
        if($inventory){
            if($request->operation == "add")
                return $this->jsonResponse([], 1,"FAQ Added Successfully!");
            else
                return $this->jsonResponse([], 1,"FAQ Updated Successfully!");
        }
        else{
            return $this->jsonResponse([], 2, "There is some internal error, Please try after sometime!");
        }
    }

    public function distroy(Request $request){  
        return FeederHelper::distroy($request, "FAQs", "FAQs", 2 , $request->enable, 2);
    }

}
