{{-- 樣板 --}}
@extends('dashboard.base')

{{-- 此頁面專用css --}}
@section('css')
    <style>
        /* acubedt_MultiLevel-Collapse.css */

    </style>
@endsection

{{-- 內容 --}}
@section('content')

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> {{ $error }}</strong>
            <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">×</span></button>
        </div>
    @endforeach
@endif
@if (session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong> {{ session('message') }}</strong>
        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
    </div>
@endif
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-lg-8 col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>
                                    基本資料
                                </h4>
                            </div>
                            <div class="card-body">
                                <form id="form_profile" action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="u_account">帳號</label>
                                                <input class="form-control" id="u_account" type="text" name="account" 
                                                    value="{{$user->account}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="u_name">名稱</label>
                                                <span class="text-danger ml-1">*</span>
                                                <input class="form-control" id="u_name" type="text" name="name" 
                                                    placeholder="請輸入名稱" value="{{$user->name}}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="u_role_id">群組</label>
                                                <select class="form-control" id="u_role_id" disabled>
                                                    @foreach ($user->roles as $role)
                                                        <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="col-form-label" for="u_email">信箱</label>
                                                <input class="form-control" id="u_email" type="text" name="email"
                                                    value="{{$user->email}}" placeholder="請輸入信箱">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label" for="u_remark">備註說明</label>
                                        <textarea class="form-control" id="remark" name="remark" form="form_profile"
                                            placeholder="請輸入備註">{{$user->remark}}</textarea>
                                    </div>
                                    
                                    <button class="btn btn-primary pull-right">儲存</button>
                                </form>
                            </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>修改密碼</h4>
                        </div>

                        <div class="card-body">
                            <form id="changePasswordForm">
                                <div class="form-group">
                                    <label for="oldPassword">舊密碼*</label>
                                    <input type="password" class="form-control" id="oldPassword" placeholder="請輸入舊密碼"
                                        required>
                                    <small id="oldPasswordHelpInline" class="text-danger">
                                        舊的密碼不正確
                                    </small>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="newPassword">新密碼*</label>
                                        <input type="password" class="form-control" id="newPassword" placeholder="請輸入新密碼"
                                            required>
                                        <small id="newPasswordHelpInline" class="text-danger">
                                            請輸入密碼最小六個字
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="reNewPassword">確認新密碼*</label>
                                        <input type="password" class="form-control" id="reNewPassword"
                                            placeholder="請再次輸入新密碼" required>
                                        <small id="reNewPasswordHelpInline" class="text-danger">
                                            與輸入的密碼不符
                                        </small>
                                    </div>
                                </div>
                            </form>
                            <button onclick="submit()" class="btn btn-primary pull-right">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

{{-- 此頁面專用js --}}
@section('javascript')
    <script>
        $(function() {
            $('small').hide();

            $('#u_role_id').select2({
                templateSelection: iformat,
                templateResult: iformat,
                allowHtml: true,
                multiple: true, //是否多選
                width: '100%', //滿版
                language: "zh-tw", //語系
            });
        })

        var form = document.getElementById('changePasswordForm');

        function submit() {
            if (form.reportValidity()) {
                let newPassword = $('#newPassword').val();
                let reNewPassword = $('#reNewPassword').val();
                if (newPassword.length > 5) {
                    $("#newPasswordHelpInline").hide();
                    if (newPassword == reNewPassword) {
                        $("#reNewPasswordHelpInline").hide();
                        sendChangePassword();
                    } else {
                        $("#reNewPasswordHelpInline").show();
                    }
                } else {
                    $("#newPasswordHelpInline").show();
                }
            }
        }

        function sendChangePassword(oldPassword, newPassword) {

            $.ajax({
                type: 'PATCH',
                url: '{{ route("user.change_password") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    old_password: $('#oldPassword').val(),
                    new_password: $('#newPassword').val(),
                },
                success: function(data) {
                    $("#oldPasswordHelpInline").hide();
                    $('#oldPassword').val("")
                    $('#newPassword').val("")
                    $('#reNewPassword').val("")
                    alert("修改密碼成功");
                },
                error: function(xhr, status, error) {
                    $("#oldPasswordHelpInline").show();
                },
            });
        }
    </script>
@endsection
