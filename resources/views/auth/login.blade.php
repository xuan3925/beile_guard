@extends('layouts.app')

@section('title')
@endsection

@section('header')
@endsection

@section('content')

@include('common.header')

<div class="jm-post jm-login">
    <div class="jm-post-title">
        <p>活动登录</p>
    </div>
    <div class="jm-post-body">
        <div class="jm-post-con">
            <div class="jm-form">
                <div class="jm-form-group">
                    <input type="number" class="jm-input" size="11" name="phone" placeholder="请输入手机号码"/>
                </div>
                <div class="jm-form-group">
                    <input type="password" class="jm-input" name="password" placeholder="请输入密码"/>
                </div>
                <a href="{{ route('password.request').$referer_path }}" class="jm-link-forget">
                    <img src="{{ resources_domain('images/icon_forget.png') }}" />
                    <span>忘记密码</span>
                </a>
                <div class="jm-form-btns">
                    <a href="javascript:;" id="register">
                        <img src="{{ resources_domain('images/btn_register.png') }}" />
                    </a>
                    <a href="javascript:;" id="login">
                        <img src="{{ resources_domain('images/btn_login.png') }}" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(function () {

        $("#register").on('click', function() {
            @if (is_activity_stop())
                activity_stop();
            @else
                window.location.href = '{{ route('register').$referer_path }}';
            @endif
        });

        $('#login').on('click', function () {
            var data = {
                phone : $('input[name=phone]').val(),
                password : $('input[name=password]').val()
            };

            if (data.phone == "") {
                jmMsg("请输入正确的手机号码");
                return false;
            } else if (!checkPhone(data.phone)) {
                jmMsg("请输入正确的手机号码");
                return false;
            } else if (data.password == "") {
                jmMsg("请输入密码");
                return false;
            } else {
                jmAjax({
                    url: "{{ route('login') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        window.location.href = '{{ $redirect_path }}';
                    }
                });
            }
        });

    });
</script>
@endsection