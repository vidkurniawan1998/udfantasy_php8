<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>

	<!--begin::Base Path (base relative path for assets of this page) -->
	<base href=".<?php echo base_url() ?>">

	<!--end::Base Path -->
	<meta charset="utf-8"/>
	<title>Admin - <?php echo $web_name ?></title>
	<meta name="description" content="Updates and statistics">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no user-scalable=0">

	<!--begin::Fonts -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
	</script>

	<!--end::Fonts -->
	<!--begin::Page Vendors Styles(used by this page) -->
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet"
		  type="text/css"/>

	<!--end::Page Vendors Styles -->

	<!--begin::Page Vendors Styles(used by this page) -->
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
		  type="text/css"/>

	<!--end::Page Vendors Styles -->

	<!--begin:: Global Mandatory Vendors -->
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css"
		  rel="stylesheet" type="text/css"/>

	<!--end:: Global Mandatory Vendors -->

	<!--begin:: Global Optional Vendors -->
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/tether/dist/css/tether.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css"
		  rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css"
		rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css"
		  rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-daterangepicker/daterangepicker.css"
		  rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css"
		  rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-select/dist/css/bootstrap-select.css"
		  rel="stylesheet" type="text/css"/>
	<link
		href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.css"
		rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/select2/dist/css/select2.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/nouislider/distribute/nouislider.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/owl.carousel/dist/assets/template_admin/owl.carousel.css"
		  rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/owl.carousel/dist/assets/template_admin/owl.theme.default.css"
		  rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/dropzone/dist/dropzone.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/summernote/dist/summernote.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css"
		  rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/animate.css/animate.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/toastr/build/toastr.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/morris.js/morris.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/sweetalert2/dist/sweetalert2.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/socicon/css/socicon.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/custom/vendors/line-awesome/css/line-awesome.css"
		  rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/custom/vendors/flaticon/flaticon.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/custom/vendors/flaticon2/flaticon.css" rel="stylesheet"
		  type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/vendors/general/@fortawesome/fontawesome-free/css/all.min.css"
		  rel="stylesheet" type="text/css"/>

	<!--end:: Global Optional Vendors -->

	<!--begin::Global Theme Styles(used by all pages) -->
	<link href="<?php echo base_url() ?>assets/template_admin/css/demo1/style.bundle.css" rel="stylesheet" type="text/css"/>

	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->
	<link href="<?php echo base_url() ?>assets/template_admin/css/demo1/skins/header/base/light.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/css/demo1/skins/header/menu/light.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/css/demo1/skins/brand/dark.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/css/demo1/skins/aside/dark.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo base_url() ?>assets/template_admin/css/custom.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/main.css">

	<!--end::Layout Skins -->
	<link rel="shortcut icon" href="<?php echo base_url() ?>assets/template_admin/images/favicon.png"/>
    <script src="<?php echo base_url() ?>assets/template_admin/vendors/general/jquery/dist/jquery.js" type="text/javascript"></script>
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body
	class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
	<div class="kt-header-mobile__logo">
		<a href="<?php echo base_url() ?>admin" style="font-size: 24px; color: white;">ADMIN</a>
	</div>
	<div class="kt-header-mobile__toolbar">
		<button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
			<span></span></button>
		<button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
				class="flaticon-more"></i></button>
	</div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
	<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
		<!-- begin:: Aside -->
		<button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
		<div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
			 id="kt_aside">
			<!-- begin:: Aside -->
			<div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
				<div class="kt-aside__brand-logo">
					<a href="<?php echo base_url() ?>admin" style="font-size: 24px; color: white">ADMIN</a>
				</div>
				<div class="kt-aside__brand-tools">
					<button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
						<span>
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
								 width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
									<path
										d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
										id="Path-94" fill="#000000" fill-rule="nonzero"
										transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
									<path
										d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
										id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
										transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
								</g>
							</svg>
						</span>
						<span>
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
								 width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
									<path
										d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
										id="Path-94" fill="#000000" fill-rule="nonzero"/>
									<path
										d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
										id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
										transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
								</g>
							</svg>
						</span>
					</button>
				</div>
			</div>
			<!-- end:: Aside -->


            <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
                     data-ktmenu-dropdown-timeout="500">
                    <ul class="kt-menu__nav ">
                        <?php foreach ($menu_list as $key => $val) { ?>
                            <li class="kt-menu__section ">
                                <h4 class="kt-menu__section-text"><?php echo $key ?></h4>
                                <i class="kt-menu__section-icon flaticon-more-v2"></i>
                            </li>
                            <?php foreach ($val as $key1 => $val1) {
                                $sub_menu = count($val1['sub_menu']) > 0 ? TRUE : FALSE;
                                $icon = $sub_menu ? '<i class="fa fa-chevron-right"></i>' : '<i class="fa fa-minus"></i>';
                                $icon_right = $sub_menu ? '<i class="kt-menu__ver-arrow la la-angle-right"></i>' : '';

                                $menu_active = '';
                                if ($current_url == $val1['route']) {
                                    $menu_active = 'kt-menu__item--active';
                                } else {
                                    foreach ($val1['sub_menu'] as $key2 => $val2) {
                                        if ($current_url == $val2['route']) {
                                            $menu_active = 'kt-menu__item--open '; //'kt-menu__item--active';
                                        }
                                    }
                                }

                                $target_blank = $val1['label'] == 'View Website' ? 'target="_blank"':'';

                                ?>
                                <li class="kt-menu__item  kt-menu__item--submenu <?php echo $menu_active ?>"
                                    aria-haspopup="true"
                                    data-ktmenu-submenu-toggle="hover">
                                    <a href="<?php echo $val1['route'] ?>"
                                       class="kt-menu__link <?php echo $sub_menu ? 'kt-menu__toggle' : '' ?>"
                                        <?php echo $target_blank ?>>
										<span class="kt-menu__link-icon">
										<?php echo $icon ?>
										</span>
                                        <span class="kt-menu__link-text">
											<?php echo $val1['label'] ?>
										</span>
                                        <?php echo $icon_right ?>
                                    </a>
                                    <div class="kt-menu__submenu ">
                                        <span class="kt-menu__arrow"></span>
                                        <ul class="kt-menu__subnav">
                                            <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true">
                                                <span class="kt-menu__link">
                                                    <span class="kt-menu__link-text"><?php echo $val1['label'] ?></span>
                                                </span>
                                            </li>
                                            <?php foreach ($val1['sub_menu'] as $key2 => $val2) {
                                                $menu_sub_active = '';
                                                if ($current_url == $val2['route']) {
                                                    $menu_sub_active = 'kt-menu__item--active'; //'kt-menu__item--active';
                                                }

                                                ?>
                                                <li class="kt-menu__item <?php echo $menu_sub_active ?>"
                                                    aria-haspopup="true">
                                                    <a href="<?php echo $val2['route'] ?>"
                                                       class="kt-menu__link ">
                                                        <i class="kt-menu__link-bullet kt-menu__link-bullet--dot"><span></span></i>
                                                        <span class="kt-menu__link-text"><?php echo $val2['label'] ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>

		</div>

		<!-- end:: Aside -->
		<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

			<!-- begin:: Header -->
			<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

				<!-- begin:: Header Menu -->
				<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
						class="la la-close"></i></button>
				<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">

				</div>

				<!-- end:: Header Menu -->

				<!-- begin:: Header Topbar -->
				<div class="kt-header__topbar">

					<!--begin: User Bar -->
					<div class="kt-header__topbar-item kt-header__topbar-item--user">
						<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px">
							<div class="kt-header__topbar-user">
								<span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
								<span class="kt-header__topbar-username kt-hidden-mobile"><?php echo $name ?></span>
								<img class="kt-hidden" alt="Pic"
									 src="<?php echo base_url() ?>assets/template_admin/media/users/300_25.jpg"/>

								<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
								<span
									class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold">S</span>
							</div>
						</div>
						<div
							class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">

							<!--begin: Head -->
							<div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
								 style="background-image: url(<?php echo base_url() ?>assets/template_admin/media/misc/bg-1.jpg)">
								<div class="kt-user-card__avatar">
									<img class="kt-hidden" alt="Pic"
										 src="<?php echo base_url() ?>assets/template_admin/media/users/300_25.jpg"/>

									<!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
									<span
										class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">S</span>
								</div>
								<div class="kt-user-card__name">
									<?php echo $name ?>
								</div>
<!--								<div class="kt-user-card__badge">-->
<!--									<span class="btn btn-success btn-sm btn-bold btn-font-md">23 messages</span>-->
<!--								</div>-->
							</div>

							<!--end: Head -->

							<!--begin: Navigation -->
							<div class="kt-notification">
								<div class="kt-notification__custom kt-space-between">
									<a href="<?php echo base_url('proweb/logout') ?>"
									   class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</a>
								</div>
							</div>

							<!--end: Navigation -->
						</div>
					</div>

					<!--end: User Bar -->
				</div>

				<!-- end:: Header Topbar -->
			</div>

			<!-- end:: Header -->
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

				<!-- begin:: Content Head -->
				<div class="kt-subheader   kt-grid__item" id="kt_subheader">
					<div class="kt-subheader__main">
						<h3 class="kt-subheader__title"><?php echo $breadcrumb ?></h3>
						<span class="kt-subheader__separator kt-subheader__separator--v"></span>
						<div class="kt-input-icon kt-input-icon--right kt-subheader__search kt-hidden">
							<input type="text" class="form-control" placeholder="Search order..." id="generalSearch">
							<span class="kt-input-icon__icon kt-input-icon__icon--right">
								<span><i class="flaticon2-search-1"></i></span>
							</span>
						</div>
					</div>
				</div>

				<!-- end:: Content Head -->

				<!-- begin:: Content -->
				<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
					<!--Begin::Dashboard 1-->
					<?php echo $contents ?>
					<!--End::Dashboard 1-->
				</div>
				<!-- end:: Content -->
			</div>

			<!-- begin:: Footer -->
			<div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
				<div class="kt-footer__copyright">
					2013 - <?php echo date('Y') ?>&nbsp;&copy;&nbsp;<a href="https://redsystem.id" target="_blank" class="kt-link">Red System</a>
				</div>
			</div>

			<!-- end:: Footer -->
		</div>
	</div>
</div>

<!-- end:: Page -->

<div class='container-loading hide'>
    <div class='loader'>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--dot'></div>
        <div class='loader--text'></div>
        <div class='loader--desc'></div>
    </div>
</div>



<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
	<i class="fa fa-arrow-up"></i>
</div>
<span id="base_url" title="<?php echo base_url(); ?>"></span>
<span id="base_url" data-base-url="<?php echo base_url(); ?>"></span>

<!-- end::Scrolltop -->

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
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
            }
        }
    };
