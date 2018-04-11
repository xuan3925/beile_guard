@extends('layouts.app')

@section('title')
@endsection

@section('header')
@endsection

@section('content')

@include('common.header')

<div class="jm-post jm-register">
    <div class="jm-post-title">
        <p>活动报名</p>
    </div>
    <div class="jm-post-body">
        <div class="jm-post-con">
            <div class="jm-form">
                <div class="jm-form-group">
                    <input type="text" class="jm-input" name="nickname" placeholder="学员姓名" />
                </div>
                <div class="jm-form-group">
                    <input type="number" class="jm-input" size="2" name="age" placeholder="学员年龄" />
                </div>
                <div class="jm-form-group">
                    <input type="number" class="jm-input" size="11" name="phone" placeholder="联系方式" />
                </div>
                <div class="jm-form-group">
                    <input type="password" class="jm-input" name="password" placeholder="设置密码" />
                </div>
                <div class="jm-form-group">
                    <input type="password" class="jm-input" name="password_confirmation" placeholder="确认密码" />
                </div>
                <div class="jm-form-group">
                    <input type="text" class="jm-input" readonly id="city" name="city" placeholder="所在城市"/>
                    <img src="{{ resources_domain('images/icon_arrow_down.png') }}" class="jm-select-arrow"/>
                </div>
                <div class="jm-form-group jm-radio-groups">
                    <div class="jm-radio-group" data-val="1">
                        <div class="jm-radio">
                            <span></span>
                        </div>
                        <label>贝乐学员</label>
                    </div>
                    <div class="jm-radio-group" data-val="0">
                        <div class="jm-radio">
                            <span></span>
                        </div>
                        <label>非学员</label>
                    </div>
                </div>
                <div class="jm-form-btns jm-form-btn">
                    <a href="javascript:;" id="submit">
                        <img src="{{ resources_domain('images/btn_done_reg.png') }}" />
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

        $('#submit').on('click', function () {
            var data = {
                phone : $('input[name=phone]').val(),
                nickname : $('input[name=nickname]').val(),
                password : $('input[name=password]').val(),
                password_confirmation : $('input[name=password_confirmation]').val(),
                age : $('input[name=age]').val(),
                city : $('input[name=city]').val(),
                is_our_users : $('.jm-radio-active').length > 0 ? $('.jm-radio-active').data('val') : ""
            };

            if (data.nickname == "") {
                jmMsg("请输入学员姓名");
                return false;
            } else if (data.nickname.length > 20) {
                jmMsg("学员姓名最多可以输入20个字符");
                return false;
            } else if (data.age == "") {
                jmMsg("请输入学员年龄");
                return false;
            } else if (data.phone == "") {
                jmMsg("请输入正确的手机号码");
                return false;
            } else if (!checkPhone(data.phone)) {
                jmMsg("请输入正确的手机号码");
                return false;
            } else if (data.password == "") {
                jmMsg("请设置密码");
                return false;
            } else if (data.password.length < 6 || data.password.length > 16) {
                jmMsg("请设置6-16位的密码");
                return false;
            } else if (data.password_confirmation != data.password) {
                jmMsg("密码不一致");
                return false;
            } else if (data.city == "") {
                jmMsg("请选择所在城市");
                return false;
            } else if (data.is_our_users === "") {
                jmMsg("请选择是否贝乐学员");
                return false;
            } else {
                jmAjax({
                    url: "{{ route('register') }}",
                    type: "POST",
                    data: data,
                    success: function (data) {
                        window.location.href = '{{ $redirect_path }}';
                    }
                });
            }
        });


        $('#city').on('click', function () {
            weui.picker([{
                    label: '北京',
                    value: 0
                }, {
                    label: '上海',
                    value: 1
                }, {
                    label: '深圳',
                    value: 2
                }, {
                    label: '长沙',
                    value: 3
                }, {
                    label: '其他',
                    value: 4
                }], {
                defaultValue: [0],
                className: 'custom-classname',
                onConfirm: function (result) {
                    $('#city').val(result[0].label);
                },
                id: 'picker'
            });
        });

        $('.jm-radio-group').on('click', function () {
            if ($(this).hasClass('jm-radio-active')) {
                return false;
            } else {
                $('.jm-radio-group.jm-radio-active').removeClass('jm-radio-active');
                $(this).addClass('jm-radio-active');
            }
        });


    });
</script>
@endsection