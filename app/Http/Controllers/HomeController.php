<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified','CheckStatus','TowFactor']);
    }
  
    public function index(){
 
        $Incoices_Count = Invoice::count();

        $Unpaid_bills = Invoice::where('Value_Status',2)->count();
        $Unpaid_invoice_percentage = $Unpaid_bills / $Incoices_Count * 100;
  

        $Paid_invoice = Invoice::where('Value_Status',1)->count();
        $Invoice_paid_percentage = $Paid_invoice / $Incoices_Count * 100;

        $Partially_paid_invoices = Invoice::where('Value_Status',3)->count();
        $Partially_paid_invoice_percentage = $Partially_paid_invoices / $Incoices_Count * 100;


     
        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 350, 'height' => 200])
        ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
        ->datasets([
            [
                "label" => "الفواتير الغير المدفوعة",
                'backgroundColor' => ['#ec5858'],
                'data' => [$Unpaid_invoice_percentage]
            ],
            [
                "label" => "الفواتير المدفوعة",
                'backgroundColor' => ['#81b214'],
                'data' => [$Invoice_paid_percentage]
            ],
            [
                "label" => "الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['#ff9642'],
                'data' => [$Partially_paid_invoice_percentage]
            ],


        ])
        ->options([]);

        $chartjs_2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 340, 'height' => 200])
        ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
        ->datasets([
            [
                'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                'data' => [$Unpaid_invoice_percentage,$Invoice_paid_percentage ,$Partially_paid_invoice_percentage]
            ]
        ])
        ->options([]);

        return view('dashboard', compact('chartjs','chartjs_2'));
    }
    
}