</script>

<!-- end::Global Config -->

<!--begin:: Global Mandatory Vendors -->
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/popper.js/dist/umd/popper.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap/dist/js/bootstrap.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/js-cookie/src/js.cookie.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/moment/min/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/tooltip.js/dist/umd/tooltip.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/sticky-js/dist/sticky.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/wnumb/wNumb.js" type="text/javascript"></script>

<!--end:: Global Mandatory Vendors -->

<!--begin:: Global Optional Vendors -->
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/jquery-form/dist/jquery.form.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/js/vendors/bootstrap-datepicker.init.js"
		type="text/javascript"></script>
<script
	src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js"
	type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/js/vendors/bootstrap-timepicker.init.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-daterangepicker/daterangepicker.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js"
		type="text/javascript"></script>
<script
	src="<?php echo base_url() ?>assets/template_admin/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js"
	type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-select/dist/js/bootstrap-select.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/js/vendors/bootstrap-switch.init.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/select2/dist/js/select2.full.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/ion-rangeslider/js/ion.rangeSlider.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/typeahead.js/dist/typeahead.bundle.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/handlebars/dist/handlebars.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/inputmask/dist/jquery.inputmask.bundle.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/nouislider/distribute/nouislider.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/owl.carousel/dist/owl.carousel.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/autosize/dist/autosize.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/clipboard/dist/clipboard.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/dropzone/dist/dropzone.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/summernote/dist/summernote.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/markdown/lib/markdown.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/js/vendors/bootstrap-markdown.init.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/bootstrap-notify/bootstrap-notify.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/js/vendors/bootstrap-notify.init.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/jquery-validation/dist/jquery.validate.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/jquery-validation/dist/additional-methods.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/js/vendors/jquery-validation.init.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/toastr/build/toastr.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/raphael/raphael.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/morris.js/morris.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/chart.js/dist/Chart.bundle.js"
		type="text/javascript"></script>
