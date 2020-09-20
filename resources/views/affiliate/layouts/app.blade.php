<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->
<head>
    <base href="">
    <meta charset="utf-8"/>
    <title>NewFace | Affiliate</title>
    <meta name="description" content="Updates and statistics">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <!--end::Fonts -->

    <!--begin:: Vendor Plugins -->
    <link href="{{ asset('assets/affiliate/plugins/general/perfect-scrollbar/css/perfect-scrollbar.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/tether/dist/css/tether.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-timepicker/css/bootstrap-timepicker.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-daterangepicker/daterangepicker.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-select/dist/css/bootstrap-select.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/select2/dist/css/select2.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/ion-rangeslider/css/ion.rangeSlider.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/nouislider/distribute/nouislider.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/owl.carousel/dist/assets/owl.carousel.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/owl.carousel/dist/assets/owl.theme.default.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/dropzone/dist/dropzone.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/quill/dist/quill.snow.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/@yaireo/tagify/dist/tagify.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/summernote/dist/summernote.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/bootstrap-markdown/css/bootstrap-markdown.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/animate.css/animate.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/dual-listbox/dist/dual-listbox.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/morris.js/morris.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/socicon/css/socicon.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/plugins/line-awesome/css/line-awesome.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/plugins/flaticon/flaticon.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/plugins/flaticon2/flaticon.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/general/@fortawesome/fontawesome-free/css/all.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"
          type="text/css"/>

    <!--end:: Vendor Plugins -->
    <link href="{{ asset('assets/affiliate/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>

    <!--begin:: Vendor Plugins for custom pages -->
    <link href="{{ asset('assets/affiliate/plugins/custom/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/core/main.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/daygrid/main.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/list/main.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/timegrid/main.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/datatables.net-autofill-bs4/css/autoFill.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('assets/affiliate/plugins/custom/datatables.net-colreorder-bs4/css/colReorder.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('assets/affiliate/plugins/custom/datatables.net-fixedcolumns-bs4/css/fixedColumns.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('assets/affiliate/plugins/custom/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/datatables.net-keytable-bs4/css/keyTable.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('assets/affiliate/plugins/custom/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/datatables.net-rowgroup-bs4/css/rowGroup.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link
        href="{{ asset('assets/affiliate/plugins/custom/datatables.net-rowreorder-bs4/css/rowReorder.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/datatables.net-scroller-bs4/css/scroller.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/jstree/dist/themes/default/style.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/jqvmap/dist/jqvmap.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/uppy/dist/uppy.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/plugins/custom/jkanban/dist/jkanban.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.min.css" rel="stylesheet" type="text/css"/>

    <!--end:: Vendor Plugins for custom pages -->

    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{ asset('assets/affiliate/css/skins/header/base/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/css/skins/header/menu/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/css/skins/brand/dark.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/affiliate/css/skins/aside/dark.css') }}" rel="stylesheet" type="text/css"/>

    <!--end::Layout Skins -->
    <link rel="shortcut icon" href="{{ asset('assets/affiliate/media/logos/favicon.png') }}"/>
</head>
<style>
    [v-cloak] { display:none; }
    .error {
        color: red;
    }
    .hidden{
        display: none;
    }
    [v-cloak]{
        display: none;
    }
</style>
<!-- end::Head -->

<!-- begin::Body -->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<div class="card" style="margin: 20px;">

<div class="kt-page-loader kt-page-loader--logo">
    <img alt="Logo" src="{{ asset('img/affiliate-logo.png') }}" style="width: 10rem;height: 10rem">
    <div class="kt-spinner kt-spinner--danger"></div>
</div>
<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="index.html">
            <img alt="Logo" src="{{ asset('assets/affiliate/media/logos/logo-light.png') }}" style="width: 50px"/>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
            <span></span></button>
        <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more"></i></button>
    </div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page" style=" background-image: url({{ asset('img/background-affiliate.png') }})">

        <!-- begin:: Aside -->

        <!-- Uncomment this to display the close button of the panel
<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
-->
    @include('affiliate.inc.sidenav')

    <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
        @include('affiliate.inc.nav')


        <!-- end:: Header -->
<div class="card" style="margin: 20px;">

<div class="card-body">
    @yield('content')

