@extends('layouts.master')
@section('css')

    <style>
        @media print {
            #print_Button {
                display: none;
            }


        }
    </style>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ معاينة
                    طباعة فاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('title')
    معاينة طباعة فاتورة
@show
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">فاتورة تحصيل</h1>
                            <div class="billed-from">
                                <h6>Who Are We</h6>
                                <p>I am Anwar Alwan, the developer of BackEnd<br>
                                    Tel No: 01002415215<br>
                                    Email: anwarelwan@gmail.com</p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600">Billed To</label>
                                <div class="billed-to">
                                    <h6>{{ auth()->user()->name }}</h6>
                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                        Tel No: 01002415215<br>
                                        Email: anwarelwan@gmail.com</p>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="tx-gray-600">Invoice Information</label>
                                <p class="invoice-info-row"><span>رقم الفاتورة</span>
                                    <strong>{{ $Invoice->invoice_number }}</strong>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الاصدار</span>
                                    <strong>{{ $Invoice->invoice_Date }}</strong>
                                </p>
                                <p class="invoice-info-row"><span>تاريخ الاستحقاق</span>
                                    <strong>{{ $Invoice->Due_date }}</strong>
                                </p>
                                <p class="invoice-info-row"><span>القسم</span>
                                    <strong>{{ $Invoice->section->Section_name }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="wd-20p">#</th>
                                        <th class="wd-40p">المنتج</th>
                                        <th class="tx-center">مبلغ التحصيل</th>
                                        <th class="tx-right">مبلغ العمولة</th>
                                        <th class="tx-right">الاجمالي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td class="tx-12"><strong>{{ $Invoice->product }}</strong></td>
                                        <td class="tx-center">
                                            <strong>{{ number_format($Invoice->Amount_collection, 2) }}</strong>
                                        </td>
                                        <td class="tx-right">
                                            <strong>{{ number_format($Invoice->Amount_Commission, 2) }}</strong>
                                        </td>
                                        @php
                                            $Total = $Invoice->Amount_collection + $Invoice->Amount_Commission;
                                        @endphp
                                        <td class="tx-right"><strong>{{ $Total }}</strong></td>
                                    </tr>



                                    <tr>
                                        <td class="valign-middle" colspan="2" rowspan="4">
                                            <div class="invoice-notes">
                                                <label class="main-content-label tx-13">#</label>
                                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                                                    accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab
                                                    illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                                                    explicabo.</p>
                                            </div><!-- invoice-notes -->
                                        </td>
                                        <td class="tx-right">الاجمالي</td>
                                        <td class="tx-right" colspan="2"><strong>{{ $Total }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">نسبة الضريبة (%)</td>
                                        <td class="tx-right" colspan="2"><strong>{{ $Invoice->Rate_VAT }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right">قيمة الخصم</td>
                                        <td class="tx-right" colspan="2"><strong>{{ $Invoice->Discount }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي شامل الضريبة</td>
                                        <td class="tx-right" colspan="2">
                                            <h4 class="tx-primary tx-bold">
                                                <strong>{{ number_format($Invoice->Total) }}</strong>
                                            </h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-40">


                        <button class="btn btn-danger  float-left mt-3 mr-2" id="print_Button" onclick="printDiv()"> <i
                                class="mdi mdi-printer ml-1"></i>طباعة</button>

                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection
