$(document).ready(function(){
/*    $('a.nav-link').on('click', function(){
        if(!$(this).hasClass("nav-toggle")) {
            $('li').removeClass('active open');
            $(this).parent().parent().parent().addClass('active open');
        }
    });*/
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $('.date-picker').datepicker();
    $('.select2').select2();
    // Is incident known resource
    $('#checkbox1').on('change', function(){
       var is_checked = $(this).is(':checked');
        if(is_checked) {
           $('#user_information').show();
        } else {
            $('#user_information').hide();
        }
    });

/*    $('#is_urgent').on('change', function(){
        var is_checked = $(this).val();
        if(is_checked == 1) {
            $('.urgent').show();
            $('.normal').hide();
        } else {
            $('.normal').show();
            $('.urgent').hide();
        }
    });*/

    $('#checkbox2').on('change', function(){
        var is_checked = $(this).is(':checked');
        if(is_checked) {
            $('#dispatch_section').show();
        } else {
            $('#dispatch_section').hide();
        }
    });

    // Neighborhood
    $(document).on('change', '#neighborhood_id', function(){
        $('#milestone_id').html('');
        var $this = $(this);
                        // Get Milestones
            $.ajax({
                url: $this.data('url'),
                type: 'get',
                dataType: 'json',
                data: {
                    neighborhood_id: $this.val()
                }
            }).done(function(response){
                var option = $('<option />');
                option.attr('value', -1).text('');
                $('#milestone_id').append(option);
                $(response.data).each(function(){
                    var option = $('<option />');
                    option.attr('value', this.milestone_id).text(this.milestone_title);

                    $('#milestone_id').append(option);
                });
                $('#milestone_id').removeAttr('disabled');

            });

    });
    // Name
   /* $(document).on('blur', '.applicant_info', function(){
        var $this = $(this);
        if($this.val() != '' && $this.val() != undefined)
        {
            $.ajax({
                url: 'getApplicantInfo',
                type: 'get',
                dataType: 'json',
                data: {
                    name: $this.val(),
                    type: $this.data('type')
                }
            }).done(function(response){
                //clearForm();
                if(response.data.id != undefined){
                    if($('#applicant_identity').val() =='') $('#applicant_identity').val(response.data.identity);
                    if($('#applicant_mobile').val() == '')  $('#applicant_mobile').val(response.data.mobile);
                    if($('#applicant_phone').val() == '')  $('#applicant_phone').val(response.data.phone);
                    if($('#applicant_name').val() == '')  $('#applicant_name').val(response.data.name);
                    if($('#applicant_email').val() == '')  $('#applicant_email').val(response.data.email);
                    if($('#applicant_id').val() == '')  $('#applicant_id').val(response.data.id);
                    if($('#x_coord').val() == '')  $('#x_coord').val(response.data.x);
                    if($('#y_coord').val() == '')  $('#y_coord').val(response.data.y);

                    // Add Marker to map //
                    L.marker([response.data.x, response.data.y]).addTo(map);
                        //.bindPopup('');
                        //.openPopup();
                    /!*map = new GMaps({
                        div: '#map',
                        zoom: 16,
                        lat: response.data.x,
                        lng: response.data.y,
                        click: function(e){
                            $('#x_coord').val(e.latLng.lat());
                            $('#y_coord').val(e.latLng.lng());
                        }
                    });
                    map.setCenter(response.data.x,response.data.y,'');*!/

                    if($('#applicant_id').val() == '')  $('#applicant_id').val(response.data.id);
                    if($('#applicant_subscription').val() == '')  $('#applicant_subscription').val(response.data.subscription);
                    if($('#building_number').val() == '')  $('#building_number').val(response.data.building);
                    if($('#neighborhood_id').val() == '') $('#neighborhood_id').val(response.data.neighborhood).trigger('change');
                    if($('#street_id').val() == '') $('#street_id').val(response.data.street).trigger('change');
                }  else {
                    $('#applicant_id').val('');
                }
            });
        }
    });*/

    function clearForm() {
        $('#applicant_mobile').val('');
        $('#street_id').val('');
        $('#applicant_phone').val('');
        $('#applicant_name').val('');
        $('#applicant_email').val('');
        $('#applicant_id').val('');
        $('#applicant_subscription').val('');
        $('#building_number').val('');
        $('#neighborhood_id').val('').trigger('change');
    }


    // Add new ite
    $(document).on('click', '.addNewItemBtn', function(){
        var count = $('#count').val();
        $('.clone_item:first').clone().removeClass('clone_item').addClass('cloned').appendTo('.clone_item');
    });

});


