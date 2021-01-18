@extends('layouts.default')

@section('title')
{{ config('app.name') }}
@endsection


@section('content')

<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="{{ asset('img/hero.jpg') }}">
  <form class="d-flex tm-search-form" method="GET" action="{{ route("home") }}">
    @csrf
      <input name="search" class="form-control tm-search-input" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success tm-search-btn" type="submit">
        <i class="fas fa-search"></i>
      </button>
  </form>
</div>

<div class="container-fluid tm-container-content tm-mt-60">
  <div class="row mb-4">
      <h2 class="col-12 tm-text-primary">Photo title goes here</h2>
  </div>
  @if (isset($media))
     <div class="row tm-mb-90">            
      <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
          <img src="{{ $media->file }}" alt="Image" class="img-fluid">
      </div>
      <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
          <div class="tm-bg-gray tm-video-details">
              <p class="mb-4">
                  {{ $media->description }}
              </p>
              <div class="text-center mb-5">
              <a href="{{ $media->file }}" class="btn btn-primary tm-btn-big">Download</a>
              </div>                    
              <div class="mb-4 d-flex flex-wrap">
                  <div class="mr-4 mb-2">
                      <span class="tm-text-gray-dark">Dimension: </span><span class="tm-text-primary">{{ $media->dimension }}</span>
                  </div>
                  <div class="mr-4 mb-2">
                      <span class="tm-text-gray-dark">Size: </span><span class="tm-text-primary">{{ $media->size }}</span>
                  </div>
                  <div class="mr-4 mb-2">
                      <span class="tm-text-gray-dark">Format: </span><span class="tm-text-primary">{{ $media->format }}</span>
                  </div>
                  <div class="mr-4 mb-2">
                      <span class="tm-text-gray-dark">Views: </span><span class="tm-text-primary">{{ $media->views }}</span>
                  </div>
                  <div class="mr-4 mb-2">
                      <span class="tm-text-gray-dark">Likes: </span><span class="tm-text-primary">{{ $media->likes }}</span>
                  </div>
                  @if ($media->price > 0 )
                  <div class="mr-4 mb-2">
                      <span class="tm-text-gray-dark">Price: </span><span class="tm-text-primary">{{ '$'.$media->price }}</span>
                  </div>
                  @endif
              </div>
              @if ($media->price <= 0 )
                <div class="mb-4">
                  <h3 class="tm-text-gray-dark mb-3">License</h3>
                  <p>Free for both personal and commercial use. No need to pay anything. No need to make any attribution.</p>
                </div>  
              @endif
              
              @if (isset($media->tags))
                <div>
                    <h3 class="tm-text-gray-dark mb-3">Tags</h3>
                    @foreach ($media->tags as $index => $tag)
                      <a href="{{ route('tags.show', $tag) }}" class="tm-text-primary mr-4 mb-2 d-inline-block">{{ $tag->label }}</a>  
                    @endforeach
                    
                </div>  
              @endif
              
          </div>
      </div>
  </div> 
  @endif
  


  <div class="row mb-4">
      <h2 class="col-12 tm-text-primary">
          Related Photos
      </h2>
  </div>
  <div class="row mb-3 tm-gallery">
    @foreach ($related_photos as $index => $photo)
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
        <figure class="effect-ming tm-video-item">
            <img src="{{ $photo->file ? $photo->file : '' }}" alt="{{ $photo->name }}" class="img-fluid">
            <figcaption class="d-flex align-items-center justify-content-center">
                <h2>{{ Str::limit($photo->name, 10, '...') }}</h2>
                <a href="{{ route('media.show', $photo) }}">View more</a>
            </figcaption>                    
        </figure>
        <div class="d-flex justify-content-between tm-text-gray">
        <span class="tm-text-gray-light">{{ $photo->created_at->format("d M Y") }}</span>
            <span>{{ $photo->views . " views" }}</span>
        </div>
      </div> 
    @endforeach     
  </div> <!-- row -->
</div>
<!-- container-fluid, tm-container-content -->

@endsection