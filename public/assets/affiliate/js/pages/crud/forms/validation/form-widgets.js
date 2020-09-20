// Class definition

var KTFormWidgets = function () {
    // Private functions
    var validator;


    var initValidation = function () {
        validator = $( "#kt_form_1" ).validate({
            // define validation rules
            rules: {
                date: {
                    required: true,
                    date: true
                },
                daterange: {
                    required: true
                },
                datetime: {
                    required: true
                },
                time: {
                    required: true
                },

                select: {
                    required: true,
                    minlength: 2,
                    maxlength: 4
                },
                select2: {
                    required: true
                },
                typeahead: {
                    required: true
                },

                switch: {
                    required: true
                },

                markdown: {
                    required: true
                }
            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                var alert = $('#kt_form_1_msg');
                alert.removeClass('kt--hide').show();
                KTUtil.scrollTo('m_form_1_msg', -200);
            },

            submitHandler: function (form) {
                //form[0].submit(); // submit the form
            }
        });
    }

    return {
        // public functions
        init: function() {
            initValidation();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormWidgets.init();
});
