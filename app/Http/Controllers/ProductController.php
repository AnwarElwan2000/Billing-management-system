<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Models\section;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get_section = section::get();
        $get_products = product::get();
        return view('products.products',compact('get_section','get_products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|max:255',
            'description' => 'required',
            'section_id' => 'required',
        ],[
            'product_name.required' => 'عفوا حقل المنتج فارغ',
            'description.required' => 'عفوا حقل الملاحظات فارغ',
            'section_id.required' => 'عفوا يجب اختيار القسم',
        ]);
      
        product::create([
            "product_name" => $request->product_name,
            "description" => $request->description,
            "section_id" => $request->section_id
        ]);

         session()->flash('Add',"تم اضافة المنتج بنجاح");
         return redirect('products');
        

    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       $section_id = section::where('Section_name',$request->section_name)->first()->id;
       $product_id =  product::find($request->pro_id);
       $product_id->update([
        "product_name" => $request->Product_name,
        "description" => $request->description,
        "section_id" => $section_id
       ]);

        session()->flash('edit','تم تعديل المنتج بنجاح');
        return redirect('products');

    }  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product_id = product::find($request->pro_id);
        $product_id->delete();
        session()->flash('destroy','تم حذف المنتج بنجاح');
        return back();
    }
}
