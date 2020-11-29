$(document).ready(function() {

    $('#dataTable').dataTable();

    $("#dataTable").on("click", '#play_audio', function(event) {
        var path = $(this).attr("data-path");

        $('#playerModal').modal('show');
        var video = document.getElementById('player');
        var source = document.createElement('source');

        source.setAttribute('src', path);

        video.appendChild(source);
        video.play();
    });
})