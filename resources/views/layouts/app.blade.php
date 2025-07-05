<!DOCTYPE html>
@php
    $settings=settings();
@endphp
<html lang="en" style="{{($settings['color_type']=='custom')?$settings['own_color']:''}}">
@include('admin.head')
<body class="customizer-modal {{$settings['layout_direction']}} {{$settings['layout_mode']}}">
<!-- Loader Start-->
<div class="codex-loader">
    <div class="linespinner"></div>
</div>
<!-- Loader End-->
@include('admin.header')
@include('admin.menu')
<div class="themebody-wrap">
    <!-- breadcrumb start-->
    <div class="codex-breadcrumb">
        <div class="breadcrumb-contain">
            <div class="left-breadcrumb">
                @yield('breadcrumb')

            </div>
            <div class="right-breadcrumb">
                <ul>
                   @yield('card-action-btn')
                </ul>
            </div>
        </div>
    </div>
    <!-- breadcrumb end-->
    <!-- theme body start-->
    <div class="theme-body @yield('page-class') " data-simplebar>
        <div class="custom-container common-dash">
            @include('admin.content')
        </div>
    </div>
    <!-- theme body start-->
</div>
<div class="modal fade" id="customModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5><a href="javascript:void(0);" data-bs-dismiss="modal"><i class="ti-close"></i></a>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>

@include('admin.footer')
</body>
</html>
