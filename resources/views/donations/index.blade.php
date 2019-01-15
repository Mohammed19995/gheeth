@extends('layouts.main')

@section('content')
    <div class="page-container">

    @include('includes.side_menu')
    <!-- BEGIN CONTENT -->

        <?php $permissions = \App\Http\Controllers\Controller::getPermissions(); ?>
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
                                <div class="caption font-dark">
                                    <i class="icon-settings font-dark"></i>
                                    <span class="caption-subject bold uppercase">{{$location}}</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="btn-group">
                                                @if(array_intersect(['donation_create'] ,$permissions))
                                                    <a href="{{ route('donations.create') }}" id="sample_editable_1_new"

                                                       class="btn sbold green"> تبرع جديد
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <!--
                                            <select id="statusFilter" class="form-control" style="margin-bottom: 13px;">
                                                <option value="">All Status</option>
                                                <option value="1">Active</option>
                                                <option value="-1">Not active</option>
                                            </select>
                                            -->
                                        </div>
                                        <div class="col-md-8"></div>
                                    </div>
                                </div>

                                <!-- table-checkable order-column -->
                                <table class="table table-striped table-bordered table-hover "
                                       id="data-table">
                                    <thead>
                                    <tr>

                                        <th>رقم التبرع</th>
                                        <th> المبلغ الاجمالي</th>
                                        <th> تاريخ الاضافة</th>
                                        <th> التحكم</th>

                                    </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
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
    </style>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>
@endpush
@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js"
            type="text/javascript"></script>
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
    <script src="{{url('')}}/js/vue.js"></script>
    <script>


        $(function () {

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
                    sSearch: "{{trans('pagination.sSearch')}}",
                    sZeroRecords: "{{trans('pagination.sZeroRecords')}}",
                    sLengthMenu: "{{trans('pagination.sLengthMenu')}}",
                },
                "bInfo": false,
                ajax: {
                    url: '{{url("/")}}/donation/contentListData',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [

                    {data: 'id', name: 'id', 'class': 'id'},
                    {data: 'total_price', name: 'total_price', 'class': 'total_price'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'control', name: 'control', 'class': 'control', orderable: false, "searchable": false}

                ]
            });


            $('#data-table').on('click', '.delete', function () {
                var id = $(this).find('.id_hidden').val();
                swal({

                        title: "هل انت متأكد ؟",
                        text: "حذف!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "نعم احذف!",
                        cancelButtonText: "رجوع",
                        closeOnConfirm: false
                    },
                    function () {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: "{{url('delDonation')}}" + "/" + id,
                            method: "get",
                            data: {},
                            success: function (data) {
                                if (data.status == true) {

                                    $("#row-" + id).fadeOut();
                                    $("#row-" + id).remove();
                                    swal('تم!', 'تم حذف التبرع بنجاح.', 'success');
                                } else if (data.status == 403) {
                                    swal('خطأ!', "لا تستطيع حذف التبرع", 'error');
                                }
                                else {
                                    swal('خطأ!', 'لم يتم حذف التبرع بنجاح.', 'error');
                                }

                            }
                        });


                    });

            });


            $('#data-table').on('click', '.view', function () {
                var id = $(this).parent().find('.id_hidden').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{url('viewDonor')}}",
                    method: "get",
                    data: {id: id},
                    success: function (e) {
                        appVue.donor = e['donor'];
                        appVue.donorContacts = e['donorContact'];
                        appVue.contacts = e['contact'];
                        appVue.brokers = e['brokers'];
                        console.log(e);
                        $('#draggable').modal();
                    }

                });
            });


        });


    </script>
@endpush
