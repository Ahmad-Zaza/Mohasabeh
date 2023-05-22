<!DOCTYPE html>
<html @if(app()->isLocale('en')) dir="ltr" @else dir="rtl" @endif>

<head>
    @include('dashboard.includes.head')
</head>

<body dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}">
    <header id="header" class="header fixed-top d-flex align-items-center">
        @include('dashboard.includes.header')
    </header>


    <aside id="sidebar" class="sidebar">
        @include('dashboard.includes.aside')
    </aside>

    <main id="main" class="main">
        @yield('content')

    </main>


    <footer id="footer" class="footer">
     
    </footer>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="{{asset('dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('dashboard/vendor/quill/quill.min.js')}}"></script>
    <script src="{{ asset('dashboard/js/main.js')}}"></script>

</body>

</html>