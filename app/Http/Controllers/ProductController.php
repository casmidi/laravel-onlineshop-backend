<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::paginate(5);
        return view('pages.product.index',compact('products'));
    }

   //create
   public function create()
   {
       $categories = \App\Models\Category::all();
       return view('pages.product.create',compact('categories'));
   }

   //store
   public function store(Request $request)
   {
       $filename = uniqid() . '.' . $request->image->extension();
       $request->image->storeAs('public/produts', $filename);

       $product = new \App\Models\Product;
       $product->description = '' ;
       $product->name = $request->name;
       $product->price = (int) $request->price;
       $product->stock = (int) $request->stock;
       $product->category_id = $request->category_id;
       $product->image = $filename;
       $product->save();

       return redirect()->route('product.index');

   }


    //edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.product.edit',compact('product'));
    }

    //update
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $product = Product::findOrFail($id);

        $product->update($data);
        return redirect()->route('product.index');
    }

    //show
    public function show($id)
    {
        return view('pages.dashboard');
    }


    //destroy
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index');
    }

}
