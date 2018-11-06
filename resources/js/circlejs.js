$('body').on('click', '#deleteMember', function(){

    if (confirm("Are you sure you want to delete this member?")) {
        alert($(this).attr("data-member-id"));
      }
  });
