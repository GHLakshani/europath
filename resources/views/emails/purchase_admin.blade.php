<h2>New Purchase Received</h2>

<p><strong>User:</strong> {{ $user->name }} ({{ $user->email }})</p>
<p><strong>Address:</strong> {{ $details['address'] }}</p>
<hr>

<h3>Image Details</h3>
<p><strong>Image ID:</strong> {{ $details['image_id'] }}</p>
<p><strong>Title:</strong> {{ $details['image_title'] }}</p>
<p>
    <strong>Preview:</strong><br>
    <img src="{{ asset('storage/app/public/' . $details['image_url']) }}" alt="Purchased Image" style="max-width: 300px; border: 1px solid #ccc;">
</p>

<hr>

<h3>Payment Details</h3>
<p><strong>Payment Slip:</strong></p>
<p>
    <img src="{{ asset('storage/app/private/' . $details['payment_slip']) }}" alt="Payment Slip" style="max-width: 300px; border: 1px solid #ccc;">
</p>

<p>Please process this order as soon as possible.</p>
