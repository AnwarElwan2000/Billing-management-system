<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\invoice_details;
use App\Models\invoice_attachment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceDetailsController extends Controller
{
   public function index($id) {
    $invoice_id = Invoice::where('id',$id)->first();
    $invoice_details = invoice_details::where('id_Invoice',$id)->get();
    $invoice_attachment = invoice_attachment::where('invoice_id',$id)->get();

    $get_id = DB::table('notifications')->where('data->id',$id)->pluck('id');
    $Notification = DB::table('notifications')->where('id',$get_id)->update(['read_at' => now()]);
    return view('Invoices.view_invoice_details',compact('invoice_id','invoice_details','invoice_attachment'));

   }

   public function Archive_invoice_details($id){
      $invoice_id = Invoice::onlyTrashed()->where('id',$id)->first();
      $invoice_details = invoice_details::where('id_Invoice',$id)->get();
      $invoice_attachment = invoice_attachment::where('invoice_id',$id)->get();
      return view('Invoices.view_invoice_details',compact('invoice_id','invoice_details','invoice_attachment'));
   }
}
