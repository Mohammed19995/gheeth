<div class="row" style="margin-top: 30px;">

    <input type="hidden" value="{{url('')}}" class="baseUrl">
    <input type="hidden" class="id_hidden" value="{{$edit ? $broker->id : ''}}">

    @foreach($contact as $i=>$c)
        <input type="hidden" class="contactIdForValid" value="{{$c->lookup_id}}">
        <input type="hidden" class="contactSlugForValid{{$c->lookup_id}}" value="{{$c->lookup_slug}}">
    @endforeach

    <div class="col-md-12">
        <div class="portlet light bordered">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif




            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-red-sunglo">
                        <i class="icon-settings font-red-sunglo"></i>
                        <span class="caption-subject bold uppercase">{{$type}}</span>
                    </div>

                </div>
                <div class="portlet-body form">
                    <div class="form-body">

                        @if (count($errors) > 0)

                            <div class="alert alert-danger serverError">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>


                        @endif

                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            لديك بعض أخطاء النماذج. يرجى مراجعة أدناه.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            Your form validation is successful!
                        </div>


                        <div class="form-group form-md-line-input" >

                            <input type="text" class="form-control" name="name"
                                   value="{{ $edit ? $broker->name : old('name') }}" autocomplete="off"
                                   placeholder="اسم الوسيط">
                            <label for="form_control_1">اسم الوسيط</label>
                            <span class="help-block"></span>

                        </div>

                        <div class="form-group form-md-line-input ">
                            <input type="text" class="form-control" name="alias_name"
                                   value="{{ $edit ? $broker->alias_name : old('alias_name') }}" autocomplete="off"
                                   placeholder="اسم مستعار للوسيط">
                            <label for="form_control_1">اسم مستعار للوسيط</label>
                            <span class="help-block"></span>

                        </div>

                        <div class="form-group mt-repeater form-md-line-input">


                            <div data-repeater-list="group-c" class="repeatC">
                                @if (count($errors) > 0)


                                    @if(count(old('group-c')) > 0)
                                        @include('includes.contactReapeter' , ['add' => false , 'arr' => old('group-c')])
                                    @else
                                        @include('includes.contactReapeter' , ['add' => true , 'arr' => null])

                                    @endif

                                @elseif($edit)

                                    @include('includes.contactReapeter' , ['add' => false , 'arr' => $contactBroker])
                                @else
                                    @include('includes.contactReapeter' , ['add' => true , 'arr' => null])
                                @endif


                            </div>
                            <a href="javascript:;" data-repeater-create class="btn btn-info mt-repeater-add">
                                <i class="fa fa-plus"></i> اضافة بيانات تواصل</a>

                            <span class="help-block"></span>
                        </div>
                        <div class="form-group ">
                            <label for="form_control_1">معلومات هامة عن الوسيط وشروط التعامل معه</label>
                            <textarea class="form-control" name="information"
                                      style="height: 100px;">{{ $edit ? $broker->information :old('information') }}</textarea>
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

@push('js')

    <script>
        $(document).ready(function () {

            function getRule() {


                    $('.repeatC .mt-repeater-item').each(function (i) {
                        // alert($(this).find('.contact_details').val());
                        //  alert($(this).find('.contact_type').val());
                        // alert($(this).find('.getValidate').val());


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
                getRule();

            });

            $('.mt-repeater').on('change', '.contact', function () {
                var _this = $(this);
                //$(this).parents('.mt-repeater-item').find('.getValidate').val($(this).find('option:selected').val());
                $('.contactIdForValid').each(function () {
                    var _this2 = $(this);
                    if ($(this).val() == _this.find('option:selected').val()) {
                        _this.parents('.mt-repeater-item').find('.getValidate').val($('.contactSlugForValid' + $(this).val()).val());
                    }
                });
                getRule();


            });
        });
    </script>
@endpush


