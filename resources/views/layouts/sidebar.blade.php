<div class="card shadow-sm border-0 rounded-3 h-100">
    <div class="card-header bg-primary text-white fw-bold text-center">
        Menu
    </div>
    <ul class="list-group list-group-flush sidebar-list">
        <li class="list-group-item">
            <a href="" class="menu-link">Dashboard</a>
        </li>

        @if(auth()->user()->role == 'outlet_incharge')
            <li class="list-group-item"><a href="{{ route('outlet.orders') }}" class="menu-link">My Orders</a></li>
        @endif

        @if(auth()->user()->role == 'admin')
            <li class="list-group-item"><a href="{{ route('orders.index') }}" class="menu-link">All Orders</a></li>
        @endif

        @if(auth()->user()->role == 'super_admin')
            <li class="list-group-item"><a href="{{ route('orders.index') }}" class="menu-link">All Orders</a></li>
            <li class="list-group-item"><a href="{{route('users.index')}}" class="menu-link">Users</a></li>
            <li class="list-group-item"><a href="{{route('outlets')}}" class="menu-link">Outlets</a></li>
            <li class="list-group-item"><a href="{{route('products.index')}}" class="menu-link">Products</a></li>
        @endif
    </ul>
</div>
<style>
.sidebar-list .list-group-item {
    border: none;
    padding: 10px 15px;
    transition: 0.3s;
}
.sidebar-list .list-group-item:last-child {
    border-bottom: none;
}
.menu-link {
    display: block;
    color: #333;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}
.menu-link:hover {
    color: #007bff;
    padding-left: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
}
</style>
