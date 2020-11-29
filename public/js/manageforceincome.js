$(document).ready(function() {

    $('#dataTable').dataTable();

    var locations = location.href.split('/');    
    if (locations.length == 6) {
        $('#group_type').val(locations[5]);
    } else {
        $('#group_type').val(2);
    }

    $('#btn_income').on('click', function() {
        var phone = $('#phone_receive').val();
        console.log(phone);
        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/income/update",
            dataType: "json",
            data: {team_id: team_id, phone: phone, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $('#save_income_list').on('click', function() {
        var phone = $('#phone_income_list').val();
        var name = $('#name_income').val();
        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/incomelist/add",
            dataType: "json",
            data: {team_id: team_id, phone: phone, name: name, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $('#group_type').on('change', function() {
        if (window.sessionStorage) {
            sessionStorage.setItem("current_group", this.value);
            console.log(parseInt(sessionStorage.getItem("current_group")));
        }

        location.replace("http://124.248.202.226/manage/income/" + this.value);
    });

    $("#dataTable").on("click", '#income_status', function(event) {
        var income_id = $(this).attr("data-id");
        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/income/status",
            dataType: "json",
            data: {status: this.checked, income_id: income_id, team_id: team_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
})