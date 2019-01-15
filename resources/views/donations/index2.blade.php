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

                <div id="stack1" class="modal fade" data-backdrop="static" data-keyboard="false" data-width="400">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close"
                                        data-dismiss="modal"></button>
                                <h4 class="modal-title">تعبئة بيانات التبرع</h4>
                            </div>
                            <div class="modal-body">
                                <form id="formDetails">
                                    <div class="alert alert-danger display-hide details-error">
                                        <button class="close" data-close="alert"></button>
                                        لديك بعض أخطا . يرجى مراجعة أدناه.
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-md-line-input changeMarPad">
                                                    <label for="singleM1" class="control-label">اختيار المشروع</label>
                                                    <select id="single"
                                                            class="form-control select2 select2-hidden-accessible selectProject"
                                                            tabindex="-1" aria-hidden="true" name="selectProject">
                                                        <option></option>
                                                        @foreach($projects as $project)
                                                            <option value="{{$project->id}}">{{$project->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>


                                            <div class="col-sm-4">
                                                <div class="form-group form-md-line-input changeMarPad">
                                                    <label for="single3" class="control-label">اختيار وسيط</label>
                                                    <select id="single3"
                                                            class="form-control select2 select2-hidden-accessible selectBroker"
                                                            tabindex="-1" aria-hidden="true" name="selectBroker">
                                                        <option></option>
                                                        @foreach($brokers as $broker)
                                                            <option value="{{$broker->id}}">{{$broker->name}}</option>
                                                        @endforeach


                                                    </select>


                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group form-md-line-input changeMarPad">
                                                    <label for="single2" class="control-label">اختيار المتبرع</label>
                                                    <i class="fa fa-spinner fa-spin fa-lg loadDonor hidden"></i>
                                                    <select id="single2"
                                                            class="form-control select2 select2-hidden-accessible selectDonor"
                                                            tabindex="-1" aria-hidden="true" name="selectDonor">

                                                        <option></option>
                                                        <option v-for="donor in donors " :value="donor.id">
                                                            @{{donor.name }}
                                                        </option>

                                                    </select>
                                                    <small class="showNote hidden" style="color: #0a6aa1;">تنبيه! تم
                                                        تغيير الوسيط الخاص بالمتبرع
                                                    </small>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control price" name="price"
                                                           v-model="price"
                                                           value="" autocomplete="off"
                                                           placeholder="مبلغ التبرع">
                                                    <label for="form_control_1">مبلغ التبرع</label>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>


                                            <div class="col-sm-4">
                                                <div class="form-group form-md-line-input">

                                                    <select class="form-control selectCoin" name="selectCoin">
                                                        <option></option>

                                                        <?php
                                                        foreach ($coin_type as $a) {
                                                        ?>
                                                        <option value="<?php echo $a->lookup_id?>"><?php echo $a->lookup_title?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                    <label for="form_control_1">العملة</label>

                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group form-md-line-input">
                                                    <input type="text" class="form-control sar" name="sar" v-model="sar"
                                                           placeholder="المعادلة بالريال " autocomplete="off">
                                                    <label for="form_control_1">المعادلة بالريال</label>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group form-md-line-input">
                                                    <input class="form-control form-control-inline input-small date-picker donation_date"
                                                           data-date-format="dd-mm-yyyy" size="16" type="text"
                                                           v-model="add_date"
                                                           value="{{\Carbon\Carbon::now()->format('d-m-Y')}}"
                                                           name="donation_date">
                                                    <label for="form_control_1">تاريخ التبرع</label>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="col-sm-1"></div>
                                            <div class="col-sm-8">
                                                <div class="form-group ">
                                                    <label for="form_control">ملاحظة </label>
                                                    <textarea class="form-control note" name="note" v-model="note"
                                                              style="height: 100px;"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="modal-footer">


                                <button
                                        class="btn btn-success update_donation">حفظ
                                </button>
                                <button class="btn btn-danger" data-dismiss="modal">رجوع</button>
                            </div>
                        </div>
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

                                        <th class="hidden"></th>
                                        <th class="hidden"></th>
                                        <th> المتبرع</th>
                                        <th class="hidden"></th>
                                        <th> الوسيط</th>
                                        <th class="hidden"></th>
                                        <th>المشروع</th>
                                        <th>المبلغ</th>
                                        <th class="hidden"></th>
                                        <th class="hidden"></th>
                                        <th> تاريخ الاضافة</th>
                                        <th class="hidden"></th>
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
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
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
    </style>
    <link href="{{url('')}}/assets/global/plugins/bootstrap-toastr/toastr.min.css" rel="stylesheet" type="text/css"/>


    <!-- BEGIN PAGE LEVEL PLUGINS -->
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

    <!-- END PAGE LEVEL PLUGINS -->
    <style>
        .datepicker-dropdown {
            left: auto;
        !important;
        }
    </style>
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
    <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>

    <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/additional-methods.min.js"
            type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/pages/scripts/form-validation-md.js" type="text/javascript"></script>


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
    <script src="{{url('')}}/js/vue.js"></script>
    <script>

        var appVue = new Vue({
            el: "#stack1",
            data: {
                id: '',
                donors: [],
                donation_id: '',
                donor_id: '',
                donor_name: '',
                broker_id: '',
                broker_name: '',
                project_id: '',
                project_name: '',
                sar: '',
                price: '',
                coin_type: '',
                add_date: '',
                note: '',
                load_edit: false,
                loadDonor: false
            }


        });

        $(function () {

            function resetFormError() {
                var form2 = jQuery('#formDetails');
                jQuery('.details-error').hide();
                var validator = form2.validate();
                validator.resetForm();
            }

            $(".selectProject").select2({
                placeholder: 'اختار مشروع',
                width: 'auto',
                allowClear: true
            });
            $(".selectBroker").select2({
                placeholder: 'اختار وسيط',
                width: 'auto',
                allowClear: true
            });
            $(".selectDonor").select2({
                placeholder: 'اختار متبرع',
                width: 'auto',
                allowClear: true
            });

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
                    url: '{{url("/")}}/donation/contentListData2',
                    type: 'POST',
                    'headers': {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                },

                columns: [
                    {data: 'id', name: 'id', class: 'hidden id'},
                    {data: 'donor_id', name: 'donor_id', class: 'hidden donor_id'},
                    {data: 'donor_name', name: 'donor_name', class: 'donor_name'},
                    {data: 'broker_id', name: 'broker_id', class: 'hidden broker_id'},
                    {data: 'broker_name', name: 'broker_name', class: 'broker_name'},
                    {data: 'project_id', name: 'project_id', class: 'hidden project_id'},
                    {data: 'project_name', name: 'project_name', class: 'project_name'},
                    {data: 'price', name: 'price', class: 'price'},
                    {data: 'sar', name: 'sar', class: 'sar hidden'},
                    {data: 'coin_type', name: 'coin_type', class: 'coin_type hidden'},
                    {data: 'add_date', name: 'add_date', class: 'add_date'},
                    {data: 'note', name: 'note', class: 'note hidden'},
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

            $('.selectBroker').change(function () {
                var broker_id = $(this).val();
                $('.showNote').addClass('hidden');


                if (broker_id != '') {

                    $('.loadDonor').removeClass('hidden');
                    $('.selectDonor').prop('disabled', true);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }

                    });
                    $.ajax({
                        url: '{{url('getDonorForBroker')}}',
                        data: {broker_id: broker_id},
                        type: 'post',
                        success: function (data) {

                            appVue.load_edit = false;
                            $('.loadDonor').addClass('hidden');
                            $('.selectDonor').prop('disabled', false);
                            $('.selectDonor').children('option:not(:first)').remove();
                            for (var i = 0; i < data.donors.length; i++) {

                                if (data.donors[i].id == appVue.donor_id && broker_id == appVue.broker_id) {


                                    var newOption = new Option(data.donors[i].name, data.donors[i].id, true, true);
                                    $('.selectDonor').append(newOption).trigger('change');
                                } else {

                                    var newOption = new Option(data.donors[i].name, data.donors[i].id, false, false);
                                    $('.selectDonor').append(newOption).trigger('change');
                                }

                            }
                        }
                    });
                }


            });

            $('#data-table').on('click', '.edit_donations', function () {
                //$('#stack1').modal('show');

                resetFormError();

                var tr = $(this).parents('tr');
                appVue.id = tr.find('.id').text();
                appVue.donor_id = tr.find('.donor_id').text();
                appVue.donor_name = tr.find('.donor_name').text();
                appVue.broker_id = tr.find('.broker_id').text();
                appVue.broker_name = tr.find('.broker_name').text();
                appVue.project_id = tr.find('.project_id').text();
                appVue.project_name = tr.find('.project_name').text();
                appVue.price = tr.find('.price').text();
                appVue.sar = tr.find('.sar').text();
                appVue.coin_type = tr.find('.coin_type').text();
                appVue.add_date = tr.find('.add_date').text();
                appVue.note = tr.find('.note').text();

                $('.selectProject').val(appVue.project_id).trigger("change");
                $('.selectDonor').val(appVue.donor_id).trigger("change");
                $('.selectBroker').val(appVue.broker_id).trigger("change");
                $('.selectCoin').val(appVue.coin_type);
                $('#stack1').modal('show');


            });
            $('.update_donation').on('click', function () {

                var selectBroker = $('.selectBroker').select2('data')[0];
                var selectDonor = $('.selectDonor').select2('data')[0];
                var selectProject = $('.selectProject').select2('data')[0];
                //$(".selectCoin option:selected").text()

                appVue.donor_id = selectDonor.id;
                appVue.donor_name = selectDonor.text;
                appVue.broker_id = selectBroker.id;
                appVue.broker_name = selectBroker.text;
                appVue.project_id = selectProject.id;
                appVue.project_name = selectProject.text;
                appVue.coin_type = $(".selectCoin").val();

                var form1 = jQuery('#formDetails');
                if (form1.valid()) {
                    resetFormError();
                    var data = {
                        id: appVue.id,
                        broker_id: appVue.broker_id,
                        donor_id: appVue.donor_id,
                        project_id: appVue.project_id,
                        sar: appVue.sar,
                        coin_type: appVue.coin_type,
                        price: appVue.price,
                        add_date: $('.donation_date').val(),
                        note: appVue.note

                    };
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }

                    });
                    $.ajax({
                        url: '{{url('updateDonation')}}',
                        data: {
                            id: appVue.id,
                            broker_id: appVue.broker_id,
                            donor_id: appVue.donor_id,
                            project_id: appVue.project_id,
                            sar: appVue.sar,
                            coin_type: appVue.coin_type,
                            price: appVue.price,
                            add_date: $('.donation_date').val(),
                            note: appVue.note
                        },
                        method: 'post',
                        success: function (data) {
                            table.ajax.reload();
                            $('#stack1').modal('hide');

                        }
                    });
                }


            });
//edit_donations
        });


    </script>
@endpush
