{{-- 樣板 --}}
@extends('dashboard.base')

{{-- 此頁面專用css --}}
@section('css')
    <style>

    </style>
@endsection

{{-- 內容 --}}
@section('content')
    <div class="container-fluid">
        <div class="fade-in">
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
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            @if (getActionPermission('create'))
                                <button data-toggle="modal" data-target="#addModal"
                                    class="btn btn-info">{{ __('+新增人員') }}</button>
                            @endif
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="input-group">
                                <input class="form-control" id="searchInput" type="text" name="search_keyword"
                                    placeholder="輸入關鍵字" autocomplete="">
                            </div>
                        </div>
                    </div>

                    <form>

                        <div class="table-responsive">
                            <table class="table table-hover datatable" id="users_list" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>人員名稱</th>
                                        <th>帳號</th>
                                        <th>信箱</th>
                                        <th>群組</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-center-center justify-content-center">
                                                    @if (getActionPermission('update'))
                                                        <a href class="btn btn-info mr-2" data-toggle="modal"
                                                            data-target="#editModal"
                                                            onClick="get_user('{{ $user['id'] }}')"><i
                                                                class="c-icon cil-pencil"></i></a>
                                                    @endif

                                                    @if (getActionPermission('delete'))
                                                        <a href class="btn btn-outline-danger mr-2" data-toggle="modal"
                                                            data-target="#deleteModal"
                                                            onClick="set_delete_id('{{ $user['id'] }}')"><i
                                                                class="c-icon cil-trash"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $user['name'] ?? ""}}</td>
                                            <td>{{ $user['account'] ?? ""}}</td>
                                            <td>{{ $user['email'] ?? ""}}</td>
                                            <td>{!! !empty($user['roles']) ? implode(',', Arr::pluck($user['roles'], 'name')) : '' !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form class="p-3" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">新增人員</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="ac_modal_block">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="account">帳號</label>
                                        <span class="text-danger ml-1">*</span>
                                        <input class="form-control" id="account" type="text" name="account"
                                            placeholder="請輸入帳號" value="{{ old('account') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="name">人員名稱</label><span
                                            class="text-danger ml-1">*</span>
                                        <input class="form-control" id="name" type="text" name="name" placeholder="請輸入名稱" value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="password">密碼</label><span
                                            class="text-danger ml-1">*</span>
                                        <input class="form-control" id="password" type="password" name="password"
                                            placeholder="請輸入密碼">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="password_confirmation">確認密碼</label><span
                                            class="text-danger ml-1">*</span>
                                        <input class="form-control" id="password_confirmation" type="password"
                                            name="password_confirmation" placeholder="請輸入確認密碼">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="role_id">群組</label><span
                                            class="text-danger ml-1">*</span>
                                        <select class="form-control" name="role_id[]" id="role_id">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="email">信箱</label>
                                        <input class="form-control" id="email" type="text" name="email" placeholder="請輸入信箱" value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="remark">備註說明</label>
                                <textarea class="form-control" id="remark" name="remark" placeholder="請輸入備註">{{ old('remark') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary btn-lg" type="button" data-dismiss="modal">取消</button>
                        <button class="btn btn-info btn-lg">新增</button>
                    </div>

                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </form>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form class="p-3" action="{{ route('users.update', ':id' )}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <input id="original_role" type="hidden" name="original_role" />
                    <input type="hidden" id="u_id" name="id" value="" />
                    <div class="modal-header">
                        <h4 class="modal-title">編輯人員</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="ac_modal_block">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="u_account">帳號</label>
                                        <input class="form-control" id="u_account" type="text" name="account" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="u_name">人員名稱</label>
                                        <span class="text-danger ml-1">*</span>
                                        <input class="form-control" id="u_name" type="text" name="name" placeholder="請輸入名稱">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="u_role_id">群組</label>
                                        <span class="text-danger ml-1">*</span>
                                        <select class="form-control" name="role_id[]" id="u_role_id">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="u_email">信箱</label>
                                        <input class="form-control" id="u_email" type="text" name="email"
                                            placeholder="請輸入信箱">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-form-label" for="u_remark">備註說明</label>
                                <textarea class="form-control" id="u_remark" name="remark" placeholder="請輸入備註"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-between align-items-center">
                        <div>
                            <button data-toggle="modal" data-target="#confirmDataModal" class="btn btn-outline-info btn-lg"
                                type="button">重置密碼</button>
                        </div>
                        <div>
                            <button class="btn btn-secondary btn-lg" type="button" data-dismiss="modal">取消</button>
                            <button class="btn btn-info btn-lg">儲存</button>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </form>

    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form class="p-3" id="delete_form" action="{{ route('users.destroy', ':id' )}}" method="post">
            @csrf
            @method('delete')
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">刪除人員</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <input type="hidden" id="d_id" name="id" value="" />
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="p-xl-5 p-lg-4 p-3">
                                <span class="help-block">確定要刪除人員嗎？</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary btn-lg" type="button" data-dismiss="modal">取消</button>
                        <button class="btn btn-danger btn-lg">刪除</button>
                    </div>
                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </form>

    </div>


    <div class="modal fade" id="confirmDataModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-info" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">確認重置密碼</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="ac_modal_block">
                        <p>請輸入“重置密碼”四個字，來確定要進行密碼重置的動作</p>
                        <div>
                            <input class="form-control" id="edit_confirm_text" type="text" name="text-input_export"
                                placeholder="重置密碼">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center">
                    <button class="btn btn-outline-secondary btn-lg" type="button" data-dismiss="modal">取消</button>
                    <button class="btn btn-info btn-lg" type="button"
                        onclick="reset_password(document.getElementById('edit_confirm_text').value)">確認</button>
                </div>
            </div>
            <!-- /.modal-content-->
        </div>
        <!-- /.modal-dialog-->
    </div>

@endsection

{{-- 此頁面專用js --}}
@section('javascript')

    <script src="{{ asset('js/axios.min.js') }}"></script>

    <script>
        datatable = $("#users_list").DataTable({
            dom: "tip",
            // scrollY: "40vh",
            scrollCollapse: true,
            scrollX: true,
            // stateSave: true,
            language: {
                "sProcessing": "處理中...",
                "sLengthMenu": "顯示 _MENU_ 項結果",
                "sZeroRecords": "沒有匹配結果",
                "sInfo": "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
                "sInfoEmpty": "顯示第 0 至 0 項結果，共 0 項",
                "sInfoFiltered": "(由 _MAX_ 項結果過濾)",
                "sInfoPostFix": "",
                "sSearch": "搜尋:",
                "sUrl": "",
                "sEmptyTable": "表中數據為空",
                "sLoadingRecords": "載入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "首頁",
                    "sPrevious": "上頁",
                    "sNext": "下頁",
                    "sLast": "末頁"
                },
                "oAria": {
                    "sSortAscending": ": 以升序排列此列",
                    "sSortDescending": ": 以降序排列此列"
                }
            }
            // responsive: true,
        })
    </script>

    <script>

        $('#role_id').select2({
            templateSelection: iformat,
            templateResult: iformat,
            allowHtml: true,
            allowClear: true, //當有選取選項時，右側會有一個X按鈕，可快速清除資料
            multiple: true, //是否多選
            width: '100%', //滿版
            minimumResultsForSearch: -1, //註解掉的話會有搜尋框，可供人員輸入關鍵字後快速找到選項
            dropdownAutoWidth: true,
            language: "zh-tw", //語系
            placeholder: '請選擇群組(可複選)',
        });

        $('#u_role_id').select2({
            templateSelection: iformat,
            templateResult: iformat,
            allowHtml: true,
            allowClear: true, //當有選取選項時，右側會有一個X按鈕，可快速清除資料
            multiple: true, //是否多選
            width: '100%', //滿版
            dropdownAutoWidth: true,
            language: "zh-tw", //語系
            placeholder: '請選擇群組(可複選)',
        });

        //編輯使用者資訊
        function get_user(id) {
            $("#u_id").val('');
            $("#u_name").val('');
            $("#u_account").val('');
            $("#u_email").val('');
            $("#u_remark").val('');
            $("#original_role").val('');
            $("#u_role_id").val('');
            $('#u_role_id').select2({
                templateSelection: iformat,
                templateResult: iformat,
                allowHtml: true,
                allowClear: true, //當有選取選項時，右側會有一個X按鈕，可快速清除資料
                multiple: true, //是否多選
                width: '100%', //滿版
            });

            let url = '{{ route("users.show", ":id" )}}';
            url = url.replace(':id', id);
            
            $.ajax({
                url: url,
                dataType: 'json',
                type: "get",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "GET",
                    id: id
                },
                success: function(result) {
                    $("#u_id").val(result.id);
                    $("#u_name").val(result.name);
                    $("#u_account").val(result.account);
                    $("#u_email").val(result.email);

                    $("#original_role").val(result.roles);
                    $("#u_role_id").val(result.roles);
                    $("#u_remark").val(result.remark);

                    $('#u_role_id').select2({
                        templateSelection: iformat,
                        templateResult: iformat,
                        allowHtml: true,
                        allowClear: true, //當有選取選項時，右側會有一個X按鈕，可快速清除資料
                        multiple: true, //是否多選
                        width: '100%', //滿版
                        dropdownAutoWidth: true,
                        language: "zh-tw", //語系
                        placeholder: '請選擇群組(可複選)',
                    });
                }
            });
        }

        function set_delete_id(id) {
            $("#d_id").val("");
            $("#d_id").val(id);
        }

        function reset_password($confirm_text) {
            if ($confirm_text == "重置密碼") {
                getNewPassword()
            } else {
                alert("請輸入“重置密碼”四個字，來確定要進行密碼重置的動作");
            }
        }

        function getNewPassword() {
            var id = $("#u_id").val();

            $.ajax({
                type: 'POST',
                url: 'admin/users/' + id + '/reset_password',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    alert("你的新密碼是：" + data);
                    $("#confirmDataModal").modal("toggle");
                    $("#editModal").modal("toggle");
                }
            });
        }
    </script>

@endsection
