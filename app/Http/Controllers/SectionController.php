<?php

namespace App\Http\Controllers;

use App\Models\section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get_section = section::get();
        return view('Section.section',compact('get_section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        $validated = $request->validate([
            'Section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
        ],[
            'Section_name.required' => "عفوا يجب ملى حقل القسم",
            'Section_name.unique' => "عفوا هذا القسم موجود بالفعل",
            'description.required' => "عفوا يجب ملى حقل البيان",
        ]);
       
    section::create([ 
        "Section_name" => $request->Section_name,
        "description" =>  $request->description,
        "Created_by" => auth()->user()->name,
    ]);
      
    session()->flash('add','تم اضافة القسم بنجاح');
    return redirect('/section');

 
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
      
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
         $id = $request->id;
         $validated = $request->validate([
            'section_name' => 'required|max:255|unique:sections,Section_name,'.$id,
            'description' => 'required',
        ],[
            'section_name.required' => "عفوا يجب ملى حقل القسم",
            'section_name.unique' => "عفوا هذا القسم موجود بالفعل",
            'description.required' => "عفوا يجب ملى حقل البيان",
        ]);

        $section_updated = section::find($id);
        $section_updated->update([
           "Section_name" => $request->section_name,
           "description" => $request->description
        ]);

        session()->flash('edit','تم التعديل بنجاح');
        return redirect('section');



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        section::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('section');
    
    }
}
