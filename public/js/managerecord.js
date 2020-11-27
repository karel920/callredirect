$(document).ready(function() {

    $('#dataTable').dataTable();

    // $(document).multiselect('#phone_type');
    $('#phone_type').multiselect({
        nonSelectedText: '디바이스(을)들을 선택하세요.',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth:'200px'
    });
})