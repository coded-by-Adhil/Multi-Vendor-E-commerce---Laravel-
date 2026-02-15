<!-- about-area -->
@php


$content_id = 1;
$about_page_Content = App\Models\About::firstOrFail();
$about_multiple_image = App\Models\MultiImage::all(); 
@endphp


<section id="aboutSection" class="about">
    <div class="container">
    <div class="row align-items-center">
    <div class="col-lg-6">
    <ul class="about__icons__wrap">


    @foreach ($about_multiple_image as $image)

        <li><img class="light" src="{{ asset('storage/' . $image->image_url) }}" alt="XD"></li>
        
    @endforeach
    </ul>
    </div>
    <div class="col-lg-6">
    <div class="about__content">
    <div class="section__title">
    <span class="sub-title">01 - About me</span>
    <h2 class="title">{{ $about_page_Content->title ?? '' }}</h2>
    </div>
    <div class="about__exp">
    <div class="about__exp__icon">
    <img src="{{ asset('frontend/assets/img/icons/about_icon.png') }}" alt="">
    </div>
    <div class="about__exp__content">
    <p>{{ $about_page_Content->short_title  ?? '' }}</p>
    </div>
    </div>
    <p class="desc">{{ $about_page_Content->short_description  ?? ''  }}</p>
    <a href="{{ route('home.about') }}" class="btn">Download my resume</a>
    </div>
    </div>
    </div>
    </div>
    </section>
    <!-- about-area-end -->