function initMap() {
    // The location of Uluru
    const uluru = { lat: -25.344, lng: 131.036 };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: uluru,
    });
    // // The marker, positioned at Uluru
    // const marker = new google.maps.Marker({
    //   position: uluru,
    //   map: map,
    // });
}

$(document).ready(function () {

    $('#dataTable').dataTable();

    $('#phone_type').multiselect({
        nonSelectedText: '디바이스를(들을) 선택하세요.',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '200px'
    });

    var locations = location.href.split('/');
    if (locations.length == 6) {
        $('#group_type').val(locations[5]);
    } else {
        $('#group_type').val(2);
    }

    $('#group_type').on('change', function () {
        if (window.sessionStorage) {
            sessionStorage.setItem("current_group", this.value);
            console.log(parseInt(sessionStorage.getItem("current_group")));
        }

        location.replace("http://124.248.202.226:8888/manage/location/" + this.value);
    });

    $('#dataTable tbody tr').on('click', function (event) {
        let location = this.children[2].textContent;

        var longitude = location.split(":")[0];
        var latitude = location.split(":")[1];

        console.log(latitude + ":" + longitude);

        const uluru = { lat: parseFloat(latitude), lng: parseFloat(longitude) };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: uluru,
        });

        const marker = new google.maps.Marker({
            position: uluru,
            map: map,
        });
    });

    $('#request_location').on('click', function () {
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
            url: "http://124.248.202.226:8888/manage/location/add",
            dataType: "json",
            data: { team_id: team_id, phone_type: phone_type, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (error) {
                alert('Can not set data');
            }
        })
    });

    $("#dataTable").on("click", '#delete_location', function (event) {
        var location_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "http://124.248.202.226:8888/manage/location/delete",
            dataType: "json",
            data: { location_id: location_id, _token: $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function (error) {
                alert('Can not set data');
            }
        })
    });
})