<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

{{--    @trixassets--}}


    <!-- Scripts -->
    <script src="{{ asset('vendor/starter-kit/js/app.js') }}" defer></script>
    <script src="https://cdn.ckeditor.com/4.14.0/full-all/ckeditor.js" ></script>

    <!-- Styles -->
    <link href="{{ asset('vendor/starter-kit/css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">

    @include('component.navbar')
    <div id="wrapper">
        <div id="top-menu">
            <div class="row">
                <form action="" class="col-md-9" >
                    <input type="search" value="" placeholder="{{__("Search in all panel")}}" class="form-control" />
                </form>
                <div class="col-md-3">
                    <div class="m-2 float-right">
                        {{__("Welcome")}}: {{auth()->user()->name}}
                    </div>
                </div>
            </div>
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div id="preloader">
        <i class="fas fa-spinner fa fa-spinner fa-spin"></i>
    </div>
</div>
<script type="text/javascript">
    var xupload =  "{{route('admin.ckeditor.upload', ['_token' => csrf_token() ])}}";
    var tagsearch = "{{route('admin.ckeditor.tagsearch','')}}";
</script>
@yield('js-content')
</body>
</html>
