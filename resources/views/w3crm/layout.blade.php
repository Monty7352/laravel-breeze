<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @include('w3crm.css');
    @yield('css')
</head>
<body data-typography="poppins" data-theme-version="light" data-layout="vertical" data-nav-headerbg="black" data-headerbg="color_1">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <div id="main-wrapper">
        @include('w3crm.navheader')
        @include('w3crm.chatbox')
        @include('w3crm.header')
        @include('w3crm.sidebar')
        
        <div class="content-body">
            @yield('content')

        </div>  
        
        

        @include('w3crm.footer')





    </div>   

    @include('w3crm.js')
    @yield('js')
</body>
</html>