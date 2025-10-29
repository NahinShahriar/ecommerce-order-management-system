<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'E-Commerce') }}</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite('resources/css/app.css')
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<!-- Header / Navbar -->
<header class="bg-white shadow-sm mb-4">
    <nav class="container navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#" style="color:brown"><strong>E-Commerce</strong></a>

        <div class="ms-auto d-flex align-items-center">
            <!-- Cart Button -->
            <button class="btn btn-outline-success position-relative me-2" data-bs-toggle="modal" data-bs-target="#cartModal">
                Cart <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">0</span>
            </button>

            <!-- Authentication Links -->
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Log in</a>
                @endauth
            @endif
        </div>
    </nav>
</header>

<!-- Main Content -->
<main class="container my-4">
    <h2 class="mb-4 text-center">Our Products</h2>
    <div class="row" id="product-list"></div>
    <div class="d-flex justify-content-center my-3" id="pagination"></div>
</main>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    &copy; {{ date('Y') }} E-Commerce. All rights reserved.
</footer>

<!-- Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-end">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Your Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="cart-body">Loading cart...</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" onclick="checkoutCart()">Checkout</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const isLoggedIn = @json(Auth::check());
let currentPage = 1;


function loadProducts(page=1){
    fetch(`/api/products?page=${page}`)
    .then(res=>res.json())
    .then(data=>{
        let html='';
        data.data.forEach(product=>{
            html+=`
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="${product.image}" class="card-img-top" style="height:150px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text flex-grow-1">${product.description}</p>
                        <p class="fw-bold">৳ ${product.price}</p>
                        <button class="btn btn-primary w-100" onclick="addToCart(${product.id})">Add to Cart</button>
                    </div>
                </div>
            </div>`;
        });
        document.getElementById('product-list').innerHTML=html;

      
        let pagHtml='';
        for(let i=1;i<=data.last_page;i++){
            pagHtml+=`<button class="btn btn-sm btn-outline-primary mx-1 ${i===data.current_page?'active':''}" onclick="loadProducts(${i})">${i}</button>`;
        }
        document.getElementById('pagination').innerHTML=pagHtml;
    });
}


function addToCart(productId){
    if(!isLoggedIn){
        alert('Please log in to add items to your cart.');
        return;
    }

    fetch('/api/cart/add',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        credentials: 'include',
        body: JSON.stringify({product_id:productId})
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.error) { alert(data.error); return; }
        updateCartCount(data.cart_count);
        loadCart();
    });
}


function loadCart(){
    fetch('/api/cart', { credentials:'include' })
    .then(res=>res.json())
    .then(data=>{
        let cart = data.cart || [];
        if(cart.length>0){
            let html = `<table class="table">
                <thead>
                    <tr><th>Image</th><th>Name</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>
                </thead>
                <tbody>`;
            let grandTotal = 0;
            cart.forEach(item=>{
                let total = item.qty * item.product.price;
                grandTotal += total;
                html += `<tr>
                    <td><img src="${item.product.image}" width="50"></td>
                    <td>${item.product.name}</td>
                    <td>৳ ${item.product.price}</td>
                    <td>
                        <div class="input-group" style="width:120px;">
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(${item.product.id},${item.qty-1})" ${item.qty<=1?'disabled':''}>-</button>
                            <input type="text" class="form-control text-center" value="${item.qty}" readonly>
                            <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity(${item.product.id},${item.qty+1})">+</button>
                        </div>
                    </td>
                    <td>৳ ${total}</td>
                    <td><button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.product.id})">Remove</button></td>
                </tr>`;
            });
            html += `<tr>
                <td colspan="4" class="text-end fw-bold">Grand Total:</td>
                <td class="fw-bold">৳ ${grandTotal}</td>
                <td></td>
            </tr></tbody></table>`;
            document.getElementById('cart-body').innerHTML = html;
        } else {
            document.getElementById('cart-body').innerHTML = '<p>Your cart is empty.</p>';
        }
    });
}



function changeQty(productId, delta){
    const input = document.getElementById(`qty-${productId}`);
    let newQty = parseInt(input.value) + delta;
    if(newQty < 1) newQty = 1;
    input.value = newQty;
    updateQuantity(productId, newQty);
}


function updateQuantity(productId, qty){
    fetch('/api/cart/update',{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken},
        body: JSON.stringify({product_id:productId, quantity:qty})
    })
    .then(res=>res.json())
    .then(data=>{
        updateCartCount(data.cart_count);
        loadCart();
    });
}


function removeFromCart(productId){
    fetch('/api/cart/remove',{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken},
        body: JSON.stringify({product_id:productId})
    })
    .then(res=>res.json())
    .then(data=>{
        updateCartCount(data.cart_count);
        loadCart();
    });
}

function checkoutCart(){
    fetch('/api/cart/checkout',{
        method:'POST',
        headers:{'X-CSRF-TOKEN': csrfToken}
    })
    .then(res=>res.json())
    .then(data=>{
        if(data.success){
            updateCartCount(0);
            loadCart();
            bootstrap.Modal.getInstance(document.getElementById('cartModal')).hide();
            alert('Order placed! Order No: ' + data.order_no);
        } else {
            alert(data.error);
        }
    });
}


function updateCartCount(count=0){
    document.getElementById('cart-count').innerText = count;
}

document.addEventListener('DOMContentLoaded',()=>{
    loadProducts();
    fetch('/api/cart/count')
    .then(res=>res.json())
    .then(data=>updateCartCount(data.cart_count));
});

document.getElementById('cartModal').addEventListener('show.bs.modal', loadCart);
</script>

</body>
</html>
