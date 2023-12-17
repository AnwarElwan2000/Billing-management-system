<?php

namespace App\Http\Controllers;

use App\Models\invoice_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
       
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
            'file_name' => 'required|mimes:png,jpeg,gif,jpg,pdf',
        ],[
            'file_name.required' => 'عفوا يجب رفع المرفق',
            'file_name.mimes' => 'عفوا صيغ الملف يجب ان تكون jpg , jpeg , png , pdf',
        ]);



        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();

        $InvoiceAttachment =  new invoice_attachment();
        $InvoiceAttachment->file_name = $file_name;
        $InvoiceAttachment->invoice_number = $request->invoice_number;
        $InvoiceAttachment->invoice_id = $request->invoice_id;
        $InvoiceAttachment->Created_by = auth()->user()->name;
        $InvoiceAttachment->save();

        $imge_name = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/' . $request->invoice_number) , $imge_name);

        session()->flash('add_attachments','تم اضافة المرفق بنجاح');
        return back();
 
    }

    /**
     * Display the specified resource.
     */
    public function show(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_attachment $invoice_attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoice_attachment $invoice_attachment)
    {
        //
    }

        public function show_file($invoice_number,$file_name){
  
       return "<img src='".asset('Attachments/' . $invoice_number . '/' . $file_name)."'>";
        }

    public function download($invoice_number,$file_name){
 
      $file_download = Storage::disk('file_controll')->download($invoice_number . '/' . $file_name);
      return $file_download;

    }


    public function delete_file(Request $request){
       $invoice_attachment = invoice_attachment::findOrFail($request->id_file);
       $invoice_attachment->delete();
       Storage::disk('file_controll')->delete($request->invoice_number . '/' .$request->file_name);
       session()->flash('Delete_file');
       return back();
    }


    
}
