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


                {!! Form::open(['url'=>'projects' , 'role'=>'form','id'=>'form-project','enctype'=>'multipart/form-data']) !!}
                @include('projects._formProject',['edit'=>null , 'type' => 'اضافة مشروع جديد'])

                {!! Form::close() !!}
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
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@endpush
@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/pages/scripts/form-repeater.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/pages/scripts/form-validation-md.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        $(document).ready(function() {
           /* $('.mt-repeater').on('change' , '.contact' ,function() {
                $(this).parents('.mt-repeater-item').find('.contactDetai').prop('placeholder' , $(this).find('option:selected').text());
            });*/
        });
    </script>
@endpush