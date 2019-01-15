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
            <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <div class="row" style="margin-top: 30px;">
                    <!-- Main Content -->

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
                                        <span class="caption-subject bold uppercase">تعديل المستخدم</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <form action="{{ route('users.update', $user->id) }}" method="post" role="form">
                                        {{csrf_field()}}
                                        {{ method_field('PATCH') }}
                                        <div class="form-body">
                                            <div class="form-group form-md-line-input">

                                                <input type="text" class="form-control" name="name"
                                                       value="{{ $user->name }}"
                                                       placeholder="اسم ">
                                                <label for="form_control_1">الاسم</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="username"
                                                       value="{{ $user->username }}" placeholder="اسم المستخدم">
                                                <label for="form_control_1">اسم المستخدم</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="text" class="form-control" name="email"
                                                       value="{{ $user->email }}" placeholder="البريد الإلكتروني">
                                                <label for="form_control_1">البريد الالكتروني</label>
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group form-md-line-input">
                                                <input type="password" class="form-control" name="password">

                                                <label for="form_control_1">كلمة المرور</label>
                                                <span class="help-block"></span>
                                            </div>



                                                <div class="form-group form-md-checkboxes">

                                                    <label>الصلاحيات</label>
                                                    @if($user->username != 'admin')
                                                    <div class="md-checkbox-list row">

                                                        <div class="col-sm-4"></div>
                                                        <div class="md-checkbox col-sm-4">
                                                            <input type="checkbox" id="checkAll"
                                                                   value="all" class="md-check">
                                                            <label for="checkAll">
                                                                <span></span>
                                                                <span class="check"></span>
                                                                <span class="box"></span> Check All
                                                            </label>
                                                        </div>
                                                        <div class="col-sm-4"></div>


                                                    </div>

                                                    <div class="md-checkbox-list row">
                                                        @foreach($permissions as $permission)
                                                            <div class="md-checkbox col-sm-3">
                                                                <input type="checkbox" id="checkbox{{$permission->id}}"
                                                                       {{in_array($permission->id, $user_permissions) ? "checked" : ""}} name="permission[]"
                                                                       value="{{ $permission->id }}"
                                                                       class="md-check permissionList">
                                                                <label for="checkbox{{$permission->id}}">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> {{$permission->display_name}}
                                                                </label>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                    @else
                                                     <h4>هذا المستخدم يمتلك كل الصلاحيات ولا يمكن تعديله</h4>
                                                    @endif
                                                </div>

                                        </div>
                                        <div class="form-actions noborder">
                                            <input type="submit" class="btn btn-success" value="save">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- END SAMPLE FORM PORTLET-->
                </div>
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

            function checkAll() {
                if ($('.permissionList').length == $('.permissionList:checked').size()) {
                    $('#checkAll').prop('checked', true);
                } else {
                    $('#checkAll').prop('checked', false);
                }
            }

            checkAll();


            $('.permissionList').change(function () {
                checkAll();
            });

            $('#checkAll').change(function () {
                if ($(this).is(':checked')) {
                    $('.permissionList').each(function () {
                        $(this).prop('checked', true);
                    });
                } else {
                    $('.permissionList').each(function () {
                        $(this).prop('checked', false);
                    });
                }
            });
        });
    </script>
@endpush