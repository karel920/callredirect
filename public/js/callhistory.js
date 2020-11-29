$(document).ready(function() {

    $('#dataTable').dataTable();

    var video;
    var source;

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