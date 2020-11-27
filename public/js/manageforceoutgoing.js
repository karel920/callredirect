$(document).ready(function() {

    $('#dataTable').dataTable();

    $("#dataTable").on("click", '#outgoing_status', function(event) {
        var outgoing_id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "http://192.168.101.17:8003/manage/outgoing/status",
            dataType: "json",
            data: {status: this.checked, outgoing_id: outgoing_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
})