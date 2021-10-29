@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-header">
                    <h4>新增選單</h4>
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
                    <form action="{{ route('menu.store') }}" method="POST">
                        @csrf
                        <table class="table table-striped table-responsive-xl table-bordered datatable">
                            <tbody>
                                <tr>
                                    <th>
                                        名稱
                                    </th>
                                    <td>
                                        <input class="form-control" type="text" name="name" placeholder="名稱" required />
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        方式
                                    </th>
                                    <td>
                                        <select class="form-control" name="type" id="type">
                                            <option value="link">Link</option>
                                            <option value="title">Title</option>
                                            <option value="dropdown">Dropdown</option>
                                            <option value="">Hidden</option>
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
                                            <input type="text" name="href" class="form-control" placeholder="連結" />
                                        </div>
                                        <br><br>
                                        <div id="div-dropdown-parent">
                                            所屬下拉選單:
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
                                                placeholder="請輸入樣式class - 範例: cil-bell">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                        <a class="btn btn-light" href="{{ route('menu.index') }}">{{ __('Return') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/menu-create.js') }}"></script>
@endsection
