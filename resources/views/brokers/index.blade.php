@extends('layouts.main')

@section('content')
    <div class="page-container">

    @include('includes.side_menu')
    <!-- BEGIN CONTENT -->
        <?php $permissions = \App\Http\Controllers\Controller::getPermissions(); ?>
        <div class="modal fade draggable-modal view" id="draggable" tabindex="-1" role="basic" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase">عرض بيانات الوسيط</span>
                            </div>

                        </div>
                    </div>
                    <div class="modal-body">

                        <table class="table">

                            <tr>
                                <td colspan="2" align="center">البيانات العامة</td>
                            </tr>
                            <tr>
                                <td align="center">اسم الوسيط</td>
                                <td align="center">@{{ broker.name }}</td>
                            </tr>

                            <tr>
                                <td align="center">اسم مستعار للوسيط</td>
                                <td align="center">@{{ broker.alias_name }}</td>
                            </tr>

                            <tr>
                                <td align="center">معلومات هامة</td>
                                <td align="center">@{{ broker.information }}</td>
                            </tr>

                            <tr>
                                <td colspan="2" align="center">بيانات التواصل</td>
                            </tr>

                            <tr>
                                <td align="center">نوع التواصل</td>
                                <td align="center">بيانات التواصل</td>
                            </tr>
                            <tr v-for="brokerContact  in brokerContacts">
                                <td align="center" v-for="contact in contacts"
                                    v-show="contact.lookup_id == brokerContact.contact_type">@{{ contact.lookup_title}}
                                </td>
                                <td align="center">@{{ brokerContact.contact_details }}</td>
                            </tr>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

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
                                                @if(array_intersect(['broker_create'] ,$permissions))
                                                    <a href="{{ route('brokers.create') }}" id="sample_editable_1_new"
                                                       class="btn sbold green"> وسيط جديد
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

                                <table class="table table-striped table-bordered table-hover"
                                       id="data-table">
                                    <thead>
                                    <tr>

                                        <th> اسم الوسيط</th>
                                        <th> الاسم المستعار</th>
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
    <link rel="stylesheet" href="{{url('')}}/css/sweet.css">

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
    <script src="{{url('')}}/js/sweet.js"></script>
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


        var appVue = new Vue({
            el: '.view',
            data: {
                broker: {},
                brokerContacts: {},
                contacts: {}
            }
        });

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
                    url: '{{url("/")}}/broker/contentListData',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [

                    {data: 'name', "width": "25%", name: 'name', 'class': 'name'},
                    {data: 'alias_name', name: 'alias_name', 'class': 'alias_name'},
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
                            url: "{{url('delBroker')}}" + "/" + id,
                            method: "get",
                            data: {},
                            success: function (data) {

                                if (data.status == true) {

                                    $("#row-" + id).fadeOut();
                                    $("#row-" + id).remove();
                                    swal('تم!', 'تم حذف الوسيط بنجاح.', 'success');
                                } else if (data.status == 403) {
                                    swal('خطأ!', "لا تستطيع حذف الوسيط", 'error');
                                }
                                else {
                                    swal('خطأ!', 'لم يتم حذف الوسيط بنجاح.', 'error');
                                }

                            }

                        });


                    });

            });


            $('#data-table').on('click', '.view', function () {
               // var id = $(this).parent().find('.id_hidden').val();
                var id = $(this).find('.id_hidden_view').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{url('viewBroker')}}",
                    method: "get",
                    data: {id: id},
                    success: function (e) {
                        appVue.broker = e['broker'];
                        appVue.brokerContacts = e['brokerContact'];
                        appVue.contacts = e['contact'];
                        $('#draggable').modal();
                    }

                });
            });


        });


    </script>
@endpush
