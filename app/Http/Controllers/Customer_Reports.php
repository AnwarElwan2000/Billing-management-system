<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\section;
use App\Models\Invoice;
class Customer_Reports extends Controller
{
    public function index(){
    $sections = section::get();
    return view('reports.customer_reports',compact('sections'));

    }

    public function Search_customer(Request $request){

       if($request->Section && $request->product && $request->start_at == '' && $request->end_at == ''){
        $invoices = Invoice::select('*')->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
        $sections = section::get();
        return view('reports.customer_reports',compact('sections'))->withDetails($invoices);

       }else{
         $start_at = date($request->start_at);
         $end_at = date($request->end_at);
         $invoices = Invoice::whereBetween('invoice_Date',[$start_at,$end_at])->where('section_id','=',$request->Section)->where('product','=',$request->product)->get();
         $sections = section::get();
         return view('reports.customer_reports',compact('sections'))->withDetails($invoices);

       }
       

    }
}
