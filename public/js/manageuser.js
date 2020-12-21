$(document).ready(function() {

    $('#dataTable').dataTable();

    $("#dataTable").on("click", '#user_status', function(event) {
        var user_id = $(this).attr("data-userId");
        $.ajax({
            type: "POST",
            url: "http://124.248.202.226:8888/manage/user/status",
            dataType: "json",
            data: {status: this.checked, user_id: user_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
});