<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class invoice_Archives_Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Invoices = Invoice::onlyTrashed()->get();
        return view('Invoices.invoice_Archives',compact('Invoices'));
       
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       $id = $request->invoice_id;
       $Invoices = Invoice::withTrashed()->where('id',$id)->restore();
       session()->flash('Invoices_Restore');
       return redirect('Invoices');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
      $id = $request->invoice_id;
      $Invoice = Invoice::withTrashed()->where('id',$id)->first();
      $Invoice->forceDelete();
      session()->flash('delete_archives');
      return back();
    }
}
