@extends('layouts.master')
@section('title')
    تقرير العملاء
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> / تقرير
                    العملاء
                </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="card-body">
            <div class="table-responsive">
            </div>
            {{-- Start Content --}}



            <form action="{{ url('search_customer') }}" method="POST">
                @csrf
                <div class="col">
                    <label for="inputName" class="control-label">القسم</label>
                    <select name="Section" class="form-control SlectBox  w-50" onclick="console.log($(this).val())"
                        onchange="console.log('change is firing')">
                        <!--placeholder-->
                        <option value="" selected disabled>حدد القسم</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}">{{ $section->Section_name }}</option>
                        @endforeach
                        <option value=""> </option>

                    </select>
                </div>



                <div class="col">
                    <label for="inputName" class="control-label">المنتج</label>
                    <select id="product" name="product" class="form-control  w-50">

                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">من تاريخ</label>
                    <input type="date" class="form-control w-50" name="start_at" id="start_at"
                        value="{{ $start_at ?? '' }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">الي تاريخ</label>
                    <input type="date" class="form-control w-50" name="end_at" id="end_at"
                        value="{{ $end_at ?? '' }}">
                </div>
                <input type="submit" class="btn btn-outline-primary mt-3 w-50" name="send" value="بحث">
            </form>

            {{-- Start Table --}}

            <div class="card-body">
                <div class="table-responsive">
                    @if (isset($details))
                        <table class="table text-md-nowrap" id="example1">
                            <thead>
                                <tr>
                                    <th class="wd-15p border-bottom-0">#</th>
                                    <th class="wd-15p border-bottom-0">رقم الفاتورة</th>
                                    <th class="wd-20p border-bottom-0">تاريخ الفاتورة</th>
                                    <th class="wd-15p border-bottom-0">تاريخ الاستحقاق</th>
                                    <th class="wd-10p border-bottom-0">المنتج</th>
                                    <th class="wd-25p border-bottom-0">القسم</th>
                                    <th class="wd-25p border-bottom-0">الخصم</th>
                                    <th class="wd-25p border-bottom-0">نسبة الضريبة</th>
                                    <th class="wd-25p border-bottom-0">قيمة الضريبة</th>
                                    <th class="wd-25p border-bottom-0">الاجمالي</th>
                                    <th class="wd-25p border-bottom-0">الحالة</th>
                                    <th class="wd-25p border-bottom-0">ملاحظات</th>
                                    <th class="wd-25p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp


                                @foreach ($details as $Invoice)
                                    @php
                                        $i++;
                                    @endphp

                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $Invoice->invoice_number }}</td>
                                        <td>{{ $Invoice->invoice_Date }}</td>
                                        <td>{{ $Invoice->Due_date }}</td>
                                        <td>{{ $Invoice->product }}</td>
                                        <td>
                                            <a href="{{ route('invoice_details.show', $Invoice->id) }}"
                                                class="text-primary">
                                                {{ $Invoice->section->Section_name }}
                                            </a>
                                        </td>
                                        <td>{{ $Invoice->Discount }}</td>
                                        <td>{{ $Invoice->Rate_VAT }}</td>
                                        <td>{{ $Invoice->Value_VAT }}</td>
                                        <td>{{ $Invoice->Total }}</td>
                                        <td>

                                            @if ($Invoice->Value_Status == 1)
                                                <span class="text-success">{{ $Invoice->Status }}</span>
                                            @elseif($Invoice->Value_Status == 2)
                                                <span class="text-danger">{{ $Invoice->Status }}</span>
                                            @else
                                                <span class="text-warning">{{ $Invoice->Status }}</span>
                                            @endif

                                        </td>
                                        <td>{{ $Invoice->note }}</td>
                                        <td>
                                            @can('')
                                            @endcan

                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-caret-down ml-1"></i>
                                                    العمليات
                                                </button>

                                                <div class="dropdown-menu">
                                                    @can('تعديل الفاتورة')
                                                        <a class="dropdown-item"
                                                            href="{{ url('edit_invoice', $Invoice->id) }}">تعديل
                                                            الفاتورة</a>
                                                    @endcan
                                                    @can('حذف الفاتورة')
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-invoice_id="{{ $Invoice->id }}"
                                                            data-target="#delete_invoice"> <i
                                                                class="text-danger fas fa-trash-alt"></i> حذف الفاتورة </a>
                                                    @endcan
                                                    @can('تغير حالة الدفع')
                                                        <a class="dropdown-item"
                                                            href="{{ route('Show_status', $Invoice->id) }}">تغير
                                                            حالة الفاتورة</a>
                                                    @endcan
                                                    @can('ارشفة الفاتورة')
                                                        <a href="#" class="dropdown-item" data-toggle="modal"
                                                            data-invoice_id="{{ $Invoice->id }}"
                                                            data-target="#invoice_Archives">ارشفة
                                                            الفاتورة</a>
                                                    @endcan
                                                    @can('طباعةالفاتورة')
                                                        <a href="{{ url('print_invoice', $Invoice->id) }}"
                                                            class="dropdown-item">طباعة
                                                            الفاتورة</a>
                                                    @endcan
                                                </div>


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
            @endif

            {{-- End Content --}}

        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('select[name="Section"]').on('change', function() {
                var SectionId = $(this).val();
                if (SectionId) {
                    $.ajax({
                        url: "{{ URL::to('get_products') }}/" + SectionId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="product"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="product"]').append('<option value="' +
                                    value + '">' + value + '</option>');
                            });
                        },
                    });

                } else {
                    console.log('AJAX load did not work');
                }
            });

        });
    </script>
@endsection
