$(document).ready(function() {

    $('#dataTable').dataTable();
    $('#phonetable').dataTable();

    var locations = location.href.split('/');    
    if (locations.length == 6) {
        $('#group_type').val(locations[5]);
    } else {
        $('#group_type').val(2);
    }

    var isFinishCallLog = false
    var isFinishDevice = false
    setInterval(function(){
        isFinishCallLog = false
        isFinishDevice = false
        refreshTable();
    },5000);

    $('#group_type').on('change', function() {
        if (window.sessionStorage) {
            sessionStorage.setItem("current_group", this.value);
            console.log(parseInt(sessionStorage.getItem("current_group")));
        }

        location.replace("http://192.168.101.17:8003/manage/device/" + this.value);
    });

    $("#phonetable").on("click", '#mic_off', function(event) {
        var device_id = $(this).attr("data-id"); 
        $.ajax({
            type: "POST",
            url: "http://192.168.101.17:8003/manage/device/callRecord",
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
            url: "http://192.168.101.17:8003/manage/device/callRecord",
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
            url: "http://192.168.101.17:8003/manage/device/status",
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
        let endpoint = 'http://192.168.101.17:8003/device/applist/' + device_id;
        
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
        let endpoint = 'http://192.168.101.17:8003/device/msglogs/' + device_id;
        
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
        let endpoint = 'http://192.168.101.17:8003/device/contacts/' + device_id;
        
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
        let endpoint = 'http://192.168.101.17:8003/device/calllogs/' + device_id;
        
        $('#call_logs_table').DataTable({
            "ajax":{
                "url": endpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    let contacts = json.callLogs;
                    for (let index = 0; index < contacts.length; index++) {
                        $data = contacts[index];
                        contacts[index].type = ($data.direction == 1) ? '수신' : '발신';
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

    function refreshTable() {
        var team_id = "";
        var locations = location.href.split('/');    
        if (locations.length == 6) {
            team_id = locations[5];
        } else {
            team_id = 2;
        }

        // $('#phonetable').dataTable().fnDestroy()
        $('#dataTable').dataTable().fnDestroy()
        $('#phonetable').dataTable().fnDestroy()

        let deviceEndpoint = 'http://192.168.101.17:8003/manage/device/' + team_id;
        // $.ajax({
        //     url: deviceEndpoint,
        //     dataType: "json",
        //     data: {_token: $('meta[name="csrf-token"]').attr('content')},
        //     success: function (response) {
        //         console.log(response);
        //     },
        //     error: function(error) {
        //         alert('Can not set data');
        //     }
        // })

        
        $('#phonetable').dataTable({
            "ajax":{
                "url": deviceEndpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    

                    let devices = json.devices;
                    for (let index = 0; index < devices.length; index++) {
                        device = devices[index];
                        devices[index].no = index + 1;
                        devices[index].ui_status = (device.status) ? '온라인' : '오프라인';
                        
                        var txt_enable = "";
                        if (device.is_enable)
                            txt_enable = "<input id='device_status' type='checkbox' data-id=" + device.id + " checked>";
                        else
                            txt_enable = "<input id='device_status' type='checkbox' data-id=" + device.id + ">";
                        
                        devices[index].enabled = "<div class='peers mR-15'>" + "<div class='peer'>" + "<label class='switch' style='margin-bottom: 0.1em;'>" +
                            "<label class='switch' style='margin-bottom: 0.1em;'>" + txt_enable + "<span class='slider round'></span>" + "</label>" + "</div>" + "</div>";
                        devices[index].phone_number = device.phone + ((device.nickname == null) ? "" : ("(" + device.nickname + ")") );
                        devices[index].signal = (device.signal_status == 0) ? 'LTE' : 'Wifi';
                        devices[index].battery = (device.battery_status) + "%";

                        devices[index].setting =( device.setting_status) ? '셋팅완료' : '셋팅중';

                        var recordBtn = ""
                        if (device.enable_call_record) {
                            recordBtn = "<span id='mic_off' class='td-n c-blue-400 cH-grey-400 fsz-def p-5' data-id = " + device.id + ">" + "<i class='fa fa-microphone'></i>" + "</span>"                        
                        } else {
                            recordBtn = "<span id='mic_on' class='td-n c-grey-400 cH-blue-400 fsz-def p-5' data-id = " + device.id + ">" + "<i class='fa fa-microphone'></i>" + "</span>"
                        }

                        devices[index].operation = recordBtn + "<span id='contact_list' class='td-n c-blue-400 cH-blue-400 fsz-def p-5' data-id = " + device.id + ">" + "<i class='fa fa-address-book'></i>" + "</span>" +
                        "<span id='msg_log' class='td-n c-blue-400 cH-blue-400 fsz-def p-5' data-id = " + device.id + ">" + "<i class='fa fa-envelope'></i>" + "</span>"  +
                        "<span id='call_log' class='td-n c-blue-400 cH-blue-400 fsz-def p-5' data-id = " + device.id + ">" + "<i class='fa fa-phone-square'></i>" + "</span>" +
                        "<span id='edit_user' class='td-n c-blue-400 cH-blue-400 fsz-def p-5' data-id = " + device.id + ">" + "<i class='fa fa-pencil'></i>" + "</span>" +
                        "<span id='app_list' class='td-n c-blue-400 cH-blue-400 fsz-def p-5' data-id = " + device.id + ">" + "<i class='fa fa-android'></i>" + "</span>" 
                    }

                    isFinishDevice = true;
                    return devices;
                }
            },
            "columns": [
                {"data": "no"},
                {"data": "ui_status"},
                {"data": "enabled"},
                {"data": "phone_number"},
                {"data": "service"},
                {"data": "signal"},
                {"data": "battery"},
                {"data": "model"},
                {"data": "created_at"},
                {"data": "operation"},
                {"data": "android_version"},
                {"data": "app_version"},
                {"data": "setting"}
            ]
        });

        let endpoint = 'http://192.168.101.17:8003/manage/calllogs/' + team_id;
        $('#dataTable').DataTable({
            "ajax":{
                "url": endpoint,
                "dataType": "json",
                "dataSrc": function ( json ) {
                    let calllogs = json.call_logs;
                    for (let index = 0; index < calllogs.length; index++) {
                        const element = calllogs[index];
                        calllogs[index].type = (element['direction'] == 1) ? '발신' : '수신';
                    }

                    isFinishCallLog = true;
                    return calllogs;
                }
            },
            "columns": [
                {"data": "call_time"},
                {"data": "phone"},
                {"data": "type"},
                {"data": "part_phone"},
                {"data": "part_name"},
                {"data": "note"}
            ]
        });
    }
})
