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
                        <!-- END PAGE BAR -->             <!-- BEGIN PAGE TITLE-->
                <div class="col-md-12" style="margin-top: 30px;">
                    <!-- BEGIN PROFILE CONTENT -->
                    <div class="profile-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="portlet light ">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-blue-madison bold uppercase"> ملف شخصي - {{ $user->username }}</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab">المعلومات الشخصية
</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab">تغيير كلمة المرور</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        @if (session('status'))
                                            <div class="alert alert-success">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                            @if(session('error'))
                                                <div class="alert alert-danger">
                                                    {{ session('error') }}
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
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                <form role="form" action="{{ route('updateUserInfo',$user->id) }}" method="post">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                    <div class="form-group">
                                                        <label class="control-label">الاسم</label>
                                                        <input type="text" placeholder="الاسم" name="name" class="form-control" value="{{ $user->name }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">الايميل</label>
                                                        <input type="email" placeholder="الايميل" name="email" class="form-control" value="{{ $user->email }}">
                                                    </div>
                                                    <div class="margiv-top-10">
                                                        <button class="btn green">حفظ المتغيرات</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_1_3">
                                                <form action="{{ route('users.changePassword') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label class="control-label">كلمة المرور الحالية</label>
                                                        <input type="password" name="old_password" class="form-control"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">كلمة المرور الجديدة</label>
                                                        <input type="password" name="new_password" class="form-control"> </div>
                                                    <div class="form-group">
                                                        <label class="control-label">تأكيد كلمة المرور</label>
                                                        <input type="password" name="password_confirmation" class="form-control"> </div>
                                                    <div class="margin-top-10">
                                                        <button class="btn green" type="submit">تغيير كلمة المرور</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END PROFILE CONTENT -->
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
        $('#unit_id').on('change', function(){
            $('#section_id').html('');
            var $this = $(this);
            if($this.val() != -1) {
                $.ajax({
                    url: "{{ url('getSections') }}",
                    data: {
                        unit: $this.val()
                    },
                    type: 'GET',
                    dataType: 'json'
                }).done(function(response){
                    var option = $('<option />');
                    option.attr('value', -1).text('');
                    $('#section_id').append(option);
                    $(response.data).each(function(){
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