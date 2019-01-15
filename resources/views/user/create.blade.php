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
            <!-- END PAGE BAR --> <!-- BEGIN PAGE TITLE-->

                <!-- Main Content -->
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
                                        <span class="caption-subject bold uppercase">اضافة مستخدم جديد</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <form action="{{ route('users.store') }}" method="post" role="form">
                                        {{csrf_field()}}
                                        <div class="form-body">
                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                                       placeholder="ادخل الاسم">
                                                <label for="form_control_1">الاسم</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="username" value="{{ old('username') }}"
                                                       placeholder="ادخل اسم المستخدم">
                                                <label for="form_control_1">اسم المستخدم</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                                       placeholder="ادخل الايميل">
                                                <label for="form_control_1">البريد الالكتروني</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="password" class="form-control" placeholder="ادخل كلمة المرور" name="password" id="">
                                                <label for="form_control_1">كلمة المرور</label>
                                                <span class="help-block"></span>
                                            </div>

                                        </div>
                                        <div class="form-actions noborder">
                                            <input type="hidden" id="old_section" value="{{ old('section_id') }}">
                                            <input type="submit" class="btn btn-success" value="اضافة">
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                </div>

                <!-- END SAMPLE FORM PORTLET-->
            </div>
            <!-- /Main Content -->
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    @include('includes/footer')
@stop

@push('css')

@endpush
@push('js')
    <script>
        $(document).ready(function () {
            if ($('#unit_id').val() != -1) {
                $.ajax({
                    url: "{{ url('getSections') }}",
                    data: {
                        unit: $('#unit_id').val()
                    },
                    type: 'GET',
                    dataType: 'json'
                }).done(function (response) {
                    var option = $('<option />');
                    option.attr('value', -1).text('');
                    $('#section_id').append(option);
                    $(response.data).each(function () {
                        var option = $('<option />');
                        option.attr('value', this.unit_section_id).text(this.section_title);
                        $('#section_id').append(option);
                        var section = $("#old_section").val();
                        $('#section_id option[value="' + section + '"]').prop("selected", true);
                    });
                });
            }
            $('#unit_id').on('change', function () {
                $('#section_id').html('');
                var $this = $(this);
                if ($this.val() != -1) {
                    $.ajax({
                        url: "{{ url('getSections') }}",
                        data: {
                            unit: $this.val()
                        },
                        type: 'GET',
                        dataType: 'json'
                    }).done(function (response) {
                        var option = $('<option />');
                        option.attr('value', -1).text('');
                        $('#section_id').append(option);
                        $(response.data).each(function () {
                            var option = $('<option />');
                            option.attr('value', this.unit_section_id).text(this.section_title);
                            $('#section_id').append(option);
                        });
                    });
                } else {
                    $('#section_id').html('');
                }
            });
        });
    </script>
@endpush