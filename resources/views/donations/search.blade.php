@extends('layouts.main')

@section('content')
    <div class="page-container">

    @include('includes.side_menu')
    <!-- BEGIN CONTENT -->


        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE BAR -->
            @include('includes.breadcrumb')
            <!-- The Modal -->

                <!-- END PAGE BAR --> <!-- BEGIN PAGE TITLE-->

                <div class="row" style="margin-top: 30px;">

                    <div class="col-md-12">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <form role="form" method="post" action="{{url('searchDonation')}}">
                                    {{csrf_field()}}
                                    <div class="form-body">
                                        <div class="row">

                                            <div class="col-sm-4">
                                                <label for="form_control_1">التاريخ</label>
                                                <div
                                                     class="input-group date-picker input-daterange "
                                                     data-date="10/11/2012"
                                                     data-date-format="dd-mm-yyyy">
                                                    <input type="text" class="form-control"
                                                           value="{{empty($result) ? '': $dateFrom}}" name="dateFrom"
                                                           autocomplete="off">
                                                    <span class="input-group-addon"> الى </span>
                                                    <input type="text" class="form-control"
                                                           value="{{empty($result) ? '': $dateTo}}" name="dateTo"
                                                           autocomplete="off">


                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" style="margin-top: 22px;" class="btn btn-success">
                                                    بحث
                                                </button>
                                            </div>

                                        </div>

                                    </div>

                                </form>
                                <hr>
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">نتائج البحث</span>
                                </div>
                                <div class="tools"></div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover "
                                       id="data-table">
                                    <thead>
                                    <tr>

                                        <th style="width: 25%;">المشروع</th>
                                        <th>الوسيط</th>
                                        <th>المتبرع</th>
                                        <th>المبلغ</th>
                                        <th>الملاحظات</th>
                                        <th>الناريخ</th>

                                    </tr>
                                    </thead>

                                    @if(!(empty($result)))
                                        @foreach($result as $data)
                                            <tr>
                                                <td>{{$data->project_name}}</td>
                                                <td>{{$data->broker_name}}</td>
                                                <td>{{$data->donor_name}}</td>
                                                <td>{{$data->price}}</td>
                                                <td>{{$data->note}}</td>
                                                <td>{{$data->add_date->format('d-m-Y')}}</td>
                                            </tr>

                                        @endforeach
                                    @endif

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /Main Content -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->

    <!-- END CONTAINER -->
    @include('includes/footer')
@stop

@push('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <link href="{{url('')}}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap-rtl.css"
          rel="stylesheet" type="text/css"/>

    <!-- END PAGE LEVEL PLUGINS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->

    <style>
        .btn-default.btn-on-1.active {
            background-color: #006FFC;
            color: white;
        }

        .btn-default.btn-off-1.active {
            background-color: #DA4F49;
            color: white;
        }

        div.dataTables_wrapper div.dataTables_processing {
            margin-right: -50%;
        }

        .datepicker-dropdown {
            left: auto;
        !important;
        }
    </style>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
@endpush
@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!--
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://www.jqueryscript.net/demo/jQuery-Bootstrap-Based-Toast-Notification-Plugin-toaster/jquery.toaster.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/assets/pages/scripts/components-bootstrap-switch.min.js" type="text/javascript"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>

        $(document).ready(function () {
            var table = $('#data-table').DataTable({
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                    sSearch: "{{trans('pagination.sSearch')}}",
                    sZeroRecords: "{{trans('pagination.sZeroRecords')}}",
                    sLengthMenu: "{{trans('pagination.sLengthMenu')}}",
                },
                "bInfo": false,
                buttons: [
                    {extend: 'print', className: 'btn dark btn-outline'},
                    //   { extend: 'copy', className: 'btn red btn-outline' },
                    /* {
                         extend: 'pdf',
                         className: 'btn green btn-outline',
                         messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
                     },*/
                    {extend: 'excel', className: 'btn yellow btn-outline '},
                    // { extend: 'csv', className: 'btn purple btn-outline ' },
                    //  { extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns'}
                ],
                "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            });
            $('.buttons-print').find('span').text('طباعة');
            $('.buttons-excel').find('span').text('اكسل');

        });
    </script>
@endpush
