<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Restaurant Driver</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        #navbar {
            background-color: #343a40; /* Dark background for navbar */
            padding: 10px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        #navbar .nav-links {
            display: flex;
            gap: 20px;
        }
        #navbar .nav-link {
            color: white;
            text-decoration: none;
        }
        #navbar .nav-link:hover {
            text-decoration: underline;
        }
        #main-content {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa; /* Light background for content */
        }
        .notification-icon {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .notification-icon .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
        .notification-dropdown {
            display: none;
            position: absolute;
            top: 30px;
            right: 0; /* Align dropdown to the right */
            background-color: white;
            color: black;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 300px;
            z-index: 1000;
            border-radius: 4px;
        }
        .notification-dropdown.active {
            display: block;
        }
        .notification-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .notification-item:last-child {
            border-bottom: none;
        }
        .notification-item p {
            margin: 0;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <div id="navbar">
            <div class="nav-links">
                <a class="nav-link" href="{{ route('driver.orders.index') }}">My Orders</a>
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </div>

            <div class="notification-icon" onclick="toggleNotifications()">
                <i class="fas fa-bell"></i>
                <span class="badge" id="notification-count">{{ auth()->user()->unreadNotifications->count() }}</span>
                <div id="notification-dropdown" class="notification-dropdown">
                    @forelse (auth()->user()->unreadNotifications as $notification)
                        <div class="notification-item">
                            <p>{{ $notification->data['message'] }}</p>
                        </div>
                    @empty
                        <div class="notification-item">
                            <p>No new notifications.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div id="main-content">
            @yield('content')
        </div>
    </div>
    
    <script src="{{ mix('js/app.js') }}" defer></script>

    <script>
        function toggleNotifications() {
            var dropdown = document.getElementById('notification-dropdown');
            dropdown.classList.toggle('active');
            playNotificationSound();

            // Mark notifications as read
            fetch('{{ route('driver.notifications.markAsRead') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('notification-count').innerText = '0';
                }
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        }

        function playNotificationSound() {
            var audio = new Audio('{{ asset('sounds/notification.mp3') }}'); // Ensure you have a sound file at this path
            audio.play();
        }
    </script>
</body>
</html>
