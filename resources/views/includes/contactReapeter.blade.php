@if ($add)

    <div data-repeater-item class="mt-repeater-item">

        <div class="row mt-repeater-row">

            <div class="col-md-4">
                <div class="form-group form-md-line-input">
                    <label class="control-label">اختر بيانات التواصل</label>
                    <input type="hidden" value="" class="getValidate" name="getValidate">

                    <select class="form-control contact contact_type" name="contact_type">

                        <option></option>
                        @foreach($contact as $i=>$c)
                            <option value="{{$c->lookup_id}}">{{$c->lookup_title}}</option>
                        @endforeach
                    </select>
                    <span class="help-block"></span>
                </div>

            </div>
            <div class="col-md-7">
                <div class="form-group form-md-line-input">
                    <label class="control-label">ادخل بيانات التواصل</label>
                    <input type="text" name="contact_details"
                           placeholder="ادخل بيانات التواصل" autocomplete="off"
                           class="form-control contactDetail contact_details"/>
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="col-md-1">

                <a href="javascript:;" data-repeater-delete
                   class="btn btn-danger mt-repeater-delete">
                    <i class="fa fa-close"></i>
                </a>
            </div>
        </div>

    </div>





@else


    @foreach($arr as $ind=>$a)

        <div data-repeater-item class="mt-repeater-item">

            <div class="row mt-repeater-row">

                <div class="col-xs-4">
                    <div class="form-group form-md-line-input">
                        <label class="control-label">اختر بيانات التواصل</label>
                        @foreach($contact as $i=>$c)
                            <input type="hidden" value="{{array_key_exists('contact_type', $a) ? $a['contact_type'] == $c->lookup_id ? $c->lookup_slug : '' : '' }}" class="getValidate" name="getValidate">
                        @endforeach



                        <select class="form-control contact contact_type" name="contact_type">
                            @foreach($contact as $i=>$c)
                                <option value="{{$c->lookup_id}}" {{array_key_exists('contact_type', $a) ? $a['contact_type'] ==$c->lookup_id ? 'selected' : '' : '' }} >{{$c->lookup_title}}</option>
                            @endforeach
                        </select>
                        <span class="help-block"></span>

                    </div>

                </div>
                <div class="col-xs-7">
                    <div class="form-group form-md-line-input">
                        <label class="control-label">ادخل بيانات التواصل</label>
                        <input type="text" name="contact_details"
                               value="{{$a['contact_details']}}"
                               placeholder="ادخل بيانات التواصل" autocomplete="off"
                               class="form-control contactDetail contact_details"/>
                        <span class="help-block"></span>


                    </div>
                </div>
                <div class="col-xs-1">

                    <a href="javascript:;" data-repeater-delete
                       class="btn btn-danger mt-repeater-delete">
                        <i class="fa fa-close"></i>
                    </a>
                </div>

            </div>

        </div>
    @endforeach


@endif