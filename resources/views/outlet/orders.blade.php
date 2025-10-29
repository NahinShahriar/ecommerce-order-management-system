@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3 h-100" style="position:sticky; top:20px;">
                <div class="card-header bg-primary text-white fw-bold text-center">
                    Menu
                </div>
                <ul class="list-group list-group-flush sidebar-list">
                    <li class="list-group-item">
                        <a href="{{ route('dashboard') }}" class="menu-link">Dashboard</a>
                    </li>

                    @if(auth()->user()->role == 'outlet_incharge')
                      
                        <li class="list-group-item"><a href="{{ route('outlet.orders') }}" class="menu-link">My Orders</a></li>
                    @endif

                    @if(auth()->user()->role == 'admin')
                        <li class="list-group-item"><a href="{{ route('orders.index') }}" class="menu-link">All Orders</a></li>
                    @endif

                    @if(auth()->user()->role == 'super_admin')
                        <li class="list-group-item"><a href="" class="menu-link">All Orders</a></li>
                        <li class="list-group-item"><a href="" class="menu-link">Users</a></li>
                        <li class="list-group-item"><a href="" class="menu-link">Outlets</a></li>
                        <li class="list-group-item"><a href="" class="menu-link">Products</a></li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <h2 class="mb-4">My Outlet Orders</h2>

            @if($orders->count() > 0)
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Order No</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>৳ {{ $order->total_amount }}</td>
                        <td>
                            @if($order->status == 'pending')
                            <button class="btn btn-success btn-sm" onclick="acceptOrder({{ $order->id }})">Accept</button>
                            @endif
                            <button class="btn btn-primary btn-sm" onclick="transferOrder({{ $order->id }})">Transfer</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p>No orders found.</p>
            @endif
        </div>
    </div>
</div>

<script>
function acceptOrder(orderId){
    fetch('/outlet/orders/accepting', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({order_id: orderId})
    })
    .then(res => res.json())
    .then(data => {
        console.log(data); // <-- log the response
        location.reload(); // then reload
    })
    .catch(err => console.error('Error:', err)); // optional: log errors
}


function transferOrder(orderId){
    let newOutletId = prompt("Enter new outlet ID to transfer:");
    if(!newOutletId) return;

    fetch('/outlet/orders/transfering', {
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':'{{ csrf_token() }}'
        },
        body: JSON.stringify({order_id: orderId, new_outlet_id: newOutletId})
    })
    .then(res => res.json())
    .then(data => location.reload());
}
</script>

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
@endsection
