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
                    @if (getActionPermission('create'))
                        <div class="mb-3">
                            <a class="btn btn-lg btn-info" href="{{ route('menu.create') }}">{{ __('Add') }}</a>
                        </div>
                    @endif
                    <?php function renderDropdownForMenuEdit($data, $role)
                    {
                    if (array_key_exists('slug', $data) && $data['slug'] === 'dropdown') {
                    echo '<tr>';
                        echo '<td>';
                            if ($data['hasIcon'] === true && $data['iconType'] === 'coreui') {
                            // echo '<svg class="c-icon">
                                // <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#' .
                                    //             $data['icon'] .
                                    //             '">
                                    // </use>
                                // </svg>';
                            echo '<i class="' . $data['icon'] . '"></i>';
                            }
                            echo '</td>';
                        echo '<td>' . $data['slug'] . '</td>';
                        echo '<td>' . $data['name'] . '</td>';
                        echo '<td></td>';
                        echo '<td>' . $data['sequence'] . '</td>';
                        echo '<td>';
                            echo '
                            <div class="d-flex-inline align-items-center">';
                        ?>

                    @if (getActionPermission('update'))
                        <a class="btn btn-success m-1" href="{{ route('menu.up', ['id' => $data['id']]) }}">
                            <i class="cil-arrow-thick-top"></i></a>
                        <a class="btn btn-success m-1" href="{{ route('menu.down', ['id' => $data['id']]) }}">
                            <i class="cil-arrow-thick-bottom"></i></a>
                    @endif

                    @if (getActionPermission('update'))
                        <a class="btn btn-primary m-1"
                            href="{{ route('menu.edit', ['id' => $data['id']]) }}">{{ __('Edit') }}</a>
                    @endif

                    @if (getActionPermission('delete'))
                        <a class="btn btn-danger"
                            href="{{ route('menu.delete', ['id' => $data['id']]) }}">{{ __('Delete') }}</a>
                    @endif
                </div>
                <?php
                            echo '
                        </td>';
                        // echo '<td>';
                            // echo '';
                            // echo '</td>';
                        // echo '<td>';
                            // echo '';
                            // echo '</td>';
                        // echo '<td>';
                            // echo '';
                            // echo '</td>';
                        // echo '<td>';
                            // echo '';
                            // echo '</td>';
                        echo '</tr>';
                    renderDropdownForMenuEdit($data['elements'], $role);
                    } else {
                    for ($i = 0; $i < count($data); $i++) { if ($data[$i]['slug']==='link' ) { echo '<tr>' ; echo '<td>' ;
                        echo '<i class="cil-arrow-thick-to-right"></i>' ; echo '</td>' ; echo '<td>' . $data[$i]['slug']
                        . '</td>' ; echo '<td>' . $data[$i]['name'] . '</td>' ; echo '<td>' . $data[$i]['href'] . '</td>' ;
                        echo '<td>' . $data[$i]['sequence'] . '</td>' ; echo '<td>' ; echo '
                                        <div class="d-flex-inline align-items-center">';
                        ?>

                @if (getActionPermission('update'))
                    <a class="btn btn-success m-1" href="{{ route('menu.up', ['id' => $data[$i]['id']]) }}">
                        <i class="cil-arrow-thick-top"></i></a>
                    <a class="btn btn-success m-1" href="{{ route('menu.down', ['id' => $data[$i]['id']]) }}">
                        <i class="cil-arrow-thick-bottom"></i></a>
                @endif

                @if (getActionPermission('update'))
                    <a class="btn btn-primary m-1"
                        href="{{ route('menu.edit', ['id' => $data[$i]['id']]) }}">{{ __('Edit') }}</a>
                @endif

                @if (getActionPermission('delete'))
                    <a class="btn btn-danger"
                        href="{{ route('menu.delete', ['id' => $data[$i]['id']]) }}">{{ __('Delete') }}</a>
                @endif
            </div>
            <?php
                echo '</td>';
                // echo '<td>';
                    // echo '';
                    // echo '
                    // </td>';
                // echo '<td>';
                    // echo '';
                    // echo '</td>';
                // echo '<td>';
                    // echo '';
                    // echo '</td>';
                // echo '<td>';
                    // echo '';
                    // echo '</td>';
                echo '</tr>';
                } elseif ($data[$i]['slug'] === 'dropdown') {
                renderDropdownForMenuEdit($data[$i], $role);
                }
                }
                }
                } ?>

