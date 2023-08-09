<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        return $this->jsonResponse($categories, 1);
    }
}
