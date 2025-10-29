@if($cart && count($cart) > 0)
<table class="table">
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        @foreach($cart as $item)
            @php $total = $item['price'] * $item['quantity']; $grandTotal += $total; @endphp
            <tr>
                <td><img src="{{ $item['image'] }}" width="50"></td>
                <td>{{ $item['name'] }}</td>
                <td>৳ {{ $item['price'] }}</td>
                <td>
                    <div class="input-group" style="width:120px;">
                        <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})" {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                        <input type="text" class="form-control text-center" value="{{ $item['quantity'] }}" readonly>
                        <button class="btn btn-outline-secondary btn-sm" onclick="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})">+</button>
                    </div>
                </td>
                <td>৳ {{ $total }}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeFromCart({{ $item['id'] }})">Remove</button>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-end fw-bold">Grand Total:</td>
            <td class="fw-bold">৳ {{ $grandTotal }}</td>
            <td></td>
        </tr>
    </tbody>
</table>
@else
<p>Your cart is empty.</p>
@endif
