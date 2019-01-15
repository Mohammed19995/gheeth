var FormRepeater = function () {

    return {
        //main function to initiate the module
        init: function () {
        	$('.mt-repeater').each(function(){
        		var _this = $(this);
        		$(this).repeater({
        			show: function () {
	                	$(this).slideDown();
                        $('.date-picker').datepicker({
                            rtl: App.isRTL(),
                            orientation: "left",
                            autoclose: true
                        });
		            },

		            hide: function (deleteElement) {

        				if(_this.find('.mt-repeater-item').length == 1) {
        					alert("لا يمكنك الحذف");
						}else {
                            if(confirm('هل انت متأكد من حذف هذا العنصر ؟')) {
                                $(this).slideUp(deleteElement);
                            }
						}

		            },

		            ready: function (setIndexes) {

		            }

        		});
        	});
        }

    };

}();

jQuery(document).ready(function() {
    FormRepeater.init();
});
