@extends('layouts.default')

@section('title')
{{ config('app.name') }}
@endsection


@section('content')

<div class="tm-hero d-flex justify-content-center align-items-center" data-parallax="scroll" data-image-src="img/hero.jpg">
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
      <h2 class="col-6 tm-text-primary">
          Latest Photos
      </h2>
      <div class="col-6 d-flex justify-content-end align-items-center">
        <form action="" class="tm-text-primary">
        Page <input type="text" value="{{ $photos->currentPage() }}" size="1" class="tm-input-paging tm-text-primary"> of {{ $photos->lastPage() }}
        </form>
      </div>
  </div>
  <div class="row tm-mb-90 tm-gallery">
    {{-- {{ $photos }} --}}
    @foreach ($photos as $index => $photo)
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
  </div>
  <!-- row -->
  
  <div class="row tm-mb-90">
    {{ $photos->links("partials.landing._pagination") }}          
  </div>
</div>
<!-- container-fluid, tm-container-content -->

@endsection