</div>
        <!-- begin:: Footer -->
            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->

<!-- begin::Quick Panel -->
<div id="kt_quick_panel" class="kt-quick-panel">
    <a href="#" class="kt-quick-panel__close" id="kt_quick_panel_close_btn"><i class="flaticon2-delete"></i></a>
    <div class="kt-quick-panel__nav">
        <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x nav-tabs-line-brand  kt-notification-item-padding-x"
            role="tablist">
            <li class="nav-item active">
                <a class="nav-link active" data-toggle="tab" href="#kt_quick_panel_tab_notifications" role="tab">Notifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_quick_panel_tab_logs" role="tab">Audit Logs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#kt_quick_panel_tab_settings" role="tab">Settings</a>
            </li>
        </ul>
    </div>
    <div class="kt-quick-panel__content">
        <div class="tab-content">
            <div class="tab-pane fade show kt-scroll active" id="kt_quick_panel_tab_notifications" role="tabpanel">
                <div class="kt-notification">
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-line-chart kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New order has been received
                            </div>
                            <div class="kt-notification__item-time">
                                2 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-box-1 kt-font-brand"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New customer is registered
                            </div>
                            <div class="kt-notification__item-time">
                                3 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-chart2 kt-font-danger"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                Application has been approved
                            </div>
                            <div class="kt-notification__item-time">
                                3 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-image-file kt-font-warning"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New file has been uploaded
                            </div>
                            <div class="kt-notification__item-time">
                                5 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-drop kt-font-info"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New user feedback received
                            </div>
                            <div class="kt-notification__item-time">
                                8 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-pie-chart-2 kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                System reboot has been successfully completed
                            </div>
                            <div class="kt-notification__item-time">
                                12 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-favourite kt-font-danger"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New order has been placed
                            </div>
                            <div class="kt-notification__item-time">
                                15 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item kt-notification__item--read">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-safe kt-font-primary"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                Company meeting canceled
                            </div>
                            <div class="kt-notification__item-time">
                                19 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-psd kt-font-success"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New report has been received
                            </div>
                            <div class="kt-notification__item-time">
                                23 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon-download-1 kt-font-danger"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                Finance report has been generated
                            </div>
                            <div class="kt-notification__item-time">
                                25 hrs ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon-security kt-font-warning"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New customer comment recieved
                            </div>
                            <div class="kt-notification__item-time">
                                2 days ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification__item">
                        <div class="kt-notification__item-icon">
                            <i class="flaticon2-pie-chart kt-font-warning"></i>
                        </div>
                        <div class="kt-notification__item-details">
                            <div class="kt-notification__item-title">
                                New customer is registered
                            </div>
                            <div class="kt-notification__item-time">
                                3 days ago
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="tab-pane fade kt-scroll" id="kt_quick_panel_tab_logs" role="tabpanel">
                <div class="kt-notification-v2">
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon-bell kt-font-brand"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                5 new user generated report
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                Reports based on sales
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon2-box kt-font-danger"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                2 new items submited
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                by Grog John
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon-psd kt-font-brand"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                79 PSD files generated
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                Reports based on sales
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon2-supermarket kt-font-warning"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                $2900 worth producucts sold
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                Total 234 items
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon-paper-plane-1 kt-font-success"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                4.5h-avarage response time
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                Fostest is Barry
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon2-information kt-font-danger"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                Database server is down
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                10 mins ago
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon2-mail-1 kt-font-brand"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                System report has been generated
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                Fostest is Barry
                            </div>
                        </div>
                    </a>
                    <a href="#" class="kt-notification-v2__item">
                        <div class="kt-notification-v2__item-icon">
                            <i class="flaticon2-hangouts-logo kt-font-warning"></i>
                        </div>
                        <div class="kt-notification-v2__itek-wrapper">
                            <div class="kt-notification-v2__item-title">
                                4.5h-avarage response time
                            </div>
                            <div class="kt-notification-v2__item-desc">
                                Fostest is Barry
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="tab-pane kt-quick-panel__content-padding-x fade kt-scroll" id="kt_quick_panel_tab_settings"
                 role="tabpanel">
                <form class="kt-form">
                    <div class="kt-heading kt-heading--sm kt-heading--space-sm">Customer Care</div>
                    <div class="form-group form-group-xs row">
                        <label class="col-8 col-form-label">Enable Notifications:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--success kt-switch--sm">
										<label>
											<input type="checkbox" checked="checked" name="quick_panel_notifications_1">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="form-group form-group-xs row">
                        <label class="col-8 col-form-label">Enable Case Tracking:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--success kt-switch--sm">
										<label>
											<input type="checkbox" name="quick_panel_notifications_2">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="form-group form-group-last form-group-xs row">
                        <label class="col-8 col-form-label">Support Portal:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--success kt-switch--sm">
										<label>
											<input type="checkbox" checked="checked" name="quick_panel_notifications_2">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--space-md kt-separator--border-dashed"></div>
                    <div class="kt-heading kt-heading--sm kt-heading--space-sm">Reports</div>
                    <div class="form-group form-group-xs row">
                        <label class="col-8 col-form-label">Generate Reports:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--sm kt-switch--danger">
										<label>
											<input type="checkbox" checked="checked" name="quick_panel_notifications_3">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="form-group form-group-xs row">
                        <label class="col-8 col-form-label">Enable Report Export:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--sm kt-switch--danger">
										<label>
											<input type="checkbox" name="quick_panel_notifications_3">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="form-group form-group-last form-group-xs row">
                        <label class="col-8 col-form-label">Allow Data Collection:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--sm kt-switch--danger">
										<label>
											<input type="checkbox" checked="checked" name="quick_panel_notifications_4">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="kt-separator kt-separator--space-md kt-separator--border-dashed"></div>
                    <div class="kt-heading kt-heading--sm kt-heading--space-sm">Memebers</div>
                    <div class="form-group form-group-xs row">
                        <label class="col-8 col-form-label">Enable Member singup:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--sm kt-switch--brand">
										<label>
											<input type="checkbox" checked="checked" name="quick_panel_notifications_5">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="form-group form-group-xs row">
                        <label class="col-8 col-form-label">Allow User Feedbacks:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--sm kt-switch--brand">
										<label>
											<input type="checkbox" name="quick_panel_notifications_5">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                    <div class="form-group form-group-last form-group-xs row">
                        <label class="col-8 col-form-label">Enable Customer Portal:</label>
                        <div class="col-4 kt-align-right">
									<span class="kt-switch kt-switch--sm kt-switch--brand">
										<label>
											<input type="checkbox" checked="checked" name="quick_panel_notifications_6">
											<span></span>
										</label>
									</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- end::Quick Panel -->

