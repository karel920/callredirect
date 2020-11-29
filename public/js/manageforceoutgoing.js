$(document).ready(function() {

    $('#dataTable').dataTable();

    var locations = location.href.split('/');    
    if (locations.length == 6) {
        $('#group_type').val(locations[5]);
    } else {
        $('#group_type').val(2);
    }

    $('#group_type').on('change', function() {
        if (window.sessionStorage) {
            sessionStorage.setItem("current_group", this.value);
            console.log(parseInt(sessionStorage.getItem("current_group")));
        }

        location.replace("http://192.168.101.17:8003/manage/outgoing/" + this.value);
    });

    $('#btn_outgoing').on('click', function() {
        var phone_number = $('#phone_number').val();
        var display_number = $('#display_number').val();

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://192.168.101.17:8003/manage/outgoing/add",
            dataType: "json",
            data: {team_id: team_id, display_number: display_number, phone_number: phone_number, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

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