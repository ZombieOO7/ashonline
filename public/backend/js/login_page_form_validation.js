var FormControls={
    init:function(){$("#m_form_1").validate
    (
        {
            rules:{
                email:{
                    required:true,
                    minlength:10,
                    maxlength: rule.email_length,
                },
                password:{
                    required:true,
                    maxlength: rule.password_max_length,
                    minlength: rule.password_min_length,
                },
            },
            messages: {
               email: {
                    required: 'Please enter Valid Email & it must be like xyz@example.com'
                },password: {
                    required: 'Please enter password'
                }

            }
        }
    )
    }
};
jQuery(document).ready(function(){FormControls.init()}
);