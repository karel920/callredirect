$(document).ready(function() {

    $('#dataTable').dataTable();

    $("#dataTable").on("click", '#income_status', function(event) {
        var income_id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "http://192.168.101.17:8003/manage/income/status",
            dataType: "json",
            data: {status: this.checked, income_id: income_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
})