<div class="table-responsive">
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th></th>
                        <th>方式</th>
                        <th>名稱</th>
                        <th>連結</th>
                        <th>排序</th>
                        <th></th>
                        {{-- <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th> --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach ($menuToEdit as $menuel)
                        @if ($menuel['slug'] === 'link')
                            <tr>
                                <td>
                                    @if ($menuel['hasIcon'] === true)
                                        @if ($menuel['iconType'] === 'coreui')
                                            {{-- <svg class="c-icon">
                                                            <use
                                                                xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $menuel['icon'] }}">
                                                            </use>
                                                        </svg> --}}
                                            <i class="{{ $menuel['icon'] }}"></i>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {{ $menuel['slug'] }}
                                </td>
                                <td>
                                    {{ $menuel['name'] }}
                                </td>
                                <td>
                                    {{ $menuel['href'] }}
                                </td>
                                <td>
                                    {{ $menuel['sequence'] }}
                                </td>
                                <td>
                                    <div class="d-flex-inline align-items-center">
                                        @if (getActionPermission('update'))
                                            <a class="btn btn-success m-1" href="{{ route('menu.up', ['id' => $menuel['id']]) }}">
                                                <i class="cil-arrow-thick-top"></i></a>
                                            <a class="btn btn-success m-1" href="{{ route('menu.down', ['id' => $menuel['id']]) }}">
                                                <i class="cil-arrow-thick-bottom"></i></a>
                                        @endif
                                        
                                        @if (getActionPermission('update'))
                                            <a class="btn btn-primary m-1"
                                                href="{{ route('menu.edit', ['id' => $menuel['id']]) }}">{{ __('Edit') }}</a>
                                        @endif
                                        @if (getActionPermission('delete'))
                                            <a class="btn btn-danger m-1"
                                                href="{{ route('menu.delete', ['id' => $menuel['id']]) }}">{{ __('Delete') }}</a>
                                        @endif
                                    </div>
                                </td>
                                {{-- <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>

                                            </td> --}}
                            </tr>
                        @elseif($menuel['slug'] === 'dropdown')
                            <?php renderDropdownForMenuEdit($menuel, $role); ?>
                        @elseif($menuel['slug'] === 'title')
                            <tr>
                                <td>
                                    @if ($menuel['hasIcon'] === true)
                                        @if ($menuel['iconType'] === 'coreui')
                                            <svg class="c-icon">
                                                <use
                                                    xlink:href="/assets/icons/coreui/free-symbol-defs.svg#{{ $menuel['icon'] }}">
                                                </use>
                                            </svg>
                                            <i class="{{ $menuel['icon'] }}"></i>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    {{ $menuel['slug'] }}
                                </td>
                                <td>
                                    {{ $menuel['name'] }}
                                </td>
                                <td>

                                </td>
                                <td>
                                    {{ $menuel['sequence'] }}
                                </td>
                                <td>
                                    <div class="d-flex-inline align-items-center">
                                        @if (getActionPermission('update'))
                                            <a class="btn btn-success m-1"
                                                href="{{ route('menu.up', ['id' => $menuel['id']]) }}">
                                                <i class="cil-arrow-thick-top"></i>
                                            </a>
                                            <a class="btn btn-success m-1"
                                                href="{{ route('menu.down', ['id' => $menuel['id']]) }}">
                                                <i class="cil-arrow-thick-bottom"></i>
                                            </a>
                                        @endif

                                        @if (getActionPermission('update'))
                                            <a class="btn btn-primary m-1"
                                                href="{{ route('menu.edit', ['id' => $menuel['id']]) }}">{{ __('Edit') }}</a>
                                        @endif
                                        
                                        @if (getActionPermission('delete'))
                                            <a class="btn btn-danger"
                                                href="{{ route('menu.delete', ['id' => $menuel['id']]) }}">{{ __('Delete') }}</a>
                                        @endif
                                    </div>
                                </td>
                                {{-- <td>

                                            </td>
                                            <td>

                                            </td>
                                            <td>

                                            </td>
                                            </td>
                                            <td> --}}

                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>
    </div>


@endsection

@section('javascript')

@endsection
