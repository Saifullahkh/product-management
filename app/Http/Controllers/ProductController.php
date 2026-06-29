<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    function getProduct(){

        $category = Category::all();

        $getData = Product::with('category')->get();
        return view('product', [
        'categories' => $category,
        'products'   => $getData
    ]);
    }

    function addProduct(Request $request){


        $request->validate([
            'productName' => 'required | min:3 | max:30',
            'selectCategory' => 'required',
            'price' => 'required | numeric | min:1',
            'stock' => 'required | integer | min:1',
            'image' => 'required | image | mimes:jpeg,png,jpg,gif,svg | max:2048'
        ],[
            'productName.required' => 'Product name must be required',
            'productName.min' => 'Product name must be at least 3 characters',
            'productName.max' => 'Product name must not exceed 30 characters',
        ]);


        if ($request->update && $request->id) {
            $product = Product::find($request->id);
            if (! $product) {
                return redirect()->route('products');
            }
        } else {
            $product = new Product;
        }

        $product->name = $request->productName;
        $product->category_id = $request->selectCategory;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads','public');
            $pathName = explode('/', $path);
            $product->image = $pathName[1];
        } elseif (! isset($product->image) && $request->update) {
            $product->image = Product::find($request->id)->image ?? null;
        }

        if($product->save()){
            return redirect()->route('products');
        }

    }

   
    function deleteProduct($id){
        $deleteData = Product::destroy($id);

        if($deleteData){
            return redirect('product');
        }else{
            return "Data cannot deleted..";
        }
    }


    function updateProduct(Request $request,$id){
        $updateData = Product::find($id);
        $updateData->image = $request->image;
        $updateData->name = $request->productName;
        $updateData->category_id = $request->selectCategory;
        $updateData->price = $request->price;
        $updateData->stock = $request->stock;
        
        if($updateData->save()){
            return redirect()->route('products');
        }
    }

}
