@extends('layouts.admin')

@section('title')
View Media
@endsection



@section('content')

<!-- Start Content-->
@if (isset($media))
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-sm-8 col-xl-6">
      <h4 class="mb-1 mt-0">
        Media: {{ $media->name }}
      </h4>
    </div>

    @if (Auth::check() && Auth::user()->hasMedia($media->id))
    <div class="col-sm-4 col-xl-6 text-sm-right">
      <div class="btn-group ml-2 d-none d-sm-inline-block">
        <a href="{{ route('media.edit', $media) }}" type="button" class="btn btn-soft-primary btn-sm"><i
            class="uil uil-edit mr-1"></i>Edit</a>
      </div>
      <div class="btn-group d-none d-sm-inline-block">
        <a href="{{ route('delete-media', $media) }}" type="button" class="btn btn-soft-danger btn-sm"><i
            class="uil uil-trash-alt mr-1"></i>Delete</a>
      </div>
    </div>
    @endif

  </div>

  <!-- details-->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="text-muted mt-3">

            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-4 pb-3">
                <img src="{{ $media->file }}" class="img img-responsive img-thumbnail" alt="{{ $media->name }}">
              </div>
              <div class="col-lg-8 col-md-8 col-sm-8">
                <h6 class="mt-0 header-title">About Media Photo</h6>
                <div class="text-muted mb-4"><em><strong>Last Updated: </strong>{{ $media->created_at->diffForHumans() }}</em></div>
                <p>
                  {{ $media->description ? $media->description : '' }}
                </p>
                <h6 class="mt-5 header-title">Media Properties</h6>
                <div class="row mb-5">
                  <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="mt-4">
                      <p class="mb-2"><i class="uil-arrows-resize-h text-danger font-size-20"></i> Dimension</p>
                      <h5 class="font-size-16">{{ $media->dimension }}</h5>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="mt-4">
                      <p class="mb-2"><i class="uil-image-resize-landscape text-danger font-size-20"></i> Size</p>
                      <h5 class="font-size-16">{{ $media->size }}</h5>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="mt-4">
                      <p class="mb-2"><i class="uil-book-open text-danger font-size-20"></i> Format</p>
                      <h5 class="font-size-16">{{ $media->media_format }}</h5>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="mt-4">
                      <p class="mb-2"><i class="uil-bitcoin text-danger font-size-20"></i> Price</p>
                      <h5 class="font-size-16">{{ $media->price }}</h5>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="mt-4">
                      <p class="mb-2"><i class="uil-heart text-danger font-size-20"></i> Likes</p>
                      <h5 class="font-size-16">{{ $media->likes }}</h5>
                    </div>
                  </div>
                  <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="mt-4">
                      <p class="mb-2"><i class="uil-eye text-danger font-size-20"></i> Views</p>
                      <h5 class="font-size-16">{{ $media->views }}</h5>
                    </div>
                  </div>
                </div>
              </div>
            </div>



          </div>

        </div>
      </div>
      <!-- end card -->
    </div>
  </div>
</div>
<!-- end row -->

</div> <!-- container-fluid -->
@endif


@endsection