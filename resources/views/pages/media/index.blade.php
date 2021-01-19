@extends('layouts.admin')

@section('title')
{{ trans('All Photos') }}
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title align-items-center">
    <div class="col-md-3 col-xl-6">
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
    @if (Auth::check() && !Auth::user()->hasRole(['user','admin']))
    <div class="col-md-9 col-xl-6 text-md-right">
      <div class="mt-4 mt-md-0">
        <a href="{{ route('media.create') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          {{ trans('Add Photo') }}
        </a>
      </div>
    </div>
    @endif
  </div>

  <div class="row">
    @if (isset($photos))
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-body p-3">

          <div class="row bg-light p-3">
            @foreach (Auth::user()->photos as $p)
            <div class="col-xl-6">
              <div class="card">
                <div class="row no-gutters align-items-center">
                  <div class="col-md-5">
                    <img src="{{ $p->file }}" class="card-img pl-lg-3" alt="...">
                  </div>
                  <div class="col-md-7">
                    <div class="card-body">
                      <h5 class="card-title font-size-16">{{ Str::limit($p->name, 50, '...') }}</h5>
                      <p class="card-text text-muted">{{ Str::limit($p->description, 120, '...') }}</p>
                      <p class="card-text"><small class="text-muted">Last updated
                          {{ $p->updated_at->diffForHumans() }}</small></p>
                      <div class="btn-group" role="group" aria-label="Button group">
                        <a href="{{ route('media.show', $p) }}" type="button" class="btn btn-primary btn-xs">view</a>
                        <a href="{{ route('delete-media', $p) }}" type="button" class="btn btn-danger btn-xs">delete</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            <!-- end col -->
            @if (!count(Auth::user()->photos))
            <div class="col-lg-12">
              <div class="card">
                <div class="row no-gutters align-items-center">
                  <div class="col-md-12">
                    <div class="card-body">
                      <h2 class="card-text text-title"><i data-feather="folder"></i></h2>
                      <h5 class="card-title font-size-16">You currently do not have any photos</h5>
                      <p class="card-text text-muted">
                      Upload photos and you'll see them here.  
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>

        </div>
      </div>
      <!-- end card -->
    </div>
    @endif

  </div>
  <!-- end row -->

</div> <!-- container-fluid -->

@endsection