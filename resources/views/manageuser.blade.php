@extends('layouts.master')

@section('head')
<script src="{{ asset('js/manageforceincome.js') }}"></script>
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
                            <i class="c-deep-orange-500 ti-bell"></i>
                        </span>
                        <span class="title">지도보기</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class='sidebar-link' href="{{ url('/manage/location') }}">
                        <span class="icon-holder">
                            <i class="c-deep-orange-500 ti-bell"></i>
                        </span>
                        <span class="title">신청자료</span>
                    </a>
                </li> -->
            </ul>
        </div>
    </div>

    <div class="page-container">
        <div class="header navbar">
            <div class="header-container">
                <ul class="nav-left">
                    <li>
                        <a id='sidebar-toggle' class="sidebar-toggle" href="javascript:void(0);">
                            <i class="ti-menu"></i>
                        </a>
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
                    <h4 class="c-grey-900 mT-10 mB-30">사용자관리</h4>
                    <div class="row">
                        @if($can_add)
                        <div class="col-md-12">
                            <form name="register_user" method="POST" action="{{ route('registerUser') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4 col-md-2">
                                        <div class="md-form form-group">
                                            <label for="user_id" class="active">아이디</label>
                                            <input class="form-control" id="user_id" name="user_id" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-3">
                                        <div class="md-form form-group">
                                            <label for="password" class="active">비번</label>
                                            <input class="form-control" id="password" name="password" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="md-form form-group">
                                            <label for="service_date" class="active">그룹명</label>
                                            <input class="form-control" id="team_name" name="team_name" type="text">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="md-form form-group">
                                            <label for="service_date" class="active">발급날자</label>
                                            <input class="form-control" id="service_date" name="service_date" type="date">
                                        </div>
                                    </div>
                                    <div class="col-sm-4 col-md-2">
                                        <div class="md-form form-group">
                                            <label for="expire_date" class="active">유효기간</label>
                                            <input class="form-control" id="expire_date" name="expire_date" type="date">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 col-md-1">
                                        <div style="margin: 28px 0">
                                            <button class="btn btn-info waves-effect waves-light" type="submit" role="button" aria-pressed="true">저장</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                                <table id="dataTable" class="table table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>아이디</th>
                                            <th>비번</th>
                                            <th>그룹명</th>
                                            <th>레벨</th>
                                            <th>상태</th>
                                            <th>발급날자</th>
                                            <th>유효기간</th>
                                            <th>조작</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $i=>$user)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $user['user_id']}}</td>
                                            <td>{{ $user['password']}}</td>
                                            <td>{{ $user['team'] }}</td>
                                            @if ($user['level'] == 0)
                                            <td>어드민</td>
                                            @elseif ($user['level'] == 1)
                                            <td>관리자</td>
                                            @else
                                            <td>사용자</td>
                                            @endif
                                            <td>{{ ($user['status']) ? '사용중' : '사용중지' }}</td>
                                            <td>{{ $user['service_date'] }}</td>
                                            <td>{{ $user['expire_date'] }}</td>
                                            <td>
                                                <div class="peers mR-15">
                                                    <div class="peer">
                                                        <span id="delete_income" class="td-n c-deep-purple-500 cH-blue-500 fsz-def p-5" data-userId="{{ strval($user['id']) }}">
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
            </div>
        </main>
    </div>
</div>
@endsection