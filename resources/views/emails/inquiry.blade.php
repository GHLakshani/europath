<h2>New Inquiry Received</h2>

<p><strong>Name:</strong> {{ $inquiry->first_name }} {{ $inquiry->last_name }}</p>
<p><strong>Email Address:</strong> {{ $inquiry->email_address }}</p>
<p><strong>Phone Number:</strong> {{ $inquiry->phone_number }}</p>
<p><strong>Mobile:</strong> {{ $inquiry->mobile }}</p>

<p><strong>Subject:</strong> {{ $inquiry->subject }}</p>
<p><strong>Message:</strong><br>
    {!! nl2br(e($inquiry->message)) !!}
</p>

<hr>

<p><strong>IP Address:</strong> {{ $inquiry->ip }}</p>

<p>This inquiry was submitted from your website.</p>
