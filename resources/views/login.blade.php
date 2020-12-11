@extends('layouts.app')

@section('head')

<style type="text/css">
	.container {
        max-width: 450px;
    }
</style>
<script src="{{ asset('js/login.js') }}"></script>

@endsection

@section('content')
<div>
    <form name="frm" method="POST" action="{{ route('login_post') }}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="card card-login">
                    <div class="card-body">
                        <!-- Header -->
                        <div class="form-header info-color">
                            <h3 class="mt-2" style="color: #17a2b8!important;"><i class="fa fa-bank"></i>
                                <b>KB국민은행</b>
                            </h3>
                        </div>

                        <div class="md-form">
                            <input type="text" id="user_id" name="user_id" class="form-control" placeholder="아이디">
                        </div>
                        <div class="md-form">
                            <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호">
                        </div>
                        <div class="text-center">
                            <button class="btn btn-info waves-effect waves-light" type="submit" style="color: #17a2b8 !important; background-color: white;">로그인 <i class="fa fa-sign-in"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection