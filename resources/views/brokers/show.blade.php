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


                <div class="row" style="margin-top: 30px;">
                    <div class="col-md-12">
                        <div class="portlet light bordered">


                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption font-red-sunglo">
                                        <i class="icon-settings font-red-sunglo"></i>
                                        <span class="caption-subject bold uppercase">عرض بيانات الوسيط</span>
                                    </div>

                                </div>
                                <div class="portlet-body form">
                                    <div class="form-body">
                                        <div class="form-group form-md-line-input">

                                            <label  class="form-control">{{ $broker->name }} </label>
                                            <label for="form_control_1">اسم الوسيط</label>
                                            <span class="help-block"></span>
                                        </div>

                                        <div class="form-group form-md-line-input">

                                            <label class="form-control">{{$broker->alias_name }}</label>
                                            <label for="form_control_1">اسم مستعار للوسيط</label>
                                            <span class="help-block"></span>
                                        </div>

                                        <div class="form-group mt-repeater form-md-line-input">
                                            <div data-repeater-list="group-c">

                                                @foreach($brokerContact as $a)
                                                    <div data-repeater-item class="mt-repeater-item">
                                                        <div class="row mt-repeater-row">

                                                            <div class="col-md-4">
                                                                <label class="control-label">اختر بيانات التواصل</label>
                                                                @foreach($contact as $i=>$c)
                                                                    @if($c->lookup_id == $a['contact_type'])
                                                                        <label class="form-control "> {{$c->lookup_title}}</label>
                                                                     @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="col-md-7">
                                                                <label class="control-label">ادخل بيانات التواصل</label>
                                                                <label class="form-control "> {{$a['contact_details']}}</label>
                                                            </div>
                                                            <div class="col-md-1">


                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label for="form_control_1">معلومات هامة عن الوسيط وشروط التعامل معه</label>
                                            <label style="height: 100px;" class="form-control">{{ $broker->information}}</label>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>


                                </div>
                            </div>

                        </div>
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
    <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
@endpush
@push('js')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{url('')}}/assets/global/plugins/jquery-repeater/jquery.repeater.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{url('')}}/assets/pages/scripts/form-repeater.min.js" type="text/javascript"></script>
    <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script>
        $(document).ready(function() {

        });
    </script>
@endpush