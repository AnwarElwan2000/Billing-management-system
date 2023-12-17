<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use App\Notifications\Add_Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Invoice;
use App\Models\User;
use App\Models\invoice_details;
use App\Models\invoice_attachment;
use App\Models\section;
use App\Models\ProductController;
use Illuminate\Http\Request;
use App\Notifications\Create_Invoice;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Invoices = Invoice::get();
        return view('Invoices.Invoices',compact('Invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $sections = section::get();
       return view('Invoices.add_invoices',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Invoice::create([
          "invoice_number" => $request->invoice_number,
          "invoice_Date" => $request->invoice_Date,
          "Due_date" => $request->Due_date,
          "product" => $request->product,
          "section_id" => $request->Section,
          "Amount_collection" => $request->Amount_collection,
          "Amount_Commission" => $request->Amount_Commission,
          "Discount" => $request->Discount,
          "Value_VAT" => $request->Value_VAT,
          "Rate_VAT" => $request->Rate_VAT,
          "Total" => $request->Total,
          "Status" => "غير مدفوعة",
          "Value_Status" => 2,
          "note" => $request->note
        ]);

       $Invoice_Id = Invoice::latest()->first()->id;
       invoice_details::create([
        "invoice_number" => $request->invoice_number,
        "id_Invoice" => $Invoice_Id,
        "product" =>$request->product,
        "Section" =>$request->Section,
        "Status" =>"غير مدفوعة",
        "Value_Status" => 2,
        "note" =>$request->note,
        "user" => (auth()->user()->name)
       ]);

    

        if($request->hasfile('pic')) {
            $Invoice_Id = Invoice::latest()->first()->id;
            $img = $request->file('pic');
            $file_name = $img->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $Attachments = new invoice_attachment();
            $Attachments->file_name =  $file_name;
            $Attachments->invoice_number = $invoice_number;
            $Attachments->Created_by = auth()->user()->name;
            $Attachments->invoice_id = $Invoice_Id;
            $Attachments->save();
      
            $imge_name = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number) ,$imge_name );
        }


        // Send Mail To User

      //  $user = User::first();
      //  Notification::send($user, new Add_Invoice($Invoice_Id,$user->name));
      
     

      $user = User::find(1);

      $user->notify(new Create_Invoice($Invoice_Id));

     
      session()->flash('Add');
      return back();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      $Invoices = Invoice::where('id',$id)->first();
      return view('Invoices.invoice_update_status',compact('Invoices'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id)->first();
        $sections = section::get();
        return view('invoices.edit_invoices',compact('invoice','sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
      $invoice = Invoice::findOrFail($request->invoice_id);
      $invoice->update([
        'invoice_number' => $request->invoice_number,
        'invoice_Date' => $request->invoice_Date,
        'Due_date' => $request->Due_date,
        'product' => $request->product,
        'section_id' => $request->Section,
        'Amount_collection' => $request->Amount_collection,
        'Amount_Commission' => $request->Amount_Commission,
        'Discount' => $request->Discount,
        'Value_VAT' => $request->Value_VAT,
        'Rate_VAT' => $request->Rate_VAT,
        'Total' => $request->Total,
        'note' => $request->note,
      ]);
    
      session()->flash('edit_invoices','تم تعديل الفاتورة بنجاح');
      return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       $id = $request->invoice_id;
       $Invoices = Invoice::where('id',$id)->first();
       $invoice_attahment = invoice_attachment::where('invoice_id' ,$id)->first();

       if(!$request->id_page == 2){

        if(!empty($invoice_attahment->invoice_number)){
          Storage::disk('file_controll')->deleteDirectory($invoice_attahment->invoice_number);
         }

         $Invoices->forceDelete();
         session()->flash('delete_invoices');
         return redirect('/Invoices');

       }else{
        $Invoices->delete();
        session()->flash('invoice_Archives');
        return redirect('/invoice_Archives');

       }

   }
     
    public function get_products($id) {
       $products = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
       return $products;
    }

    public function status_update($id ,Request $request){
 
     $invoice = Invoice::findOrFail($id);

     if($request->status === 'مدفوعة') {
      $invoice->update([
        'Status' => $request->status,
        'Value_Status' => 1,
        'Payment_Date' => $request->Payment_Date
      ]);
       
      invoice_details::create([
        'invoice_number' => $request->invoice_number,
        'id_Invoice' => $id,
        'product' => $request->product,
        'Section' => $request->Section,
        'Status' => $request->status,
        'Value_Status' => 1,
        'Payment_Date' => $request->Payment_Date,
        'note' => $request->note,
        'user' => auth()->user()->name,
      ]);

     }else{

      $invoice->update([
        'Status' => $request->status,
        'Value_Status' => 3,
        'Payment_Date' => $request->Payment_Date
      ]);
       
      invoice_details::create([
        'invoice_number' => $request->invoice_number,
        'id_Invoice' => $id,
        'product' => $request->product,
        'Section' => $request->Section,
        'Status' => $request->status,
        'Value_Status' => 3,
        'Payment_Date' => $request->Payment_Date,
        'note' => $request->note,
        'user' => auth()->user()->name,
      ]);

     }

   session()->flash('update_status');
   return redirect('/Invoices');


    }

    public function Paid_invoices(){
      $Invoices = Invoice::where('Value_Status',1)->get();
      return view('Invoices.Paid_invoices',compact('Invoices'));

    }

    public function Unpaid_bills(){
      $Invoices = Invoice::where('Value_Status',2)->get();
      return view('Invoices.Unpaid_bills',compact('Invoices'));
    }

    public function Partially_paid_bills(){
      $Invoices = Invoice::where('Value_Status',3)->get();
      return view('Invoices.Partially_paid_bills',compact('Invoices'));
    }

    public function Print_Invoice($id){
      $Invoice = Invoice::where('id',$id)->first();
      return view('Invoices.print_invoice',compact('Invoice'));
    }

    public function Mark_Read(Request $request){
      $unreadNotifications = Auth::User()->unreadNotifications;
      if($unreadNotifications) {
        $unreadNotifications->markAsRead();
        return back();
      }
    

    }
}
