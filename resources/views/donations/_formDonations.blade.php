<div class="row" style="margin-top: 30px;" xmlns="">


    <div class="col-md-12">
        <div class="portlet light bordered">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if (count($errors) > 0)

                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="alert alert-danger errorMsg hidden">
                الرجاء التأكد من جميع البيانات المدخلة
            </div>


            <div class="portlet light bordered donation">
                <div id="stack1" class="modal fade" data-backdrop="static" data-keyboard="false" data-width="400">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" @click="hideModal" data-dismiss="modal"
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
                                                            <option value="{{$project->id}}" {{in_array($project->id , $selectProjects) ? 'selected' : ''}}>{{$project->name}}</option>
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
                                                            <option value="{{$broker->id}}" {{in_array($broker->id , $selectBrokers) ? 'selected' : ''}} >{{$broker->name}}</option>
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
                                                    <input type="text" class="form-control sar" name="sar"
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
                                                    <textarea class="form-control note" name="note"
                                                              style="height: 100px;"></textarea>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="modal-footer">


                                <button @click="addOrUpdateDonation"
                                        class="btn btn-success addDetailsToTable">@{{ edit== true ? 'حفظ': 'اضافة' }}
                                </button>
                                <button class="btn btn-danger" @click="hideModal" data-dismiss="modal">رجوع</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">{{$type}}</span>
                    </div>

                </div>
                <div class="portlet-body form">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            لديك بعض أخطا . يرجى مراجعة أدناه.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            التحقق من صحة النموذج الخاص بك ناجح!
                        </div>

                        <form id="formMainDonation">
                            <div class="row">
                                <!-- <div class="col-sm-3">
                                     <div class="form-group form-md-line-input">
                                         <input type="text" class="form-control" name="title"
                                                placeholder="اسم التبرع" autocomplete="off"
                                                v-model="title">
                                         <label for="form_control_1">عنوان التبرع</label>
                                         <span class="help-block"></span>
                                     </div>
                                 </div> -->
                                <div class="col-sm-4">
                                    <div class="form-group form-md-line-input">
                                        <input type="text" id="totalPriceDonation" class="form-control"
                                               name="total_price"
                                               placeholder="المبلغ الاجمالي" autocomplete="off"
                                               v-model="total_price">
                                        <label for="form_control_1">المبلغ الاجمالي ( الريال )</label>
                                        <span class="help-block"></span>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <button :disabled="countPrice()" class="btn btn-success addDetails"
                                    >اضافة تفاصيل التبرع <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!--  formDetails -->


                        <div class="panel panel-primary" style="margin-top: 60px;">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3 class="panel-title">مراجعة البيانات</h3>
                                    </div>
                                    <div class="col-sm-6"></div>

                                </div>

                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%"> اسم المشروع</th>
                                        <th> اسم الوسيط</th>
                                        <th> اسم المتبرع</th>
                                        <th> مبلغ التبرع</th>
                                        <th> العملة</th>
                                        <th> العملة بالريال</th>
                                        <th> تاريخ التبرع</th>
                                        <th>التحكم</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="donation ,index in donations">
                                        <td> @{{ donation.project.text }}</td>
                                        <td> @{{ donation.broker.text }}</td>
                                        <td> @{{ donation.donor.text }}</td>
                                        <td> @{{ donation.price }}</td>
                                        <td> @{{ donation.coin.text }}</td>
                                        <td> @{{ donation.sar }}</td>
                                        <td> @{{ donation.donation_date }}</td>
                                        <td>
                                            <button :disabled="load_edit" @click="editDonation(index)"
                                                    class="btn btn-success btn-sm"><i
                                                        class="fa fa-edit"></i></button>
                                            <button @click="removeDonation(index)" class="btn btn-danger btn-sm"><i
                                                        class="fa fa-remove"></i></button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions noborder">
                        <input type="hidden" id="old_section" value="{{ old('section_id') }}">
                        <input type="submit" class="btn btn-success addwithSave" :disabled="!countPrice()"
                               value="{{$edit ? 'اعتماد' : 'اعتماد'}}">
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@push('css')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{url('')}}/assets/apps/css/todo-rtl.min.css" rel="stylesheet" type="text/css"/>

    <!-- END PAGE LEVEL PLUGINS -->
    <style>
        .form-group.form-md-line-input {
            /*  margin: 0;
              padding-top: 10px;*/

        }

        .hidden {
            display: none;
        }

    </style>
@endpush

