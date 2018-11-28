$('body').on('click', '#deleteMember', function(){
    if (confirm("Are you sure you want to delete this member?")) {
        //alert($(this).attr("data-member-id"));
        $("#deleteMemberForm").attr("action", "/communitymember/" + $(this).attr("data-member-id"));
        $("#deleteMemberForm").submit();
    }
});


$( document ).ready(function() {

    $("#checkall").click(function(){
        event.preventDefault();

        if ($("input[type='checkbox']").prop("checked"))
        {
            $(':checkbox').prop('checked', false);
            $(this).text('Check all');
        }
        else
        {
            $(':checkbox').prop('checked', true);
            $(this).text('Uncheck all');
        }

    });
});


$.validator.setDefaults( {
    submitHandler: function () {
        $( "#updatePassForm" ).submit();
    }
} );

$( document ).ready( function () {
    $( "#updatePassForm" ).validate( {
        rules: {
            newpassword: {
                required: true,
                minlength: 6
            },
            newpasswordagain: {
                required: true,
                minlength: 6,
                equalTo: "#newpassword"
            }
        },
        messages: {
            newpassword: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            newpasswordagain: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            }
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('alert alert-danger');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('alert alert-danger');
        }
    } );
}
);
