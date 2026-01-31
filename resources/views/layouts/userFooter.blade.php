

</div>
	<footer>
		<div class="block">
			<div class="container">
				<div class="row">
					<div class="col-md-9 column">
						<div class="widget">
							<h4 class="widget-title">Europath.com</h4>
							<p>Europath.com was created to fill a long-standing gap in the advertising industry, the need for authentic, high-quality images that truly reflect Sri Lankan life, culture, people, and landscapes.</p>
                            <p>For decades, advertisers and designers in Sri Lanka struggled to find visuals that matched the local context. Costly custom photoshoots were often the only solution, or else creatives had to alter foreign images, mainly from India, to suit local campaigns. While global royalty-free platforms offered convenience, they rarely provided the cultural authenticity we needed.</p>
							<!--<ul>-->
							<!--	<li><a href="freedownloads.html" title="">Free Downloads</a></li>-->
							<!--	<li><a href="wishlist.html" title="">Wishlist</a></li>-->
							<!--	<li><a href="price-package.html" title="">Price Packages</a></li>-->
							<!--	<li><a href="affiliations.html" title="">Affiliations</a></li>-->
							<!--	<li><a href="download-history.html" title="">Download History</a></li>-->
							<!--</ul>-->
						</div><!-- Widget -->
					</div>
					<div class="col-md-3 column">
						<div class="widget">
							<h4 class="widget-title">Follow Us</h4>
							<div class="social-widget">
								<p>Search us on our Social Media.</p>
								<ul>
									<li><a style="background:#0070cf;" href="https://www.facebook.com/share/1EmCPFiymT/?mibextid=wwXIfr" target="_blank"><i class="fa fa-facebook"></i></a></li>
									<li><a style="background:#be3100;" href="https://www.instagram.com/pictorial_stock?igsh=MW9iMnRmbTNkdHNwNA%3D%3D&utm_source=qr" target="_blank"><i class="fa fa-instagram"></i></a></li>
									<!--<li><a style="background:#d900a3;" href="https://www.tiktok.com/@pictorial_stock?_r=1&_t=ZS-912RM6dalNZ" target="_blank"><i class="fa fa-tiktok"></i></a></li>-->
									<!--<li><a style="background:#e04c86;" href="#" title=""><i class="fa fa-dribbble"></i></a></li>-->
									<!--<li><a style="background:#fe3400;" href="#" title=""><i class="fa fa-reddit"></i></a></li>-->
								</ul>
								<!--<form>-->
								<!--	<input type="text" placeholder="Subscribe" />-->
								<!--	<button><i class="ti-arrow-right"></i></button>-->
								<!--</form>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<div class="bottom-footer">
		<div class="container"><p>© {{ date('Y') }} Europath, All rights reserved.</p></div>
	</div>


	<div class="registration-popup">
		<div class="popup-overlay">
			<div class="popup-container">

				<div class="form-box signup-popup">
					<span class="close-popup"><i class="fa fa-remove"></i></span>
					<div class="title">
						<h2>Sign Up</h2>
						<i>You can select from the key</i>
					</div>
					<form class="registration-form">
                        @csrf
						<div class="row">
							<div class="col-md-12"><div class="field"><i class="ti-user"></i><input type="text" name="name" placeholder="Name" required /></div></div>
							<div class="col-md-12"><div class="field"><i class="ti-envelope"></i><input type="email" name="email" placeholder="Email Address" required /></div></div>
							<div class="col-md-12"><div class="field"><i class="ti-key"></i><input type="password" name="password" placeholder="Password" required /></div></div>
                            <div class="col-md-12"><div class="field"><i class="ti-key"></i><input type="password" name="password_confirmation" placeholder="Confirm Password" required /></div></div>
							<div class="col-md-12"><div class="field field-button"><input type="submit" value="Create Account" /></div></div>
						</div>
					</form>
				</div><!-- Sing Up Form -->

				<div class="form-box login-popup">
					<span class="close-popup"><i class="fa fa-remove"></i></span>
					<div class="title">
						<h2>LOGIN</h2>
						<i>You can select from the key</i>
					</div>
					<form class="registration-form" style="margin-bottom:20px;">
						<div class="row">
							<div class="col-md-12"><div class="field"><i class="ti-envelope"></i><input type="email" name="email" placeholder="Email Address" required  /></div></div>
							<div class="col-md-12"><div class="field"><i class="ti-key"></i><input type="password" name="password" placeholder="Password" required  /></div></div>
							<div class="col-md-12"><div class="field field-button"><input type="submit" value="Login" /></div></div>

						</div>
					</form>
                    <p>Don't have an account? <a role="button" class="show-signup" style="cursor:pointer;">Sign Up</a></p>
				</div><!-- Login Form -->

                <div class="form-box payment-popup">
                    <span class="close-popup"><i class="fa fa-remove"></i></span>
                    <div class="popup-content row">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-12 payment-info-col">
                            <div class="title">
                                <h2>Payment Details</h2>
                                <i>Please review payment info before submitting</i>
                            </div>

                            <div class="payment-summary-box">
                                <h4>Price</h4>
                                <h3 class="price-amount">Rs. <span id="popup-price">5500.00</span></h3>
                            </div>

                            <hr>

                            <div class="bank-details-box">
                                <h4>Bank Account Details</h4>
                                <ul style="list-style: none;">
                                    <li><strong>Bank:</strong> Sampath Bank</li>
                                    <li><strong>Account Name:</strong> Meesha Photography</li>
                                    <li><strong>Account No:</strong> 0091 1000 3894</li>
                                    <li><strong>Branch:</strong> Pitakotte</li>
                                    <!--<li><strong>SWIFT:</strong> BSAMLKLX</li>-->
                                </ul>
                                <p class="note">Please upload the payment slip after bank transfer.</p>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN -->
                        <div class="col-md-12">
                            <form id="payment-form" enctype="multipart/form-data" method="POST">
                                @csrf
                                <input type="hidden" name="image_id" value=""> <!-- image being purchased -->
                                <div class="col-md-12"><div class="field"><input type="text" name="full_name" placeholder="Full Name" required /></div></div>
                                <div class="col-md-12"><div class="field"><input type="email" name="email" placeholder="Email" required /></div></div>
                                <div class="col-md-12"><div class="field"><input type="text" name="address" placeholder="Address" required /></div></div>
                                <div class="col-md-12"><div class="field"><input type="file" name="payment_slip" required /></div></div>
                                <div class="col-md-12"><div class="field field-button"><input type="submit" value="Submit Payment" /></div></div>
                            </form>
                        </div>
                    </div>
                </div><!-- Payment Form -->

                <div class="form-box thankyou-box thankyou-popup">
                    <span class="close-popup"><i class="fa fa-remove"></i></span>
                    <div class="title">
                        <h2>Thank You!</h2>
                        <i>Your purchase was successful.</i>
                    </div>
                    <p>Check your email for purchase details.</p>
                </div>

			</div>
		</div>
	</div><!-- Registration Popup -->





	{{-- <div class="wishlist-btn"><a href="wishlist.html" title=""><i class="fa fa-heart"></i></a></div> --}}


	<script src="{{ asset('public/frontend/assets/js/jquery.min.js') }}" type="text/javascript"></script>
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
	<script type="text/javascript" src="{{ asset('public/frontend/assets/js/revolution/jquery.themepunch.tools.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/frontend/assets/js/revolution/jquery.themepunch.revolution.min.js') }}"></script>

	<script src="{{ asset('public/frontend/assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/frontend/assets/js/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('public/frontend/assets/js/enscroll-0.5.2.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/frontend/assets/js/jquery.scrolly.js') }}" type="text/javascript"></script>
	<script src="{{ asset('public/frontend/assets/js/jquery.isotope.min.js') }}"></script>
	<script src="{{ asset('public/frontend/assets/js/isotope-initialize.js') }}"></script>
	<script src="{{ asset('public/frontend/assets/js/script.js') }}" type="text/javascript"></script>
    <script type="text/javascript">

            let currentCategory = 'all';
            let currentPage = 1;

            function loadImages(categoryId = 'all', page = 1) {
                $.ajax({
                    url: "{{ route('images.load') }}",
                    type: "GET",
                    data: { category_id: categoryId, page: page },
                    beforeSend: function() {
                        $('#image-container').html('<p class="text-center">Loading...</p>');
                    },
                    success: function(response) {
                        $('#image-container').html(response.html);
                        $('#pagination-container').html(response.pagination);

                        // 🧱 Re-initialize isotope layout
                        var $portfolio = $('.masonary');
                        $portfolio.imagesLoaded(function() {
                            $portfolio.isotope({
                                itemSelector: '.col-md-3',
                                layoutMode: 'masonry'
                            });
                        });
                    },
                    error: function() {
                        $('#image-container').html('<p class="text-center text-danger">Error loading images.</p>');
                    }
                });
            }

            // Category filter click
            $(document).on('click', '.filter-cat a', function(e) {
                e.preventDefault();
                $('.filter-cat a').removeClass('selected');
                $(this).addClass('selected');

                currentCategory = $(this).data('category');
                currentPage = 1;
                loadImages(currentCategory, currentPage);
            });

            // Pagination click
            $(document).on('click', '#pagination-container .pagination a', function(e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                currentPage = page;
                loadImages(currentCategory, currentPage);
            });


    </script>
	<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

	    $(document).ready(function(){
			jQuery('.tp-banner').show().revolution({
				delay:15000,
				startwidth:1170,
				startheight:540,
				autoHeight:"off",
				navigationType:"none",
				hideThumbs:10,
				fullWidth:"on",
				fullScreen:"on",
				fullScreenOffsetContainer:""
			});
	    });

        $(document).on('click', '.image-links a', function(e){
            e.preventDefault();
            const imageId = $(this).data('id');
            const url = $(this).data('url');
            let price = $(this).data('price');

            $.get('{{ url("/check-login") }}', function(res){
                if(res.authenticated){
                    // set hidden input by name instead of ID
                    $('input[name="image_id"]').val(imageId);

                    // set price text inside span
                    $('#popup-price').text(price);
                    $('#payment-form').attr('action', url); // dynamically set form action
                    $('.registration-popup').fadeIn();
                    $('.payment-popup').show();
                } else {
                    $('.registration-popup').fadeIn();
                    $('.login-popup').show();
                }
            });
        });

        // Signup
        $('.signup-popup form').on('submit', function(e) {
            e.preventDefault();

            // Clear old errors and messages
            $('.error-text').remove();
            $('.signup-popup .success-text').remove();

            $.ajax({
                url: '{{ url("/stock-register") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    if (res.success) {
                        // Show success message
                        $('.signup-popup .registration-form').prepend('<p class="success-text text-success">Registration successful! Please log in.</p>');

                        // Delay to let user see success message briefly
                        setTimeout(function() {
                            // Hide signup popup
                            $('.signup-popup').fadeOut(300);

                            // Clear signup form
                            $('.signup-popup form')[0].reset();

                            // Show login popup
                            $('.login-popup').fadeIn(300);
                        }, 1000);
                    } else {
                        alert('Signup failed');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            let input = $('[name="' + key + '"]');
                            input.after('<small class="error-text text-danger">' + messages[0] + '</small>');
                        });
                    } else {
                        console.error(xhr.responseText);
                        alert('Something went wrong.');
                    }
                }
            });
        });


        // Login
        $(document).on('submit', '.login-popup form', function(e) {
            e.preventDefault();
            $('.error-text').remove();
            $('.login-popup .success-text').remove();

            $.ajax({
                url: '{{ url("/stock-login") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    if (res.success) location.reload();
                    else alert(res.message);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, messages) {
                            let input = $('[name="' + key + '"]');
                            input.after('<small class="error-text text-danger">' + messages[0] + '</small>');
                        });
                    } else {
                        console.error(xhr.responseText);
                        alert('Something went wrong.');
                    }
                }
            });
        });

        // Show signup popup from login popup
        document.querySelector('.show-signup').addEventListener('click', function(e) {
            e.preventDefault();
            $('.registration-popup').fadeIn();
            $('.login-popup').hide();
            $('.signup-popup').fadeIn();
        });

        $('#payment-form').on('submit', function(e){
            e.preventDefault();
            let formData = new FormData(this);

            // Clear previous error messages
            $('.field-error').remove();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(res){
                    if(res.success){
                        $('.payment-popup').fadeOut();
                        $('.registration-popup').fadeIn();
                        $('.thankyou-popup').show();
                    }
                },
                error: function(xhr){
                    if(xhr.status === 422){
                        // Laravel validation error
                        let errors = xhr.responseJSON.errors;
                        for(let field in errors){
                            let input = $('[name="'+field+'"]');
                            input.after('<span class="field-error" style="color:red;">'+errors[field][0]+'</span>');
                        }
                    } else {
                        alert('Something went wrong');
                    }
                }
            });
        });



        $('.close-popup').on('click', function(){
            $(this).closest('.form-box').fadeOut(); // hide only the current popup box
            $('.registration-popup').fadeOut(); // fade out overlay if you want
        });


        $(document).on('submit', '#logout-form', function(e) {
            e.preventDefault();
            $.post('{{ route("site.logout") }}', {_token: '{{ csrf_token() }}'}, function(res) {
                if (res.success) {
                    location.reload();
                }
            });
        });

        // document.querySelectorAll('.select-image').forEach(item => {
        //     item.addEventListener('click', function () {
        //         let price = this.getAttribute('data-price');
        //         document.getElementById('popup-price').innerText = parseFloat(price).toFixed(2);
        //     });
        // });



	</script>
