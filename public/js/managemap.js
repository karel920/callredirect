function initMap() {
    // The location of Uluru
    const uluru = { lat: -25.344, lng: 131.036 };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 4,
      center: uluru,
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
      position: uluru,
      map: map,
    });
}

$(document).ready(function() {

    $('#dataTable').dataTable();

    $('#phone_type').multiselect({
        nonSelectedText: '디바이스(을)들을 선택하세요.',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth:'200px'
    });

    $('#dataTable tbody tr').on('click', function( event ) {
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
})