<?php

namespace App\Http\Controllers;

use App\Models\Product_Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product_Tag::orderBy('id', 'desc')->limit(3)->get();

        return view('home', [
            'products' => $products,
        ]);
    }
}
