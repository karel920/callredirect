@extends('layouts.master')

@section('head')
<script src="{{ asset('js/lib/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/managevideo.js') }}"></script>
<link href="{{ asset('css/bootstrap-3.3.2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-multiselect.css') }}" rel="stylesheet">

<style>
.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    display: none;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
}
</style>

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
                            <span class="fsz-md c-grey-900">그룹명: </span>
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
                                <img class="w-4r bdrs-50p" src="https://randomuser.me/api/portraits/men/10.jpg" alt="">
                            </div>
                            <div class="peer">
                                <span class="fsz-lg c-grey-900">{{ Auth::user()->user_id }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu fsz-lg">
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
                    <h4 class="c-grey-900 mT-10 mB-30">카메라데이터관리</h4>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="row">
                                <div class="col-sm-4 col-md-2">
                                    <div class="md-form form-group">
                                        <label for="user_id" class="active">디바이스를(들을) 선택하세요.</label>
                                        <select id="phone_type" name="phone_type[]" class="form-control" multiple>
                                            @foreach($devices as $i=>$device)
                                            <option value="{{ $device['id'] }}">{{ $device['phone'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-3">
                                    <div class="md-form form-group">
                                        <label for="duration" class="active">녹화시간</label>
                                        <input class="form-control" id="duration" name="duration" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-md-1">
                                    <div style="margin: 25px 0">
                                        <button id="request_record" class="btn btn-info waves-effect waves-light" role="button" aria-pressed="true">저장</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <table id="dataTable" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>폰번호</th>
                                            <th>녹음시간</th>
                                            <th>기간</th>
                                            <th>록음</th>
                                            <th>조작</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($records as $i=>$record)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $record['phone']}}</td>
                                            <td>{{ $record['record_time']}}</td>
                                            <td>{{ $record['duration'] }}</td>
                                            <td>
                                                <div class="peers mR-15">
                                                    <div class="peer">
                                                        <span id="play_video" class="td-n c-deep-purple-500 cH-blue-500 fsz-mid p-5" data-path="{{ $record['path'] }}">
                                                            <i class="ti-control-play"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="peers mR-15">
                                                    <div class="peer">
                                                        <span id="delete_income" class="td-n c-deep-purple-500 cH-blue-500 fsz-mid p-5">
                                                            <i class="ti-trash"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="playerModal">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="bd p-15">
                                <h5 class="m-0"></h5>
                            </div>
                            <div class="modal-body">
                                <video width="100%" height="100%" controls id="player">
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection