<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from hencework.com/theme/philbert/full-width-dark/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 06 Oct 2017 10:14:21 GMT -->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta name="base-url" content="{{ route('admin.dashboard') }}/{{--{{route('admin.dashboard')}}--}}">

    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Morris Charts CSS -->
  {{--  <link href="{{ asset('admin/vendors/bower_components/morris.js/morris.css') }}" rel="stylesheet" type="text/css"/>

    --}}<!-- Data table CSS -->
    <link href="{{ asset('admin/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('admin/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/vendors/bower_components/nprogress/nprogress.css') }}" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="{{ asset('admin/dist/css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
<!-- Preloader -->
<div class="preloader-it">
    <div class="la-anim-1"></div>
</div>
<!-- /Preloader -->

<div class="wrapper theme-1-active pimary-color-green">
    <!-- Top Menu Items -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="mobile-only-brand pull-left">
            <div class="nav-header pull-left">
                <div class="logo-wrap">
                    <a href="index.html">
                        <img class="brand-img" src="{{ asset('logo.png') }}" alt="brand"/>
                        <span class="brand-text">{{ env('APP_NAME') }}</span>
                    </a>
                </div>
            </div>
            <a id="toggle_nav_btn" class="toggle-left-nav-btn inline-block ml-20 pull-left" href="javascript:void(0);"><i class="zmdi zmdi-menu"></i></a>
            <a id="toggle_mobile_search" data-toggle="collapse" data-target="#search_form" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-search"></i></a>
            <a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="zmdi zmdi-more"></i></a>
            <form id="search_form" role="search" class="top-nav-search collapse pull-left">
                <div class="input-group">
                    <input type="text" name="example-input1-group2" class="form-control" placeholder="Search">
                    <span class="input-group-btn">
						<button type="button" class="btn  btn-default"  data-target="#search_form" data-toggle="collapse" aria-label="Close" aria-expanded="true"><i class="zmdi zmdi-search"></i></button>
						</span>
                </div>
            </form>
        </div>
        <div id="mobile_only_nav" class="mobile-only-nav pull-right">
            <ul class="nav navbar-right top-nav pull-right">
                <li>
                    <a id="open_right_sidebar" href="#"><i class="zmdi zmdi-settings top-nav-icon"></i></a>
                </li>
                <li class="dropdown app-drp">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-apps top-nav-icon"></i></a>
                    <ul class="dropdown-menu app-dropdown" data-dropdown-in="slideInRight" data-dropdown-out="flipOutX">
                        <li>
                            <div class="app-nicescroll-bar">
                                <ul class="app-icon-wrap pa-10">
                                    <li>
                                        <a href="weather.html" class="connection-item">
                                            <i class="zmdi zmdi-cloud-outline txt-info"></i>
                                            <span class="block">weather</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="inbox.html" class="connection-item">
                                            <i class="zmdi zmdi-email-open txt-success"></i>
                                            <span class="block">e-mail</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="calendar.html" class="connection-item">
                                            <i class="zmdi zmdi-calendar-check txt-primary"></i>
                                            <span class="block">calendar</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="vector-map.html" class="connection-item">
                                            <i class="zmdi zmdi-map txt-danger"></i>
                                            <span class="block">map</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="chats.html" class="connection-item">
                                            <i class="zmdi zmdi-comment-outline txt-warning"></i>
                                            <span class="block">chat</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="contact-card.html" class="connection-item">
                                            <i class="zmdi zmdi-assignment-account"></i>
                                            <span class="block">contact</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="app-box-bottom-wrap">
                                <hr class="light-grey-hr ma-0"/>
                                <a class="block text-center read-all" href="javascript:void(0)"> more </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown full-width-drp">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-more-vert top-nav-icon"></i></a>
                    <ul class="dropdown-menu mega-menu pa-0" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                        <li class="product-nicescroll-bar row">
                            <ul class="pa-20">
                                <li class="col-md-3 col-xs-6 col-menu-list">
                                    <a href="javascript:void(0);"><div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Dashboard</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                                    <hr class="light-grey-hr ma-0"/>
                                    <ul>
                                        <li>
                                            <a href="index.html">Analytical</a>
                                        </li>
                                        <li>
                                            <a href="index2.html">Demographic</a>
                                        </li>
                                        <li>
                                            <a href="index3.html">Project</a>
                                        </li>
                                        <li>
                                            <a href="index4.html">Hospital</a>
                                        </li>
                                        <li>
                                            <a href="index5.html">HRM</a>
                                        </li>
                                        <li>
                                            <a href="index6.html">Real Estate</a>
                                        </li>
                                        <li>
                                            <a href="profile.html">profile</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="col-md-3 col-xs-6 col-menu-list">
                                    <a href="javascript:void(0);">
                                        <div class="pull-left">
                                            <i class="zmdi zmdi-shopping-basket mr-20"></i><span class="right-nav-text">E-Commerce</span>
                                        </div>
                                        <div class="pull-right"><span class="label label-success">hot</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </a>
                                    <hr class="light-grey-hr ma-0"/>
                                    <ul>
                                        <li>
                                            <a href="e-commerce.html">Dashboard</a>
                                        </li>
                                        <li>
                                            <a href="product.html">Products</a>
                                        </li>
                                        <li>
                                            <a href="product-detail.html">Product Detail</a>
                                        </li>
                                        <li>
                                            <a href="add-products.html">Add Product</a>
                                        </li>
                                        <li>
                                            <a href="product-orders.html">Orders</a>
                                        </li>
                                        <li>
                                            <a href="product-cart.html">Cart</a>
                                        </li>
                                        <li>
                                            <a href="product-checkout.html">Checkout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown alert-drp">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="zmdi zmdi-notifications top-nav-icon"></i><span class="top-nav-icon-badge">5</span></a>
                    <ul  class="dropdown-menu alert-dropdown" data-dropdown-in="bounceIn" data-dropdown-out="bounceOut">
                        <li>
                            <div class="notification-box-head-wrap">
                                <span class="notification-box-head pull-left inline-block">notifications</span>
                                <a class="txt-danger pull-right clear-notifications inline-block" href="javascript:void(0)"> clear all </a>
                                <div class="clearfix"></div>
                                <hr class="light-grey-hr ma-0"/>
                            </div>
                        </li>
                        <li>
                            <div class="streamline message-nicescroll-bar">
                                <div class="sl-item">
                                    <a href="javascript:void(0)">
                                        <div class="icon bg-green">
                                            <i class="zmdi zmdi-flag"></i>
                                        </div>
                                        <div class="sl-content">
												<span class="inline-block capitalize-font  pull-left truncate head-notifications">
												New subscription created</span>
                                            <span class="inline-block font-11  pull-right notifications-time">2pm</span>
                                            <div class="clearfix"></div>
                                            <p class="truncate">Your customer subscribed for the basic plan. The customer will pay $25 per month.</p>
                                        </div>
                                    </a>
                                </div>
                                <hr class="light-grey-hr ma-0"/>
                                <div class="sl-item">
                                    <a href="javascript:void(0)">
                                        <div class="icon bg-yellow">
                                            <i class="zmdi zmdi-trending-down"></i>
                                        </div>
                                        <div class="sl-content">
                                            <span class="inline-block capitalize-font  pull-left truncate head-notifications txt-warning">Server #2 not responding</span>
                                            <span class="inline-block font-11 pull-right notifications-time">1pm</span>
                                            <div class="clearfix"></div>
                                            <p class="truncate">Some technical error occurred needs to be resolved.</p>
                                        </div>
                                    </a>
                                </div>
                                <hr class="light-grey-hr ma-0"/>
                                <div class="sl-item">
                                    <a href="javascript:void(0)">
                                        <div class="icon bg-blue">
                                            <i class="zmdi zmdi-email"></i>
                                        </div>
                                        <div class="sl-content">
                                            <span class="inline-block capitalize-font  pull-left truncate head-notifications">2 new messages</span>
                                            <span class="inline-block font-11  pull-right notifications-time">4pm</span>
                                            <div class="clearfix"></div>
                                            <p class="truncate"> The last payment for your G Suite Basic subscription failed.</p>
                                        </div>
                                    </a>
                                </div>
                                <hr class="light-grey-hr ma-0"/>
                                <div class="sl-item">
                                    <a href="javascript:void(0)">
                                        <div class="sl-avatar">
                                            <img class="img-responsive" src="dist/img/avatar.jpg" alt="avatar"/>
                                        </div>
                                        <div class="sl-content">
                                            <span class="inline-block capitalize-font  pull-left truncate head-notifications">Sandy Doe</span>
                                            <span class="inline-block font-11  pull-right notifications-time">1pm</span>
                                            <div class="clearfix"></div>
                                            <p class="truncate">Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit</p>
                                        </div>
                                    </a>
                                </div>
                                <hr class="light-grey-hr ma-0"/>
                                <div class="sl-item">
                                    <a href="javascript:void(0)">
                                        <div class="icon bg-red">
                                            <i class="zmdi zmdi-storage"></i>
                                        </div>
                                        <div class="sl-content">
                                            <span class="inline-block capitalize-font  pull-left truncate head-notifications txt-danger">99% server space occupied.</span>
                                            <span class="inline-block font-11  pull-right notifications-time">1pm</span>
                                            <div class="clearfix"></div>
                                            <p class="truncate">consectetur, adipisci velit.</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="notification-box-bottom-wrap">
                                <hr class="light-grey-hr ma-0"/>
                                <a class="block text-center read-all" href="javascript:void(0)"> read all </a>
                                <div class="clearfix"></div>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="dropdown auth-drp">
                    <a href="#" class="dropdown-toggle pr-0" data-toggle="dropdown"><img src="{{ asset('admin/dist/img/user1.png') }}" alt="user_auth" class="user-auth-img img-circle"/><span class="user-online-status"></span></a>
                    <ul class="dropdown-menu user-auth-dropdown" data-dropdown-in="flipInX" data-dropdown-out="flipOutX">
                        <li>
                            <a href="profile.html"><i class="zmdi zmdi-account"></i><span>Profile</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="zmdi zmdi-settings"></i><span>Settings</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('admin.logout') }}"><i class="zmdi zmdi-power"></i><span>Log Out</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /Top Menu Items -->

    <!-- Left Sidebar Menu -->
    <div class="fixed-sidebar-left">
        <ul class="nav navbar-nav side-nav nicescroll-bar">
            <li class="navigation-header">
                <span>Dashboard</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            <li>
                <a class="active" href="{{ route('admin.dashboard') }}">
                    <div class="pull-left">
                        <i class="zmdi zmdi-view-dashboard mr-20"></i>
                        <span class="right-nav-text">Dashboard</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="navigation-header">
                <span>User Module</span>
                <i class="zmdi zmdi-more"></i>
            </li>
            <li>
                <a href="{{ route('admin.user.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-account mr-20"></i>
                        <span class="right-nav-text">Users Accounts</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.plan.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-cocktail mr-20"></i>
                        <span class="right-nav-text">Plans</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.plan-condition.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-puzzle-piece mr-20"></i>
                        <span class="right-nav-text">Plan Conditions</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.withdrawal.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-alert-triangle mr-20"></i>
                        <span class="right-nav-text">Withdrawal | Request</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.withdrawalpaid.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-arrow-right mr-20"></i>
                        <span class="right-nav-text">Withdrawal | Paid</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li class="navigation-header">
                <span>Souktrain</span>
                <i class="zmdi zmdi-more"></i>
            </li>

            <li>
                <a href="{{ route('admin.income.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-money mr-20"></i>
                        <span class="right-nav-text">Income</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.settlement.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-money-box mr-20"></i>
                        <span class="right-nav-text">Settlements</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.pin-request.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-card mr-20"></i>
                        <span class="right-nav-text">Pin Requests</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.role.index') }}" data-ajax="true">
                    <div class="pull-left">
                        <i class="zmdi zmdi-lock mr-20"></i>
                        <span class="right-nav-text">Roles Permission</span>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </li>
            <li>
                <a  href="javascript:void(0);" data-toggle="collapse" data-target="#dashboard_dr"><div class="pull-left"><i class="zmdi zmdi-landscape mr-20"></i><span class="right-nav-text">Souktrain</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
                <ul id="dashboard_dr" class="collapse collapse-level-1">
                    <li>
                        <a href="{{ route('admin.profiles.index') }}" data-ajax="true">profiles</a>

                    </li>
                    <li>
                        <a href="{{ route('admin.service_center.index') }}" data-ajax="true">service centers</a>
                    </li>

                </ul>
            </li>


            <li class="navigation-header">
                <span>featured</span>
                <i class="zmdi zmdi-money-box mr-20"></i>
            </li>
        </ul>
    </div>
    <!-- /Left Sidebar Menu -->



    <!-- Right Setting Menu -->
    <div class="setting-panel">
        <ul class="right-sidebar nicescroll-bar pa-0">
            <li class="layout-switcher-wrap">
                <ul>
                    <li>
                        <span class="layout-title">Scrollable header</span>
                        <span class="layout-switcher">
								<input type="checkbox" id="switch_3" class="js-switch"  data-color="#2ecd99" data-secondary-color="#dedede" data-size="small"/>
							</span>
                        <h6 class="mt-30 mb-15">Theme colors</h6>
                        <ul class="theme-option-wrap">
                            <li id="theme-1" class="active-theme"><i class="zmdi zmdi-check"></i></li>
                            <li id="theme-2"><i class="zmdi zmdi-check"></i></li>
                            <li id="theme-3"><i class="zmdi zmdi-check"></i></li>
                            <li id="theme-4"><i class="zmdi zmdi-check"></i></li>
                            <li id="theme-5"><i class="zmdi zmdi-check"></i></li>
                            <li id="theme-6"><i class="zmdi zmdi-check"></i></li>
                        </ul>
                        <h6 class="mt-30 mb-15">Primary colors</h6>
                        <div class="radio mb-5">
                            <input type="radio" name="radio-primary-color" id="pimary-color-green" checked value="pimary-color-green">
                            <label for="pimary-color-green"> Green </label>
                        </div>
                        <div class="radio mb-5">
                            <input type="radio" name="radio-primary-color" id="pimary-color-red" value="pimary-color-red">
                            <label for="pimary-color-red"> Red </label>
                        </div>
                        <div class="radio mb-5">
                            <input type="radio" name="radio-primary-color" id="pimary-color-blue" value="pimary-color-blue">
                            <label for="pimary-color-blue"> Blue </label>
                        </div>
                        <div class="radio mb-5">
                            <input type="radio" name="radio-primary-color" id="pimary-color-yellow" value="pimary-color-yellow">
                            <label for="pimary-color-yellow"> Yellow </label>
                        </div>
                        <div class="radio mb-5">
                            <input type="radio" name="radio-primary-color" id="pimary-color-pink" value="pimary-color-pink">
                            <label for="pimary-color-pink"> Pink </label>
                        </div>
                        <div class="radio mb-5">
                            <input type="radio" name="radio-primary-color" id="pimary-color-orange" value="pimary-color-orange">
                            <label for="pimary-color-orange"> Orange </label>
                        </div>
                        <div class="radio mb-5">
                            <input type="radio" name="radio-primary-color" id="pimary-color-gold" value="pimary-color-gold">
                            <label for="pimary-color-gold"> Gold </label>
                        </div>
                        <div class="radio mb-35">
                            <input type="radio" name="radio-primary-color" id="pimary-color-silver" value="pimary-color-silver">
                            <label for="pimary-color-silver"> Silver </label>
                        </div>
                        <button id="reset_setting" class="btn  btn-success btn-xs btn-outline btn-rounded mb-10">reset</button>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <button id="setting_panel_btn" class="btn btn-success btn-circle setting-panel-btn shadow-2dp"><i class="zmdi zmdi-settings"></i></button>
    <!-- /Right Setting Menu -->

    <!-- Right Sidebar Backdrop -->
    <div class="right-sidebar-backdrop"></div>
    <!-- /Right Sidebar Backdrop -->

    <!-- Main Content -->
    <div class="page-wrapper">
        <div class="container-fluid pt-25">
            <div id="content">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer container-fluid pl-30 pr-30">
            <div class="row">
                <div class="col-sm-12">
                    <p>2017 &copy; {{ env('APP_NAME') }}</p>
                </div>
            </div>
        </footer>
        <!-- /Footer -->

    </div>
    <!-- /Main Content -->