@push('js')


    <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/js/vue.js"></script>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script defer>


        function resetFormError() {
            var form2 = jQuery('#formDetails');
            jQuery('.details-error').hide();
            var validator = form2.validate();
            validator.resetForm();
        }

        var appVue = new Vue({
            el: '.donation',
            data: {

                showDetail: false,
                count: 0,
                donors: [],
                donation_date: '',
                donations: [],
                total_price: null,
                edit_price: 0,
                title: '',
                edit: 0,
                index_edit: -1,
                load_edit: false


            },

            methods: {

                countPrice: function () {
                    /*
                    var c = 0;
                    for (var i = 0; i < this.donations.length; i++) {
                        c += parseFloat(this.donations[i].price);
                    }*/
                    //  return this.total_price == 0 || this.showDetail == true;
                    return this.total_price == 0
                },
                removeDonation: function (index) {
                    var r = confirm("Are you sure delete!");
                    if (r == true) {
                        this.total_price = this.total_price + parseFloat(this.donations[index].price);
                        this.donations.splice(index, 1);

                    }


                },
                editDonation: function (index) {
                    appVue.edit = 1;
                    appVue.index_edit = index;

                    //   jQuery('.selectProject').select2('val', this.donations[index].project.id);
                    jQuery('.selectProject').val(this.donations[index].project.id).trigger("change");
                    //  jQuery('.selectDonor').select2('val', this.donations[index].donor.id);
                    jQuery('.selectBroker').val(this.donations[index].broker.id).trigger("change");

                    jQuery('.price').val(this.donations[index].price);
                    jQuery('.selectCoin').val(this.donations[index].coin.id);

                    jQuery('.sar').val(this.donations[index].sar);
                    jQuery('.donation_date').val(this.donations[index].donation_date);
                    jQuery('.note').val(this.donations[index].note);

                    appVue.donations[index].edit_num = 0;

                    this.edit_price = this.donations[index].price;

                    //   this.total_price = parseFloat(this.total_price) + parseFloat(this.donations[index].price)
                    // jQuery('#stack1').modal('show');
                    appVue.showDetail = true;
                    resetFormError();

                },
                addOrUpdateDonation: function () {
                    if (appVue.edit == 0) {
                        var form1 = jQuery('#formDetails');
                        if (form1.valid()) {

                            appVue.donations.push({
                                project: jQuery('.selectProject').select2('data')[0],
                                broker: jQuery('.selectBroker').select2('data')[0],
                                donor: jQuery('.selectDonor').select2('data')[0],
                                price: jQuery('.price').val(),
                                coin: {
                                    id: jQuery('.selectCoin').val(),
                                    text: jQuery(".selectCoin option:selected").text()
                                },
                                sar: jQuery('.sar').val(),
                                donation_date: jQuery('.donation_date').val(),
                                note: jQuery('.note').val(),
                                edit_num: 0
                            });

                            appVue.showDetail = false;
                            this.total_price = parseFloat(this.total_price) + parseFloat(this.edit_price);
                            this.total_price = parseFloat(this.total_price) - parseFloat(jQuery('.price').val());
                            jQuery('#stack1').modal('hide');
                        }
                    } else {
                        var form1 = jQuery('#formDetails');
                        if (form1.valid()) {

                            appVue.donations[appVue.index_edit] = {
                                project: jQuery('.selectProject').select2('data')[0],
                                broker: jQuery('.selectBroker').select2('data')[0],
                                donor: jQuery('.selectDonor').select2('data')[0],
                                price: jQuery('.price').val(),
                                coin: {
                                    id: jQuery('.selectCoin').val(),
                                    text: jQuery(".selectCoin option:selected").text()
                                },
                                sar: jQuery('.sar').val(),
                                donation_date: jQuery('.donation_date').val(),
                                note: jQuery('.note').val(),
                                edit_num: 1
                            };
                            jQuery('#stack1').modal('hide');
                            this.total_price = parseFloat(this.total_price) + parseFloat(this.edit_price);
                            this.total_price = this.total_price - parseFloat(jQuery('.price').val());
                            appVue.showDetail = false;
                            appVue.edit = 0;

                        }
                    }


                },
                hideModal: function () {
                    /* var price = parseFloat(jQuery('.price').val());
                     if( !isNaN(price)) {
                        this.total_price = parseFloat(this.total_price) + this.edit_price;
                     }*/
                    // this.total_price = parseFloat(this.total_price) + this.edit_price;
                }

            }
        });
    </script>
    <script defer>

        $(document).ready(function () {


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
            //$(".selectProject").select2();


            $('.showDetail').removeClass('hidden');
            $('.errorMsg').addClass('hidden');
            var edit = "{{$edit}}";
            if (edit) {
                var id = "{{$id}}";
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{url('getDonations')}}",
                    method: "get",
                    data: {id: id},
                    success: function (e) {
                        var arr = e['data'];
                        for (var i = 0; i < arr.length; i++) {
                            // appVue.total_price = arr[i].total_price;
                            appVue.total_price = 0;
                            appVue.title = arr[i].title;
                            appVue.donations.push({
                                project: {id: arr[i].project_id, text: arr[i].project_name},
                                broker: {id: arr[i].broker_id, text: arr[i].broker_name},
                                donor: {id: arr[i].donor_id, text: arr[i].donor_name},
                                price: arr[i].price,
                                coin: {id: arr[i].coin_id, text: arr[i].coin_text},
                                sar: arr[i].sar,
                                donation_date: arr[i].donation_date,
                                note: arr[i].note,
                                edit_num: 0
                            });
                        }

                    }

                });
            }


            $('.addDetails').on('click', function () {
                var form1 = $('#formMainDonation');
                var form2 = $('#formDetails');
                $('.showNote').addClass('hidden');

                if (form1.valid()) {
                    appVue.showDetail = true;
                    $('.selectProject').val(null).trigger('change');
                    $('.selectBroker').val(null).trigger('change');
                    $('.selectDonor').val(null).trigger('change');
                    $('.price').val('');
                    $('.sar').val('');
                    $('.note').val('');
                    // $('.selectCoin').val('');
                    $('.selectCoin option')
                        .filter(function (index) {
                            return $(this).text() === 'الريال';
                        })
                        .prop('selected', true);

                    appVue.edit = 0;
                    $('#stack1').modal('show');
                    $('.showNote').addClass('hidden');

                } else {
                    appVue.showDetail = false;
                }
                appVue.edit_price = 0;
                resetFormError();
            });
            $('.selectBroker').change(function () {
                var broker_id = $(this).val();
                $('.showNote').addClass('hidden');
                appVue.donors = [];

                if (broker_id != '') {

                    if (appVue.edit == 1) {
                        appVue.load_edit = true;
                    }

                    $('.loadDonor').removeClass('hidden');
                    $('.selectDonor').prop('disabled' , true);
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


                            if (appVue.edit == 1) {
                                if (appVue.donations[appVue.index_edit].edit_num == 0) {

                                    jQuery('.selectDonor').children('option:not(:first)').remove();
                                    for (var i = 0; i < data.donors.length; i++) {
                                        var data1 = {
                                            id: data.donors[i].id,
                                            text: data.donors[i].name
                                        };

                                        if (data.donors[i].id == appVue.donations[appVue.index_edit].donor.id) {


                                            var newOption = new Option(data.donors[i].name, data.donors[i].id, true, true);
                                            jQuery('.selectDonor').append(newOption).trigger('change');
                                        } else {

                                            var newOption = new Option(data.donors[i].name, data.donors[i].id, false, false);
                                            jQuery('.selectDonor').append(newOption).trigger('change');
                                        }

                                    }
                                    $('.showNote').addClass('hidden');
                                    if ($('.selectDonor').select2('data')[0].text == '') {
                                        $('.showNote').removeClass('hidden');
                                    }

                                    //jQuery('.selectDonor').select2('text' , 'dddddd').trigger('change');
                                    appVue.donations[appVue.index_edit].edit_num = 1;
                                } else {

                                    jQuery('.selectDonor').children('option:not(:first)').remove();
                                    appVue.donors = data.donors;
                                }

                                jQuery('#stack1').modal('show');

                            } else {

                                jQuery('.selectDonor').children('option:not(:first)').remove();
                                appVue.donors = data.donors;
                            }

                            appVue.load_edit = false;
                            $('.loadDonor').addClass('hidden');
                            $('.selectDonor').prop('disabled' , false);
                        }
                    });
                }


            });
            $('.addwithSave').on('click', function () {


                var formData = new FormData();

                //  formData.append('title', appVue.title);
                formData.append('total_price', appVue.total_price);
                formData.append('donations', JSON.stringify(appVue.donations));
                var url = "";
                var type = "";

                if (edit) {
                    var id = "{{$id}}";
                    url = '{{url('donations')}}' + "/" + id;
                } else {
                    url = '{{url('donations')}}';
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });

                $.ajax({
                    url: url,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    type: 'post',
                    success: function (data) {

                        if (data['done']) {
                            window.location = "{{url('donations')}}";
                        } else {
                            var error = data['error'];
                            $('.errorMsg').removeClass('hidden');
                        }
                    }
                });
            });


            $('.selectProject').change(function () {
                $(this).valid();
            });
            $('.selectDonor').change(function () {
                $(this).valid();
            });
            $('.selectBroker').change(function () {
                $(this).valid();
            });
            /*
                        $.validator.addMethod('lessThan', function(value, element, param) {
                            return this.optional(element) || value <= $(param).val();
                        }, 'المبلغ يجب ان يكون اقل من المبلغ الاجمالي');
            */
            $.validator.addMethod('lessThan', function (value, element, param) {
                var priceToCheck = 0;
                if (appVue.edit != 0) {
                    priceToCheck = parseFloat(appVue.donations[appVue.index_edit].price) + parseFloat($(param).val());
                } else {
                    priceToCheck = parseFloat($(param).val());
                }

                return this.optional(element) || value <= priceToCheck;
            }, 'المبلغ يجب ان يكون اقل من المبلغ الاجمالي');

            $('.price').keyup(function () {


                $(this).rules('add', {
                    lessThan: "#totalPriceDonation"
                });
                $(this).valid();
                $('.sar').val($(this).val());
                $('.sar').valid();

            });


        });

    </script>
@endpush



