<div id="sidebar" class="bg-dark text-white">
    <h2 class="text-center">Restaurant Admin</h2>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.foods.index') }}">Foods</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.variants.index') }}">Extras for food</a>
        </li>
      
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.orders.index') }}">Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.users.index') }}">Users</a>
        </li>
        <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    </li>
    </ul>
</div>
