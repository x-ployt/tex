<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title', 'Custom Title')</title>
        <link rel="icon" type="image/x-icon" href="{{asset('')}}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- CSS --}}
        @include('include.css')

    </head>
    <body class="layout-navbar-fixed layout-fixed sidebar-mini" style="font-family: 'Inter', sans-serif; font-size: 15px;">
        
        <div class="wrapper">
            
            {{-- Navbar --}}
            <nav id="navBar" class="main-header navbar navbar-expand" style="background-color: #4CAF50; color: white;">
                @include('include.header')
            </nav>

            {{-- Sidebar --}}
            <aside id="sideBar" class="main-sidebar sidebar-dark-primary elevation-4">
                <p href="{{route('dashboard')}}" class="brand-link logo-switch" style="background-color: #4CAF50; color: white;">
                    <i class="fa-solid fa-fw fa-box fa-lg" style="color: #fda720"></i>
                    <span class="brand-text fw-bold">TEX</span>
                </p>   

                <div class="sidebar" style="background-color:#4CAF50;">
                    @include('include.sidebar')
                </div>
            </aside>
            
            {{-- Content --}}
            <div class="content-wrapper px-4 py-4" style="background-color: white;">
                @yield('content') 
                @include('navigation.profile.change-password')
                @include('navigation.profile.view-profile')
            </div>

            {{-- Footer --}}
            <footer class="main-footer">
                <div class="float-right d-none d-sm-inline">v1</div>
                <strong>Copyright © 2025 | <a>Salveowell Order Tracker</a></strong> | All rights reserved.
            </footer>
        </div>

        {{-- Scripts --}}
        @include('include.js')
        @stack('scripts')
    </body>
</html>
