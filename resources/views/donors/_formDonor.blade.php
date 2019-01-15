<div class="row" style="margin-top: 30px;">
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


            @foreach($contact as $i=>$c)
                <input type="hidden" class="contactIdForValid" value="{{$c->lookup_id}}">
                <input type="hidden" class="contactSlugForValid{{$c->lookup_id}}" value="{{$c->lookup_slug}}">
            @endforeach

            <div class="portlet light bordered">
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
                            لديك بعض أخطاء النماذج. يرجى مراجعة أدناه.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            Your form validation is successful!
                        </div>

                        <div class="form-group form-md-line-input">

                            <input type="text" class="form-control" name="name"
                                   value="{{ $edit ? $donor->name : old('name') }}" autocomplete="off"
                                   placeholder="اسم المتبرع">
                            <label for="form_control_1">اسم المتبرع</label>
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group form-md-line-input">
                            <input type="text" class="form-control" name="alias_name"
                                   value="{{ $edit ? $donor->alias_name : old('alias_name') }}" autocomplete="off"
                                   placeholder="اسم مستعار للمتبرع">
                            <label for="form_control_1">اسم مستعار للمتبرع</label>
                            <span class="help-block"></span>
                        </div>


                        <div class="form-group form-md-line-input">
                            <label for="multiple" class="control-label">اختيار وسطاء</label>
                            <select id="multiple"
                                    class="form-control select2-multiple select2-hidden-accessible selectBrokers" name="selectBrokers[]"
                                    multiple="" tabindex="-1" aria-hidden="true">
                                <option></option>
                                @foreach($brokers as $broker)
                                    <option value="{{$broker->id}}" {{in_array($broker->id , $selectBrokers) ? 'selected' : ''}}>{{$broker->name}}</option>
                                @endforeach

                            </select>
                            <span class="help-block"></span>
                        </div>
                        <!--
                                                <div class="form-group mt-repeater form-md-line-input">
                                                    <div data-repeater-list="group-b" class="repeatB">

                                                        <div data-repeater-item class="mt-repeater-item">
                                                            <div class="row mt-repeater-row">

                                                                <div class="col-xs-11">
                                                                    <div class="form-group form-md-line-input">
                                                                        <label class="control-label">اسم الوسيط</label>
                                                                        <select class="form-control selectDonor" name="selectDonor">
                                                                            <option></option>
                                                                            <option>AAA</option>
                                                                            <option>BB</option>
                                                                        </select>
                                                                        <span class="help-block"></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-1" style="margin-top: 17px;">

                                                                    <a href="javascript:;" data-repeater-delete
                                                                       class="btn btn-danger mt-repeater-delete">
                                                                        <i class="fa fa-close"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                                        <i class="fa fa-plus"></i> اضافة وسيط</a>
                                                </div>
                                                -->

                        <div class="form-group mt-repeater form-md-line-input">
                            <div data-repeater-list="group-c" class="repeatC">


                                @if (count($errors) > 0)

                                    @if(count(old('group-c')) > 0)
                                        @include('includes.contactReapeter' , ['add' => false , 'arr' => old('group-c')])
                                    @else
                                        @include('includes.contactReapeter' , ['add' => true , 'arr' => null])

                                    @endif

                                @elseif($edit)

                                    @include('includes.contactReapeter' , ['add' => false , 'arr' => $contactDonor])
                                @else
                                    @include('includes.contactReapeter' , ['add' => true , 'arr' => null])
                                @endif

                            </div>

                            <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                <i class="fa fa-plus"></i> اضافة بيانات تواصل</a>
                        </div>


                        <div class="form-group">
                            <label for="form_control_1">معلومات هامة عن المتبرع وشروط التعامل معه</label>
                            <textarea class="form-control" name="information"
                                      style="height: 100px;">{{ $edit ? $donor->information :old('information') }}</textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-actions noborder">
                        <input type="hidden" id="old_section" value="{{ old('section_id') }}">
                        <input type="submit" class="btn btn-success addwithSave" value="{{$edit ? 'حفط' : 'اضافة'}}">
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
@endpush

@push('js')


    <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-select2.min.js" type="text/javascript"></script>


    <script>
        $(document).ready(function () {

            function getRuleForContact() {

                $('.repeatC .mt-repeater-item').each(function (i) {
                    $(this).find('.contact_type').rules('add', {
                        required: true
                    });
                    var validate = '';
                    if ($(this).find('.getValidate').val() == 'email') {
                        validate = {
                            required: true,
                            email: true,
                            number: false
                        };
                    } else if ($(this).find('.getValidate').val() == 'number') {
                        validate = {
                            required: true,
                            number: true,
                            email: false
                        };
                    }


                    if (validate != '') {
                        $(this).find('.contact_details').rules('add', validate)
                    } else {
                        $(this).find('.contact_details').rules('add', {
                            required: true,
                            number: false,
                            email: false
                        });
                    }


                });
            }

            $('.addwithSave').click(function () {
                getRuleForContact();
            });
            $('.mt-repeater').on('change', '.contact', function () {
                var _this = $(this);
                $('.contactIdForValid').each(function () {
                    var _this2 = $(this);
                    if ($(this).val() == _this.find('option:selected').val()) {
                        _this.parents('.mt-repeater-item').find('.getValidate').val($('.contactSlugForValid' + $(this).val()).val());
                    }
                });
                getRuleForContact();


            });
            $('.selectBrokers').change(function() {
                $(this).valid();
            });

        });
    </script>
@endpush



