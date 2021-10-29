<!DOCTYPE html>
<!--
* CoreUI Free Laravel Bootstrap Admin Template
* @version v2.0.1
* @link https://coreui.io
* Copyright (c) 2020 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">

<title>
    <?php
        use Illuminate\Support\Facades\Request;
        $requestPath = Request::segments();
        $pageTitle = getTitlePage($requestPath);
        echo env('APP_NAME'). '：' . $pageTitle;
    ?>
</title>

<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/favicon-96x96.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
<meta name="theme-color" content="#ffffff">



{{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> --}}
<!-- Icons-->
<!-- font-awesome v4.7.0 css -->
<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
<link href="{{ asset('css/free.min.css') }}" rel="stylesheet"> <!-- icons -->
<link href="{{ asset('css/flag.min.css') }}" rel="stylesheet"> <!-- icons -->
<!-- Main styles for this application-->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<!-- DataTables -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/DataTables-1.10.20/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/AutoFill-2.3.4/css/autoFill.bootstrap4.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/Buttons-1.6.1/css/buttons.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/ColReorder-1.5.2/css/colReorder.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/FixedColumns-3.3.0/css/fixedColumns.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/FixedHeader-3.1.6/css/fixedHeader.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/KeyTable-2.5.1/css/keyTable.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/Responsive-2.2.3/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/RowGroup-1.1.1/css/rowGroup.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/RowReorder-1.2.6/css/rowReorder.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/Scroller-2.0.1/css/scroller.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/SearchPanes-1.0.1/css/searchPanes.bootstrap4.min.css') }}" />
<link rel="stylesheet" type="text/css"
    href="{{ asset('plugins/datatables/Select-1.3.1/css/select.bootstrap4.min.css') }}" />

{{-- acubedt admin coreUI css --}}
<link href="{{ asset('css/acubedt_cms-1.3.9.css') }}" rel="stylesheet">
<link href="{{ asset('css/acubedt_admin_form.css') }}" rel="stylesheet">
<link href="{{ asset('css/acubedt_can-toggle.css') }}" rel="stylesheet">
<link href="{{ asset('css/acubedt_MultiLevel-Collapse.css') }}" rel="stylesheet">
<link href="{{ asset('css/acubedt_admin_coreUI.css') }}" rel="stylesheet">

@yield('css')


<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<!-- jQuery UI 1.12.1 -->
<link rel="stylesheet" href="{{ asset('plugins/jqueryui/jquery-ui.min.css') }}">
<script src="{{ asset('plugins/jqueryui/jquery-ui.min.js') }}"></script>

<!--select2 v4.0.13-->
{{-- ac_todo 請判斷有載入select2才有 --}}
<link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" />


<!-- Global site tag (gtag.js) - Google Analytics-->
<script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    // Shared ID
    gtag('config', 'UA-118965717-3');
    // Bootstrap ID
    gtag('config', 'UA-118965717-5');
</script>

<link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet">

<script>
    // ac_todo 待確認實際套用的清單頁面，scrollTop高度需由工程師判斷（依照功能高度差異很大）
    $(window).scroll(function() {
        // console.log($(window).scrollTop())
        if ($(window).scrollTop() > 300) {
            $('body').addClass('blockfixed');
        }
        if ($(window).scrollTop() < 301) {
            $('body').removeClass('blockfixed');
        }
    });
</script>
</head>



<body class="c-app">
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">

    @include('dashboard.shared.nav-builder')

    @include('dashboard.shared.header')

    <div class="c-body">

        <main class="c-main">

            @yield('content')

        </main>
        @include('dashboard.shared.footer')
    </div>
</div>

<!-- CoreUI and necessary plugins-->
<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('js/coreui-utils.js') }}"></script>

<!--flatpickr v4.5.2 css-->
 {{-- ac_todo 請判斷有載入flatpickr才有 --}}
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/flatpickr.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/confirmDate/confirmDate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/flatpickr/monthSelect/monthSelect.css') }}">

<!-- DataTables -->
{{-- ac_todo 請判斷有載入DataTable才有 --}}
<script type="text/javascript" src="{{ asset('plugins/datatables/JSZip-2.5.0/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/pdfmake-0.1.36/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/pdfmake-0.1.36/vfs_fonts.js') }}"></script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/DataTables-1.10.20/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/AutoFill-2.3.4/js/dataTables.autoFill.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('plugins/datatables/AutoFill-2.3.4/js/autoFill.bootstrap4.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Buttons-1.6.1/js/dataTables.buttons.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.bootstrap4.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.colVis.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.flash.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.html5.min.js') }}">
</script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Buttons-1.6.1/js/buttons.print.min.js') }}">
</script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/ColReorder-1.5.2/js/dataTables.colReorder.min.js') }}"></script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/FixedColumns-3.3.0/js/dataTables.fixedColumns.min.js') }}"></script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/FixedHeader-3.1.6/js/dataTables.fixedHeader.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/KeyTable-2.5.1/js/dataTables.keyTable.min.js') }}">
</script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/Responsive-2.2.3/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/Responsive-2.2.3/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/RowGroup-1.1.1/js/dataTables.rowGroup.min.js') }}">
</script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/RowReorder-1.2.6/js/dataTables.rowReorder.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Scroller-2.0.1/js/dataTables.scroller.min.js') }}">
</script>
<script type="text/javascript"
    src="{{ asset('plugins/datatables/SearchPanes-1.0.1/js/dataTables.searchPanes.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/Select-1.3.1/js/dataTables.select.min.js') }}">
</script>


<!--select2 v4.0.13-->
{{-- ac_todo 請判斷有載入select2才有 --}}
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script>
    $('.ac_js_select2.disabled').prop('disabled', true);

    // 在select2的選項加入icon
    function iformat(icon, badge, ) {
        var originalOption = icon.element;
        var originalOptionBadge = $(originalOption).data('badge');
        return $('<span><i class="fa ' + $(originalOption).data('icon') + '"></i> ' + icon.text +
            '<span class="badge">');
    }
</script>



<!--flatpickr v4.5.2 js start-->
 {{-- ac_todo 請判斷有載入flatpickr才有 --}}
<script src="{{ asset('plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/confirmDate/confirmDate.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/weekSelect/weekSelect.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/rangePlugin.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/minMaxTimePlugin.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/monthSelect/monthSelect.js') }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/zh-tw.js"></script>
<!--flatpickr v4.5.2 js end-->


<script>
    //datatable搜尋
    $('#searchInput').on( 'keyup', function () {
        datatable.search(this.value).draw();
    } );
</script>
@yield('javascript')





</body>

</html>
