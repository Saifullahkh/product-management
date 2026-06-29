<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    function getCategory(){
        $getData = Category::all();
        return view('category',['categories'=>$getData]);
    }


    function addCategory(Request $request){

        $request->validate([
            'categoryName'=>'required | min:3'
        ]);

        $category = new Category();
        $category->name = $request->categoryName;

        if($category->save()){
            return redirect()->route('categories');
        }else{
            return "Error saving category";
        }
    }


    function deleteCategory($id){
        $deleteData = Category::destroy($id);

        if($deleteData){
            return redirect('category');
        }else{
            return "Error deleting category";
        }
        
    }


    function editCategory(Request $request,$id){
        $category = Category::find($id);
        $category->name = $request->categoryName;

        if($category->save()){
            return redirect('category');
        }else{
            return "Error updating category";
        }
    }

}
