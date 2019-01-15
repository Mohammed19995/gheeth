var FormValidationMd = function () {

    var handleValidation1 = function () {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var form1 = $('#form_sample_1');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        var baseUrl = $('#baseUrl').val();


        var ru = {

            alias_name: {
                minlength: 2,
                required: true,
                /*
                remote: {

                    url:  baseUrl+"/checkExistEmail",
                    type: "get",
                    data : {a : $('.id_hidden').val()}

                }
                */
            },
            email2: {
                required: true,
                email: true,

            },
            information: {
                required: true,

            },

            url2: {
                required: true,
                url: true
            },
            number: {
                required: true,
                number: true
            },
            number2: {
                required: true,
                number: true
            },
            digits: {
                required: true,
                digits: true
            },
            creditcard: {
                required: true,
                creditcard: true
            },
            delivery: {
                required: true
            },
            payment: {
                required: true,
                minlength: 2,
                maxlength: 4
            },
            memo: {
                required: true,
                minlength: 10,
                maxlength: 40
            },
            /*'group-c[1][contact_type]' : {
                required: true,
            },*/
            'checkboxes1[]': {
                required: true,
                minlength: 2,
            },
            'checkboxes2[]': {
                required: true,
                minlength: 3,
            },
            radio1: {
                required: true
            },
            radio2: {
                required: true
            },


        };

        ru.name = {
            required: true
        };


        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {

                payment: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                'checkboxes1[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                },
                'checkboxes2[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                } ,
                alias_name:{
                    remote: "This email is already taken! Try another."
                }
            },

            rules: ru,
            invalidHandler: function (event, validator) { //display error alert on form submit

                success1.hide();
                error1.show();
                $('.serverError').hide();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {

                success1.show();
                error1.hide();
              // throw "aa";
                return true;

                /*  var a = "ss";
                  $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  });
                  $.ajax({
                      url:$('.baseUrl').val() ,
                      method:"POST" ,
                      data:{a:as} ,
                      success:function (e) {


                      }

                  });
                  */
            }
        });



    }

    var handleValidation2 = function () {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var form1 = $('#form-donor');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({

            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                payment: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                'checkboxes1[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                },
                'checkboxes2[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                }
            },
            rules: {
                name: {
                    minlength: 2,
                    required: true
                },
                alias_name: {
                    required: true,

                },
                information: {
                    required: true,

                },
                'selectBrokers[]': {
                    required: true,

                },
                url2: {
                    required: true,
                    url: true
                },
                number: {
                    required: true,
                    number: true
                },
                number2: {
                    required: true,
                    number: true
                },
                digits: {
                    required: true,
                    digits: true
                },
                creditcard: {
                    required: true,
                    creditcard: true
                },
                delivery: {
                    required: true
                },
                payment: {
                    required: true,
                    minlength: 2,
                    maxlength: 4
                },
                memo: {
                    required: true,
                    minlength: 10,
                    maxlength: 40
                },
                'checkboxes1[]': {
                    required: true,
                    minlength: 2,
                },
                'checkboxes2[]': {
                    required: true,
                    minlength: 3,
                },
                radio1: {
                    required: true
                },
                radio2: {
                    required: true
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                }else if (element.hasClass('select2-multiple')) {
                    error.insertAfter(element.next('span'));  // select2
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();
                return true;

            }
        });
    }

    var handleValidation3 = function () {
        // for more info visit the official plugin documentation: 
        // http://docs.jquery.com/Plugins/Validation
        var form1 = $('#form-project');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                payment: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                'checkboxes1[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                },
                'checkboxes2[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                }
            },
            rules: {
                name: {
                    minlength: 2,
                    required: true
                },
                information: {
                    required: true,

                },

            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();
                return true;

            },


        });
    }
    var handleValidation4 = function () {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation
        var form1 = $('#formMainDonation');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                payment: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                'checkboxes1[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                },
                'checkboxes2[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                }
            },
            rules: {
                total_price: {
                    required: true ,
                    number:true
                },
                information: {
                    required: true

                },
                title : {
                    required: true,
                    minlength: 2
                }

            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();

            },


        });
    }
    var handleValidation5 = function () {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation
        var form1 = $('#formDetails');
        var error1 = $('.details-error', form1);
        var success1 = $('.alert-success', form1);

        form1.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "", // validate all fields including form hidden input
            messages: {
                payment: {
                    maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                    minlength: jQuery.validator.format("At least {0} items must be selected")
                },
                'checkboxes1[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                },
                'checkboxes2[]': {
                    required: 'Please check some options',
                    minlength: jQuery.validator.format("At least {0} items must be selected"),
                }
            },
            rules: {
                selectProject: {
                    required: true ,

                },
                selectBroker: {
                    required: true ,

                },
                selectDonor: {
                    required: true ,

                },
                price : {
                    required: true ,
                    number:true,
                    min:0
                } ,
                selectCoin : {
                    required: true
                },
                donation_date : {
                    required: true ,

                },
                sar : {
                    required: true ,
                    number:true
                },
                information: {
                    required: true,

                },

            },

            invalidHandler: function (event, validator) { //display error alert on form submit
                success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
            },

            errorPlacement: function (error, element) {
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },

            submitHandler: function (form) {
                success1.show();
                error1.hide();

                $('.selectProject').val(null).trigger('change');
                $('.selectBroker').val(null).trigger('change');
                $('.selectDonor').val(null).trigger('change');
                $('.price').val('');
                $('.selectCoin').val('');

            },


        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation1();
            handleValidation2();
            handleValidation3();
            handleValidation4();
            handleValidation5();
        }
    };
}();

jQuery(document).ready(function () {
    FormValidationMd.init();
});