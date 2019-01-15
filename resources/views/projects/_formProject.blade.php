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
                            لديك بعض أخطا . يرجى مراجعة أدناه.
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            Your form validation is successful!
                        </div>

                        <div class="form-group form-md-line-input">

                            <input type="text" class="form-control" name="name"
                                   value="{{ $edit ? $project->name : old('name') }}" autocomplete="off"
                                   placeholder="اسم المشروع">
                            <label for="form_control_1">اسم المشروع</label>
                            <span class="help-block"></span>
                        </div>



                        <div class="form-group">
                            <label for="form_control_1">معلومات هامة عن المشروع </label>
                            <textarea class="form-control" name="information"
                                      style="height: 100px;">{{ $edit ? $project->information :old('information') }}</textarea>
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


        });
    </script>
@endpush



