<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Restaurant Admin</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        #app {
            display: flex;
            min-height: 100vh;
        }
        #sidebar {
            width: 250px;
            background-color: #343a40; /* Bootstrap dark */
            padding: 20px;
            color: white;
        }
        #main-content {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa; /* Light background for content */
        }
    </style>
        @livewireStyles
</head>
<body>
    <div id="app">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Main Content -->
        <div id="main-content">
            @yield('content')
        </div>
    </div>
    
    <script src="{{ mix('js/app.js') }}" defer></script>
        @livewireScripts
</body>
</html>
