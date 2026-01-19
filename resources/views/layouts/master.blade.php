<!DOCTYPE html>
<!--
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.5.1
Author: Sunnyat A.
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0?ref=myorange
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>
        @yield('title') -  Pictorial Stock
    </title>
    <meta name="description" content="Analytics Dashboard">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <!-- Call App Mode on ios devices -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- base css -->
    @include('layouts/headerCss')
    @yield('headerStyle')
    <style>
        .parsley-errors-list {
            color: red;
            font-size: 0.9em;
            list-style-type: none; /* Removes the bullet points */
            padding-left: 0; /* Removes indentation */
            margin-top: 5px;
        }
    </style>
</head>
<body class="mod-bg-1 mod-nav-link">


    <!-- page-setting-script -->

    @include('layouts/partials/page-setting-script')

    <div class="page-wrapper">
        <div class="page-inner">
            <!-- sidebar -->
            @include('layouts/partials/sidebar')

            <div class="page-content-wrapper">

                <!-- header -->
               @include('layouts/partials/header')

                <!-- content -->
                @yield('content')

                <!-- footer -->
                @include('layouts/partials/footer')

                <!-- dialog-modal -->
                @include('layouts/partials/dialog-modal')

                <!-- color-profile -->
                @include('layouts/partials/color-profile')
            </div>
        </div>
    </div>

    <!-- bottom-setting -->
     @include('layouts/partials/bottom-setting')

     @include('layouts/footerJs')

    <!-- footerScript -->
    @yield('footerScript')
    @include('layouts.notification_alerts')
</body>

</html>
