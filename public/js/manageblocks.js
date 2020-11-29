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

        location.replace("http://124.248.202.226/manage/blocks/" + this.value);
    });

    $('#btn_blocking').on('click', function() {
        var block_name = $('#block_name').val();
        var phone_number = $('#phone_number').val();

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/blocks/add",
            dataType: "json",
            data: {team_id: team_id, name: block_name, phone: phone_number, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $("#dataTable").on("click", '#block_status', function(event) {
        var block_id = $(this).attr("data-id");

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/blocks/status",
            dataType: "json",
            data: {status: this.checked, block_id: block_id, team_id: team_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $("#dataTable").on("click", '#delete_block', function(event) {
        var block_id = $(this).attr("data-id");

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/blacklist/delete",
            dataType: "json",
            data: {block_id: block_id, team_id: team_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
})