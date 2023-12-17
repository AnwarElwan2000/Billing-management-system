@extends('layouts.master')
@section('css')
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل
                    الفاتورة</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <button type="button" class="btn-close alert-danger" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('Delete_file'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف المرفق بنجاج",
                    type: 'success'
                })
            }
        </script>
    @endif


    @if (session()->has('add_attachments'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم اضافة المرفق بنجاج",
                    type: 'success'
                })
            }
        </script>
    @endif

    <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
            <div class="card" id="basic-alert">
                <div class="card-body">
                    <div class="col-xl-12">
                        <!-- div -->
                        <div class="card mg-b-20" id="tabs-style2">
                            <div class="card-body">
                                <div class="main-content-label mg-b-5">
                                    invoices
                                </div>
                                <p class="mg-b-20">invoice datails</p>
                                <div class="text-wrap">
                                    <div class="example">
                                        <div class="panel panel-primary tabs-style-2">
                                            <div class=" tab-menu-heading">
                                                <div class="tabs-menu1">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs main-nav-line">
                                                        <li><a href="#tab4" class="nav-link active"
                                                                data-toggle="tab">معلومات الفاتورة</a></li>
                                                        <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات
                                                                الدفع</a></li>
                                                        <li><a href="#tab6" class="nav-link"
                                                                data-toggle="tab">المرفقات</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab4">
                                                        {{-- Start Tab 4 --}}
                                                        <p>رقم الفاتورة : <strong>{{ $invoice_id->invoice_number }}</strong>
                                                        </p>
                                                        <p> تاريخ الاصدار : <strong>{{ $invoice_id->invoice_Date }}</strong>
                                                        </p>
                                                        <p> تاريخ الاستحقاق : <strong>{{ $invoice_id->Due_date }}</strong>
                                                        </p>
                                                        <p>القسم :
                                                            <strong>{{ $invoice_id->section->Section_name }}</strong>
                                                        </p>
                                                        <p>المنتج : <strong>{{ $invoice_id->product }}</strong></p>
                                                        <p>مبلغ التحصيل :
                                                            <strong>{{ $invoice_id->Amount_collection }}</strong>
                                                        </p>
                                                        <p>مبلغ العمولة :
                                                            <strong>{{ $invoice_id->Amount_Commission }}</strong>
                                                        </p>
                                                        <p>الخصم : <strong>{{ $invoice_id->Discount }}</strong></p>
                                                        <p>نسبة ضريبة القيمة المضافة :
                                                            <strong>{{ $invoice_id->Rate_VAT }}</strong>
                                                        </p>
                                                        <p> قيمة ضريبة القيمة المضافة :
                                                            <strong>{{ $invoice_id->Value_VAT }}</strong>
                                                        </p>
                                                        <p>الاجمالي شامل الضريبة :
                                                            <strong>{{ $invoice_id->Total }}</strong>
                                                        </p>

                                                        @if ($invoice_id->Value_Status == 1)
                                                            <p>الحاالة الحالية : <span
                                                                    class="badge rounded-pill bg-success">{{ $invoice_id->Status }}</span>
                                                            </p>
                                                        @elseif($invoice_id->Value_Status == 2)
                                                            <p>الحاالة الحالية : <span
                                                                    class="badge rounded-pill bg-danger">{{ $invoice_id->Status }}</span>
                                                            </p>
                                                        @else
                                                            <p>الحاالة الحالية : <span
                                                                    class="badge rounded-pill bg-warning">{{ $invoice_id->Status }}</span>
                                                            </p>
                                                        @endif
                                                        <p>الملاحظات : </p>
                                                        <p>تم اضافة الفاتورة : </p>
                                                        {{-- End Tab 4 --}}
                                                    </div>
                                                    {{-- Start Tab 5 --}}
                                                    <div class="tab-pane" id="tab5">
                                                        @foreach ($invoice_details as $details)
                                                            <p>رقم الفاتورة :
                                                                <strong>{{ $details->invoice_number }}</strong>
                                                            </p>
                                                            <p>نوع المنتج : <strong>{{ $details->product }}</strong></p>
                                                            <p>القسم :
                                                                <strong>{{ $invoice_id->section->Section_name }}</strong>
                                                            </p>
                                                            @if ($details->Value_Status == 1)
                                                                <p> حالة الدفع : <span
                                                                        class="badge rounded-pill bg-success">{{ $invoice_id->Status }}</span>
                                                                </p>
                                                            @elseif($details->Value_Status == 2)
                                                                <p> حالة الدفع : <span
                                                                        class="badge rounded-pill bg-danger">{{ $invoice_id->Status }}</span>
                                                                </p>
                                                            @else
                                                                <p> حالة الدفع : <span
                                                                        class="badge rounded-pill bg-warning">{{ $invoice_id->Status }}</span>
                                                                </p>
                                                            @endif
                                                            <p>تاريخ الدفع : {{ $details->Payment_Date }}</p>
                                                            <p>ملاحظات : <strong>{{ $details->note }}</strong></p>
                                                            <p>تاريخ الاضافة : <strong>{{ $details->created_at }}</strong>
                                                            </p>
                                                            <p class="mb-0">المستخدم :
                                                                <strong>{{ $details->user }}</strong>
                                                            </p>
                                                            <hr>
                                                            <hr>
                                                            <hr>
                                                        @endforeach

                                                    </div>
                                                    {{-- End Tab 5 --}}

                                                    {{-- Start Tab 6 --}}
                                                    <div class="tab-pane" id="tab6">


                                                        <div class="tab-pane" id="tab6">
                                                            <!--المرفقات-->
                                                            <div class="card card-statistics">

                                                                <div class="card-body">
                                                                    <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg ,
                                                                        png </p>

                                                                    <h5 class="card-title">اضافة مرفقات</h5>
                                                                    <form method="post"
                                                                        action="{{ route('invoice_attahment.store') }}"
                                                                        enctype="multipart/form-data">
                                                                        @method('POST')
                                                                        @csrf
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input"
                                                                                id="customFile" name="file_name" required>
                                                                            <input type="hidden" id="customFile"
                                                                                name="invoice_number"
                                                                                value="{{ $invoice_id->invoice_number }}">
                                                                            <input type="hidden" id="invoice_id"
                                                                                name="invoice_id"
                                                                                value="{{ $invoice_id->id }}">
                                                                            <label class="custom-file-label"
                                                                                for="customFile">حدد
                                                                                المرفق</label>
                                                                        </div><br><br>
                                                                        <input type="submit"
                                                                            class="btn btn-outline-primary btn-sm"
                                                                            name="upload_file" value="تاكيد">
                                                                    </form>
                                                                </div>

                                                                <br>
                                                                @foreach ($invoice_attachment as $attachment)
                                                                    <p>اسم الملف :
                                                                        <strong>{{ $attachment->file_name }}</strong>
                                                                    </p>
                                                                    <p>قام بالاضافة :
                                                                        <strong>{{ $attachment->Created_by }}</strong>
                                                                    </p>
                                                                    <p>تاريخ الاضافة :
                                                                        <strong>{{ $attachment->created_at }}</strong>
                                                                    </p>
                                                                    <p class="mb-0">
                                                                        العمليات
                                                                        <a href="{{ url('open_file/' . $attachment->invoice_number . '/' . $attachment->file_name) }}"
                                                                            class="btn btn-outline-success btn-sm">عرض</a>
                                                                        <a href="{{ url('download_file/' . $attachment->invoice_number . '/' . $attachment->file_name) }}"
                                                                            class="btn btn-outline-primary btn-sm">تحميل</a>


                                                                        <button class="btn btn-outline-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-file_name="{{ $attachment->file_name }}"
                                                                            data-invoice_number="{{ $attachment->invoice_number }}"
                                                                            data-id_file="{{ $attachment->id }}"
                                                                            data-target="#delete_file">حذف</button>


                                                                    </p>
                                                                @endforeach

                                                            </div>
                                                            {{-- End Tab 6 --}}
                                                        </div>
                                                    </div>


                                                    <div class="modal fade" id="delete_file" tabindex="-1"
                                                        role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">حذف
                                                                        المرفق</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('delete_file') }}" method="post">

                                                                    @method('POST')
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <p class="text-center">
                                                                        <h6 style="color:red"> هل انت متاكد من عملية حذف
                                                                            المرفق ؟</h6>
                                                                        </p>

                                                                        <input type="hidden" name="id_file"
                                                                            id="id_file" value="">
                                                                        <input type="hidden" name="file_name"
                                                                            id="file_name" value="">
                                                                        <input type="hidden" name="invoice_number"
                                                                            id="invoice_number" value="">

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default"
                                                                            data-dismiss="modal">الغاء</button>
                                                                        <button type="submit"
                                                                            class="btn btn-danger">تاكيد</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /row -->
                                            </div>
                                            <!-- Container closed -->
                                        </div>
                                        <!-- main-content closed -->
                                    @endsection
                                    @section('js')
                                        <!--Internal  Datepicker js -->
                                        <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
                                        <!-- Internal Select2 js-->
                                        <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
                                        <!-- Internal Jquery.mCustomScrollbar js-->
                                        <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
                                        <!-- Internal Input tags js-->
                                        <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
                                        <!--- Tabs JS-->
                                        <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
                                        <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
                                        <!--Internal  Clipboard js-->
                                        <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
                                        <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
                                        <!-- Internal Prism js-->
                                        <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
                                        <!--Internal  Notify js -->
                                        <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
                                        <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
                                        <script>
                                            $('#delete_file').on('show.bs.modal', function(event) {
                                                var button = $(event.relatedTarget)
                                                var id_file = button.data('id_file')
                                                var file_name = button.data('file_name')
                                                var invoice_number = button.data('invoice_number')
                                                var modal = $(this)

                                                modal.find('.modal-body #id_file').val(id_file);
                                                modal.find('.modal-body #file_name').val(file_name);
                                                modal.find('.modal-body #invoice_number').val(invoice_number);
                                            })
                                        </script>

                                        <script>
                                            // Add the following code if you want the name of the file appear on select
                                            $(".custom-file-input").on("change", function() {
                                                var fileName = $(this).val().split("\\").pop();
                                                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                                            });
                                        </script>
                                    @endsection
