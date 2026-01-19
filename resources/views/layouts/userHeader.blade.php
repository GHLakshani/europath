<section class="inner-hero-section">
    <div class="inner-main-banner w-100 bg-cover border-radius position-relative d-flex justify-content-center"
        style="background-image: url('{{ asset('storage/app/public/InnerHeaders/' . $banner_details->image) }}');">
        <div class="inner-gradient h-100 w-100">
            <div class="page-name position-absolute bg-white border-radius">
                <h1 class="header-one text-lg-end text-start" data-aos="fade-up">{{ $banner_details->page_name }}</h1>
                <p class=" mb-2 text-lg-end text-start" data-aos="fade-up">{{ $banner_details->page_caption	 }}</p>
            </div>
        </div>
    </div>
</section>

<div class="bredcrumb">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $banner_details->page_name }}</li>
        </ol>
    </nav>
</div>
