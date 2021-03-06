<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar"
            data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a
            class="c-header-brand d-lg-none" href="#"><img class="c-header-brand"
                src="{{ url('/assets/brand/coreui-base.svg') }}" width="97" height="46" alt="CoreUI Logo"></a>
        <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar"
            data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>
        <?php
        //use App\MenuBuilder\FreelyPositionedMenus;
        //if(isset($appMenus['top menu'])){
        //FreelyPositionedMenus::render( $appMenus['top menu'] , 'c-header-', 'd-md-down-none');
        //}
        ?>
        <ul class="c-header-nav ml-auto mr-3">
            <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-avatar user_block">
                        {{-- <span class="user_account d-none d-sm-block">{{ Auth::user()->account }}</span> --}}
                        <span class="user_name">{{ Auth::user()->name }}</span>
                        {{-- <span class="user_store d-none d-sm-block">{{ Auth::user()->store['name'] }}</span> --}}
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0">
                    <a class="dropdown-item" href="{{ route('user.profile') }}" >
                        {{-- <i class="cil-address-book"></i> --}}
                        <button type="button" href="/tada" class="btn"><span class="user_account d-none d-sm-block">{{ Auth::user()->account }}</span></button>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);" onclick="document.getElementById('logout_form').submit();">
                        {{-- <svg class="c-icon mr-2">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-account-logout') }}"></use>
                        </svg> --}}
                        <form id="logout_form" action="{{ route('logout') }}" method="POST"> @csrf <button type="submit" class="btn btn-ghost-dark btn-block">Logout</button></form>
                    </a>
                </div>
            </li>
        </ul>

    </header>
    <div class="c-subheader px-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <?php
                        use Illuminate\Support\Facades\Request;
                        $requestPath = Request::segments();
                        $pageTitle = getTitlePage($requestPath);
                        $parent_name = getParentMenuTitlePage($requestPath);
                        echo $pageTitle;
                        ?>
                    </h5>
                </div>
                <ol class="breadcrumb border-0 m-0">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">??????</a></li>
                    <?php
                        if ($parent_name!= "none"){
                            echo '<li class="breadcrumb-item">'. $parent_name . '</li>';
                        }
                    ?>
                    <?php
                        if (($pageTitle!= "??????") && ($pageTitle!="Dashboard")){
                            echo '<li class="breadcrumb-item">'. $pageTitle . '</li>';
                        }
                    ?>
                </ol>
            </div>
        </div>
    </div>

    {{-- ac_todo ???????????? --}}
    <div class="c-scroll-block" style="display: none">
        <div class="container-fluid">
            <div>
                <div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <a href="#" class="btn btn-info">{{ __('????????????(??????)') }}</a>
                            <button data-toggle="modal" data-target="#add_NewModal"
                                class="btn btn-info">{{ __('????????????(??????)') }}</button>
                            <button="#" class="btn btn-info" type="button" disabled>????????????(??????)</button>
                            <button class="btn btn-danger" type="button">??????</button>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <form class="form-horizontal mr-2" action="" method="post">
                                <div class="input-group">
                                    <input class="form-control form-control-lg" id="input1-group3" type="text" name="input1-group3"
                                        placeholder="??????????????????" autocomplete="">
                                    <span class="input-group-prepend">
                                        <button class="btn btn-secondary btn-search" type="button">
                                            <svg class="c-icon">
                                                <use
                                                    xlink:href="{{ asset('assets/icons/coreui/free-symbol-defs.svg#cui-magnifying-glass') }}">
                                                </use>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <div class="dropdown">
                                <button class="btn btn-outline-info dropdown-toggle" id="dropdownMenu5" type="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">????????????</button>
                                <div class="dropdown-menu">
                                    <div class="px-4 py-3">
                                        <form>
                                            <div class="form-group">
                                                <label for="filter_01">??????????????????</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="filter_01" name="">
                                                        <option>?????????</option>
                                                        <option>1???</option>
                                                        <option>2???</option>
                                                        <option>3???</option>
                                                        <option>4???</option>
                                                        <option>...</option>
                                                    </select>

                                                    {{-- ac_todo ??????select ????????????????????????????????????????????? --}}
                                                    <span class="input-group-append">
                                                        <button class="btn btn-light btn-outline-dark"
                                                            data-btn="btn-clear" type="button">
                                                            <i class="c-icon cil-x"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="filter_02">????????????</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="filter_02" name="">
                                                        <option>?????????</option>
                                                        <option>??????01</option>
                                                        <option>??????02</option>
                                                        <option>??????03</option>
                                                        <option>??????04</option>
                                                        <option>...</option>
                                                    </select>

                                                    {{-- ac_todo ??????select ????????????????????????????????????????????? --}}
                                                    <span class="input-group-append">
                                                        <button class="btn btn-light btn-outline-dark"
                                                            data-btn="btn-clear" type="button">
                                                            <i class="c-icon cil-x"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="filter_03">????????????</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="filter_03" name="">
                                                        <option>?????????</option>
                                                        <option>??????01</option>
                                                        <option>??????02</option>
                                                        <option>??????03</option>
                                                        <option>??????04</option>
                                                        <option>...</option>
                                                    </select>

                                                    {{-- ac_todo ??????select ????????????????????????????????????????????? --}}
                                                    <span class="input-group-append">
                                                        <button class="btn btn-light btn-outline-dark"
                                                            data-btn="btn-clear" type="button">
                                                            <i class="c-icon cil-x"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </form>
                                        <p class="mb-0"><span>????????????1???</span><span>/????????????3???</span></p>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <div class="px-4 py-3">
                                        {{-- <button class="btn btn-info" type="submit">??????</button> --}}
                                        <button class="btn btn-outline-dark" type="button">??????????????????</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    ?????????????????????????????????
                </div>
            </div>
        </div>
    </div>
