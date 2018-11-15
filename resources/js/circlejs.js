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