</div>
<!-- /#wrapper -->

<!-- JavaScript -->

<!-- jQuery -->
<script src="{{ asset('admin/vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ asset('admin/navigate.js') }}"></script>

<script src="{{ asset('admin/vendors/bower_components/nprogress/nprogress.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Data table JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{ asset('admin/dist/js/jquery.slimscroll.js') }}"></script>

<!-- simpleWeather JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('admin/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/simpleweather-data.js') }}"></script>

<!-- Progressbar Animation JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('admin/vendors/bower_components/jquery.counterup/jquery.counterup.min.js') }}"></script>

<!-- Fancy Dropdown JS -->
<script src="{{ asset('admin/dist/js/dropdown-bootstrap-extended.js') }}"></script>

<!-- Sparkline JavaScript -->
<script src="{{ asset('admin/vendors/jquery.sparkline/dist/jquery.sparkline.min.js') }}"></script>

<!-- Owl JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js') }}"></script>

<!-- ChartJS JavaScript -->
<script src="{{ asset('admin/vendors/chart.js/Chart.min.js') }}"></script>

<!-- Morris Charts JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('admin/vendors/bower_components/morris.js/morris.min.js') }}"></script>
<script src="{{ asset('admin/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js') }}"></script>

<!-- Switchery JavaScript -->
<script src="{{ asset('admin/vendors/bower_components/switchery/dist/switchery.min.js') }}"></script>

<!-- Init JavaScript -->
<script src="{{ asset('admin/dist/js/init.js') }}"></script>
{{--<script src="{{ asset('admin/dist/js/dashboard-data.js') }}"></script>--}}
<script>
    $(window).load(function(){
        window.setTimeout(function(){
            $.toast({
                heading: 'Hello {{ auth()->user()->profile->fullName }}.',
                text: 'See the left navigation for menus',
                position: 'top-right',
                loaderBg:'#f0c541',
                icon: 'success',
                hideAfter: 5000,
                stack: 6
            });
        }, 3000);
    });
</script>
</body>

</html>
