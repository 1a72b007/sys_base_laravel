@extends('dashboard.base')

{{-- 此頁面專用css --}}
@section('css')
    <style>


    </style>
@endsection

@section('content')


    <div class="container-fluid">
        <div class="fade-in">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        @if (getActionPermission('create'))
                            <a class="btn btn-lg btn-info" href="{{ route('menu.menu.create') }}">{{ __('Add') }}</a>
                        @endif
                    </div>
                    <table class="table table-responsive-sm table-striped datatable">
                        <thead>
                            <tr>
                                <th>名稱</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menulist as $menu1)
                                <tr>
                                    <td>
                                        {{ $menu1->name }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a class="btn btn-primary mr-2"
                                                href="{{ route('menu.index', ['menu' => $menu1->id]) }}">{{ __('Show') }}</a>

                                            @if (getActionPermission('update'))
                                                <a class="btn btn-primary mr-2"
                                                    href="{{ route('menu.menu.edit', ['id' => $menu1->id]) }}">{{ __('Edit') }}</a>
                                            @endif

                                            @if (getActionPermission('delete'))
                                                <a class="btn btn-outline-danger"
                                                    href="{{ route('menu.menu.delete', ['id' => $menu1->id]) }}">{{ __('Delete') }}</a>
                                            @endif
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

@endsection

@section('javascript')

@endsection
