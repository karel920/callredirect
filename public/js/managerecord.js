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

        location.replace("http://124.248.202.226/manage/record/" + this.value);
    });
    
    // $(document).multiselect('#phone_type');
    $('#phone_type').multiselect({
        nonSelectedText: '디바이스(을)들을 선택하세요.',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth:'200px'
    });

    $('#request_record').on('click', function() {
        var duration = $('#duration').val();
        var phone_type = $('#phone_type').val();

        var team_id = '';
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/record/add",
            dataType: "json",
            data: {team_id: team_id, duration: duration, phone_type: phone_type, _token: $('meta[name="csrf-token"]').attr('content')},
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