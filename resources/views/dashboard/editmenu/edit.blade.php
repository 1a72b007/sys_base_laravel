@extends('dashboard.base')

@section('content')


    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">
                    <h4>編輯選單</h4>
                </div>
                <div class="card-body">
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('menu.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $menuElement->id }}" id="menuElementId" />
                        <table class="table table-striped table-responsive-xl table-bordered datatable">
                            <tbody>
                                <tr>
                                    <th>
                                        名稱
                                    </th>
                                    <td>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $menuElement->name }}" placeholder="名稱" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        方式
                                    </th>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            @if ($menuElement->slug === 'link')
                                                <option value="link" selected>Link</option>
                                            @else
                                                <option value="link">Link</option>
                                            @endif
                                            @if ($menuElement->slug === 'title')
                                                <option value="title" selected>Title</option>
                                            @else
                                                <option value="title">Title</option>
                                            @endif
                                            @if ($menuElement->slug === 'dropdown')
                                                <option value="dropdown" selected>Dropdown</option>
                                            @else
                                                <option value="dropdown">Dropdown</option>
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        其他
                                    </th>
                                    <td>
                                        <div id="div-href">
                                            連結:
                                            <input type="text" name="href" class="form-control" placeholder="連結"
                                                value="{{ $menuElement->href }}" />
                                        </div>
                                        <br><br>
                                        <div id="div-dropdown-parent">
                                            所屬下拉選單:
                                            <input type="hidden" id="parentId" value="{{ $menuElement->parent_id }}" />
                                            <select class="form-control" name="parent" id="parent">

                                            </select>
                                        </div>
                                        <br><br>
                                        <div id="div-icon">
                                            Icon樣式:
                                            <a href="https://coreui.io/docs/icons/icons-list/#coreui-icons-free-502-icons"
                                                target="_blank">
                                                icons
                                            </a>
                                            <br>
                                            <input class="form-control" name="icon" type="text"
                                                placeholder="請輸入樣式class - 範例: cil-bell"
                                                value="{{ $menuElement->icon }}">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                        <a class="btn btn-light"
                            href="{{ route('menu.index', ['menu' => $menuElement->menu_id]) }}">{{ __('Return') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/menu-edit.js') }}"></script>



@endsection
