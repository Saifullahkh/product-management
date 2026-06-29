<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    function totalProduct(){
        $totalData = Product::count();

        $totalStock = Product::sum('stock');

        $totalInventory = Product::sum(DB::raw('stock * price'));

        $totalCategory = Category::count();

        return view('welcome', compact('totalData','totalStock','totalInventory','totalCategory'));
    }

}
