$(document).ready(function() {

    $('#dataTable').dataTable();

    var video;
    var source;

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

        location.replace("http://124.248.202.226:8888/manage/record/" + this.value);
    });

    $("#dataTable").on("click", '#delete_call', function(event) {
        var record_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226:8888/manage/call/delete",
            dataType: "json",
            data: {record_id: record_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });
    
    $("#dataTable").on("click", '#play_audio', function(event) {
        var path = $(this).attr("data-path");

        $('#playerModal').modal('show');

        video = document.getElementById('player');
        if (source == null) {
            source = document.createElement('source');
            video.appendChild(source);
        }
        

        source.setAttribute('src', path);
        video.load();
        video.play();
    });

    $('#playerModal').on('hidden.bs.modal', function () {
        console.log('Hidden');
        video = document.getElementById('player');
        video.pause();
    });
})