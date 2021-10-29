@extends('dashboard.base')

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
                                    class="btn btn-info">{{ __('+新增權限群組') }}</button>
                            @endif
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <form class="form-horizontal mr-2" action="" method="post">
                                <div class="input-group">
                                    <input class="form-control" id="searchInput" type="text" name="search_keyword"
                                        placeholder="輸入關鍵字" autocomplete="">

                                    {{-- <span class="input-group-prepend">
                                        <button class="btn btn-sm btn-secondary" type="button">
                                            <i class="c-icon cil-magnifying-glass"></i>
                                        </button>
                                    </span> --}}
                                </div>
                            </form>

                            {{-- ac_todo table篩選器
                                         (1)點擊按鈕會跳出條件篩選器dropdowns
                                         (2)關鍵字搜尋按 enter 或點擊 icon 按鈕時會執行篩選資料的動作
                                         (3)filter和關鍵字搜尋條件可疊加 --}}
                        </div>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">

                            {{-- ac_todo 多選
                                            (1)點擊按鈕進入多選模式
                                            (2)多選模式可操作動作：全選項目、刪除項目、取消多選模式、項目搜尋與篩選、資料正逆排序
                                            (3)除了上述提到的，其他按鈕都是disable狀態 --}}

                            <table class="table table-hover datatable display" id="role_list" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>群組名稱</th>
                                        <th>建立時間</th>
                                        {{-- <th>更新時間</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-center-center justify-content-center">
                                                    @if (getActionPermission('update'))
                                                        <a href class="btn btn-info mr-2" data-toggle="modal"
                                                            data-target="#editModal"
                                                            onClick="get_role('{{ $role->id }}')"><i
                                                                class="c-icon cil-pencil"></i></a>
                                                    @endif

                                                    @if (getActionPermission('delete'))
                                                        <a href class="btn btn-outline-danger mr-2" data-toggle="modal"
                                                            data-target="#deleteModal"
                                                            onClick="set_delete_id('{{ $role->id }}')"><i
                                                                class="c-icon cil-trash"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->created_at }}</td>
                                            {{-- <td>{{ $role->updated_at }}</td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form class="p-3" action="{{ route('roles.store') }}" method="post">
            @csrf
            @method('post')
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">新增權限群組</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="form-group">
                                <label class="col-form-label" for="name">群組名稱</label><span class="text-danger ml-1">*</span>
                                <input class="form-control" id="name" type="text" name="name" placeholder="請輸入群組名稱">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="copy_role">權限複製對象群組</label><span class="text-danger ml-1">*</span>
                                
                                <select class="form-control" id="copy_role" name="copy_role">
                                    <option value="">無（建立全新的權限）</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" >{{ $role->name }}</option>
                                    @endforeach
                                </select>

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
        <form class="p-3" id="update_form" action="" method="post">
            @csrf
            @method('put')
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <input type="hidden" name="role_permissions_ids" />
                    <input type="hidden" id="u_id" name="id" value="" />
                    <div class="modal-header">
                        <h4 class="modal-title">編輯權限群組</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label" for="u_name">群組名稱</label><span class="text-danger ml-1">*</span>
                            <input class="form-control" id="u_name" type="text" name="name" placeholder="請輸入群組名稱">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="u_name">頁面權限</label>

                            <table class="table table-hover table-bordered datatable">
                                <tbody id="permission_tbody">


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button class="btn btn-secondary btn-lg" type="button" data-dismiss="modal">取消</button>
                        <button class="btn btn-info btn-lg">儲存</button>
                    </div>
                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </form>

    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form class="p-3" id="delete_form" action="" method="post">
            @csrf
            @method('delete')
            <input type="hidden" id="d_id" name="id" value="" />
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">刪除權限群組</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-md-9">
                                <span class="help-block">確定要刪除權限群組嗎？</span>
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



@endsection

@section('javascript')

    <script>
        datatable = $("#role_list").DataTable({
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
        });
    </script>

    <script>

        function checked_all(parent_id){
            let parent_checked = $("[ac_target='menu_id_"+parent_id+"']").prop("checked");
            $(".checked_"+parent_id+"").prop("checked", parent_checked);
        }

        function get_role(id) {

            $("#u_id").val('');
            $("#u_name").val('');
            $("input[name='change_id']").val('');
            $("input[name='role_permissions_ids']").val('');
            $("#permission_tbody").html('');
            $("#update_form").attr("action", "");

            let url = '{{ route("roles.edit", ":id" )}}';
            url = url.replace(':id', id);
            
            $.ajax({
                url: url,
                dataType: 'json',
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "GET",
                    id: id
                },
                success: function(result) {
                    let update_url = '{{ route("roles.update", ":id" )}}';
                    update_url = update_url.replace(':id', id);
                    $("#update_form").attr("action", update_url);

                    $("#u_id").val(result.role.id);
                    $("#u_name").val(result.role.name);
                    $("input[name='role_permissions_ids']").val(result.role_permissions_ids);
                    var permisiion_str = "";

                    $.each(result.dropdowns, function(dkey, dropdown) {

                        //下拉的名稱顯示 
                        //顏色樣式可以再調整
                        permisiion_str += "<tr style='background:#C4E1FF'><td colspan='"+(result.permission_num+2)+"' >"+dropdown.name+"</td></tr>";

                        $.each(result.permission, function(pkey, menuel) {

                            //判斷parent_id
                            if(menuel.parent_id == dropdown.id){
                                //頁面名稱顯示
                                permisiion_str += "<tr>" +
                                    "<td>" + menuel.menu_name + "</td>";
                                permisiion_str +=
                                        '<td><div class="ac_checkbox_global checkbox_style01">' +
                                        '<label class="option_element"> 全選' +
                                        '<input type="checkbox" ac_target="menu_id_' + pkey+ '" onchange=checked_all(' + pkey+ ') >' +
                                        '<span class="forms_indicator"></span>' +
                                        ' </label>' +
                                        '</div></td>';
                                //生成動作checkbox
                                for(var i=0 ; i < result.permission_num; i++){

                                    if(menuel.data[i] != undefined){
                                        permisiion_str +=
                                        '<td><div class="ac_checkbox_global checkbox_style01">' +
                                        '<label class="option_element">' + menuel.data[i].permissions_name +
                                        '<input type="checkbox" class="checked_'+menuel.data[i].menu_id+'" id="permission_' + menuel.data[i].id +
                                        '" name="permission_id[]" value="' + menuel.data[i].id +
                                        '" ' + (menuel.data[i].is_use == 1 ? "checked" : "") + '>' +
                                        '<span class="forms_indicator"></span>' +
                                        ' </label>' +
                                        '</div></td>';
                                    }else{
                                        permisiion_str += "<td></td>";
                                    }
                                }

                                permisiion_str += "</tr>";
                            }
                            
                        });

                    });

                    $("#permission_tbody").html(permisiion_str);

                }
            });
        }

        function set_delete_id(id) {
            $("#d_id").val("");
            $("#d_id").val(id);
            // var action = 'admin/roles/' + id + '';
            var action = '{{route("roles.index")}}' + '/' + id;
            $("#delete_form").attr("action", "");
            $("#delete_form").attr("action", action);
        }
    </script>

@endsection