<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->

<!-- begin::Sticky Toolbar -->


<!-- end::Sticky Toolbar -->


<!-- end::Demo Panel -->

<!--ENd:: Chat-->

<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#5d78ff",
                "dark": "#282a3c",
                "light": "#ffffff",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": [
                    "#c5cbe3",
                    "#a1a8c3",
                    "#3d4465",
                    "#3e4466"
                ],
                "shape": [
                    "#f0f3ff",
                    "#d9dffa",
                    "#afb4d4",
                    "#646c9a"
                ]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<!--begin:: Vendor Plugins -->
<script src="{{ asset('assets/affiliate/plugins/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap/dist/js/bootstrap.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/tooltip.js/dist/umd/tooltip.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/wnumb/wNumb.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/jquery-form/dist/jquery.form.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/bootstrap-datepicker.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/bootstrap-timepicker.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-daterangepicker/daterangepicker.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-maxlength/src/bootstrap-maxlength.js') }}"
        type="text/javascript"></script>
<script
    src="{{ asset('assets/affiliate/plugins/general/plugins/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-select/dist/js/bootstrap-select.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-switch/dist/js/bootstrap-switch.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/bootstrap-switch.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/select2/dist/js/select2.full.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/ion-rangeslider/js/ion.rangeSlider.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/typeahead.js/dist/typeahead.bundle.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/handlebars/dist/handlebars.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/inputmask/dist/jquery.inputmask.bundle.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/inputmask/dist/inputmask/inputmask.date.extensions.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/nouislider/distribute/nouislider.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/owl.carousel/dist/owl.carousel.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/autosize/dist/autosize.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/clipboard/dist/clipboard.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/dropzone/dist/dropzone.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/dropzone.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/quill/dist/quill.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/@yaireo/tagify/dist/tagify.polyfills.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/@yaireo/tagify/dist/tagify.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/summernote/dist/summernote.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/markdown/lib/markdown.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-markdown/js/bootstrap-markdown.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/bootstrap-markdown.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/bootstrap-notify/bootstrap-notify.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/bootstrap-notify.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/jquery-validation/dist/jquery.validate.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/jquery-validation/dist/additional-methods.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/jquery-validation.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/dual-listbox/dist/dual-listbox.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/raphael/raphael.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/morris.js/morris.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