<script
	src="<?php echo base_url() ?>assets/template_admin/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js"
	type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/waypoints/lib/jquery.waypoints.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/counterup/jquery.counterup.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/es6-promise-polyfill/promise.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/sweetalert2/dist/sweetalert2.min.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/js/vendors/sweetalert2.init.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/jquery.repeater/src/lib.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/jquery.repeater/src/jquery.input.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/jquery.repeater/src/repeater.js"
		type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/general/dompurify/dist/purify.js" type="text/javascript"></script>

<!--end:: Global Optional Vendors -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="<?php echo base_url() ?>assets/template_admin/js/demo1/scripts.bundle.js" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/fullcalendar/fullcalendar.bundle.js"
		type="text/javascript"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyBTGnKT7dt597vo9QgeQ7BFhvSRP4eiMSM" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/gmaps/gmaps.js" type="text/javascript"></script>

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo base_url() ?>assets/template_admin/js/demo1/pages/dashboard.js" type="text/javascript"></script>
<!--end::Page Scripts -->
<!--begin::Page Vendors(used by this page) -->
<script src="<?php echo base_url() ?>assets/template_admin/vendors/custom/datatables/datatables.bundle.js"
		type="text/javascript"></script>

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->
<script src="<?php echo base_url() ?>assets/template_admin/js/demo1/pages/crud/datatables/basic/scrollable.js"
		type="text/javascript"></script>

<script src="<?php echo base_url() ?>assets/template_admin/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/template_admin/js/app.js" type="text/javascript"></script>


<!--end::Page Scripts -->
</body>

<!-- end::Body -->
</html>
