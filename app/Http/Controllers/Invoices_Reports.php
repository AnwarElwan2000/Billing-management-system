<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class Invoices_Reports extends Controller
{
    public function index(){
        return view('reports.invoices_reports');
    }

    public function Search_Invoices(Request $request) {
        $radio = $request->radio;
       
    //   البحث بنوع الفاتورة

    if($radio == 1){

    if($request->Choose_the_bill_type && $request->start_of == '' && $request->end_of == ''){

        if($request->Choose_the_bill_type === "جميع الفواتير"){
            $invoices = Invoice::get();
            $type = $request->Choose_the_bill_type;
            return view('reports.invoices_reports',compact('type'))->withDetails($invoices);
        }
      

        $invoices = Invoice::select('*')->where('Status','=', $request->Choose_the_bill_type)->get();
        $type = $request->Choose_the_bill_type;
       return view('reports.invoices_reports',compact('type'))->withDetails($invoices);

    }else{


        $start_of = date($request->start_of);
        $end_of = date($request->end_of);

        if($request->Choose_the_bill_type === "جميع الفواتير"){
            $invoices = Invoice::whereBetween('invoice_Date',[$start_of,$end_of])->get();
            $type = $request->Choose_the_bill_type;
            return view('reports.invoices_reports',compact('type'))->withDetails($invoices);
        }


        $invoices = Invoice::whereBetween('invoice_Date',[$start_of,$end_of])->where('Status','=',$request->Choose_the_bill_type)->get();
        $type = $request->Choose_the_bill_type;
        return view('reports.invoices_reports',compact('type','start_of','end_of'))->withDetails($invoices);

    }
  
    //   البحث برقم الفاتورة

    }else{
        $invoices_number = $request->invoices_number;
        $invoices = Invoice::select('*')->where('invoice_number','=',$invoices_number)->get();
        return view('reports.invoices_reports',compact('invoices_number'))->withDetails($invoices);
    }
        
    }
}


