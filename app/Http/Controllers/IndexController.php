<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use App\Category;
use App\Product;

class IndexController extends Controller
{
   public function index()
   {
       $banners = Banner::where('status','1')->orderBy('sort_order','asc')->get();
       $categories = Category::with('categories')->where(['parent_id'=>0])->get();
       $products = Product::get();
       return view('wayshop.index')->with(compact('banners','categories','products'));
   }

   public function categories($category_id)
   {
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        $products = Product::where(['category_id'=>$category_id])->get();
        $product_name = Product::where(['category_id'=>$category_id])->first();
        return view('wayshop.category')->with(compact('categories','products','product_name'));
   }

   public function home()
   {
       $banners = Banner::where('status','1')->orderBy('sort_order','asc')->get();
       $categories = Category::with('categories')->where(['parent_id'=>0])->get();
       $products = Product::get();
       return view('wayshop.index')->with(compact('banners','categories','products'));
   }
}