<script
    src="{{ asset('assets/affiliate/plugins/general/plugins/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/plugins/jquery-idletimer/idle-timer.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/waypoints/lib/jquery.waypoints.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/counterup/jquery.counterup.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/es6-promise-polyfill/promise.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/sweetalert2/dist/sweetalert2.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/js/global/integration/plugins/sweetalert2.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/jquery.repeater/src/jquery.input.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/jquery.repeater/src/repeater.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/general/dompurify/dist/purify.js') }}" type="text/javascript"></script>

<!--end:: Vendor Plugins -->
<script src="{{ asset('assets/affiliate/js/scripts.bundle.js') }}" type="text/javascript"></script>

<!--begin:: Vendor Plugins for custom pages -->
<script src="{{ asset('assets/affiliate/plugins/custom/plugins/jquery-ui/jquery-ui.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/core/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/daygrid/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/google-calendar/main.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/interaction/main.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/list/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/@fullcalendar/timegrid/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/gmaps/gmaps.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/flot/dist/es5/jquery.flot.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/flot/source/jquery.flot.resize.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/flot/source/jquery.flot.categories.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/flot/source/jquery.flot.pie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/flot/source/jquery.flot.stack.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/flot/source/jquery.flot.crosshair.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/flot/source/jquery.flot.axislabels.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net/js/jquery.dataTables.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-bs4/js/dataTables.bootstrap4.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/js/global/integration/plugins/datatables.init.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-autofill/js/dataTables.autoFill.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-autofill-bs4/js/autoFill.bootstrap4.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jszip/dist/jszip.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/pdfmake/build/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/pdfmake/build/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-buttons/js/dataTables.buttons.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-buttons/js/buttons.colVis.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-buttons/js/buttons.flash.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-buttons/js/buttons.html5.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-buttons/js/buttons.print.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-colreorder/js/dataTables.colReorder.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-responsive/js/dataTables.responsive.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-rowgroup/js/dataTables.rowGroup.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-rowreorder/js/dataTables.rowReorder.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-scroller/js/dataTables.scroller.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/datatables.net-select/js/dataTables.select.min.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jstree/dist/jstree.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jqvmap/dist/jquery.vmap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jqvmap/dist/maps/jquery.vmap.world.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jqvmap/dist/maps/jquery.vmap.russia.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jqvmap/dist/maps/jquery.vmap.usa.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jqvmap/dist/maps/jquery.vmap.germany.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jqvmap/dist/maps/jquery.vmap.europe.js') }}"
        type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/uppy/dist/uppy.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/tinymce/themes/silver/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/tinymce/themes/mobile/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/affiliate/plugins/custom/jkanban/dist/jkanban.min.js') }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js" type="text/javascript"></script>
    <script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>

<!--end:: Vendor Plugins for custom pages -->

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="{{ asset('assets/affiliate/js/pages/dashboard.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<!--end::Page Scripts -->
<script>
    $(document).ready(function () {
        $('[data-toggle="switch"]').bootstrapSwitch();
        $('.summernote').summernote({
            height: 200,
        });
        $('.dropify').dropify();
        $('.selectpicker').selectpicker();
        $('.kt-select2').select2();
    });
    @if(\Session::has('success'))
    Swal.fire({
        position: 'center',
        type: 'success',
        title: '{!! Session::get('success') !!}',
        showConfirmButton: false,
        timer: 1500
    });
    @endif
    @if(\Session::has('error'))
    Swal.fire({
        position: 'center',
        type: 'error',
        title: '{!! Session::get('error') !!}',
        showConfirmButton: false,
        timer: 1500
    });
    @endif

</script>
@yield('script')
</body>

<!-- end::Body -->
</html>
