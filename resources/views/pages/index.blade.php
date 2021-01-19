@extends('layouts.admin')

@section('title')
My Dashboard
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">

  <div class="row page-title">
    <div class="col-md-12">
      <nav aria-label="breadcrumb" class="float-right mt-1">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">{{ config('app.name') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ trans('Dashboard') }}</li>
        </ol>
      </nav>
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-xl-2 col-lg-3 col-6">
              <img src="assets/images/cal.png" class="mr-4 align-self-center img-fluid " alt="cal" />
            </div>
            <div class="col-xl-10 col-lg-9">
              <div class="mt-4 mt-lg-0">
                <h5 class="mt-0 mb-1 font-weight-bold">Welcome to Your Photo repository dashboard</h5>
                <p class="text-muted mb-2">
                  The dashboard shows the images synced from all your uploads.
                  Click on images to see or edit the details. 
                  You can uplaod new images by clicking on "Add Media" button below.
                </p>

                <a href="{{ route("media.create") }}" type="button" class="btn btn-primary mt-2 mr-1" id="btn-new-event"><i class="uil-plus-circle"></i> 
                  Add Media
                </a>
              </div>
            </div>
          </div>

        </div> <!-- end card body-->
      </div> <!-- end card -->
    </div>
    <!-- end col-12 -->
  </div> <!-- end row -->



  <div class="row">

    @if (isset(Auth::user()->photos))
      <div class="col-md-6 col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                          My Photos
                        </span>
                        <h2 class="mb-0">{{ count(Auth::user()->photos) }}</h2>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif

    @if (isset(Auth::user()->comments))
      <div class="col-md-6 col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                          Comments
                        </span>
                        <h2 class="mb-0">{{ count(Auth::user()->comments) }}</h2>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif
    

    @if (isset(Auth::user()->roles))
      <div class="col-md-6 col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-0">
                <div class="media p-3">
                    <div class="media-body">
                        <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                          {{ count(Auth::user()->roles) > 1 ? 'Roles' : 'Role' }}
                        </span>
                        <h2 class="mb-0">
                          @foreach (Auth::user()->roles as $role)
                            <span class="badge badge-pill badge-primary">{{ $role->label }}</span>
                          @endforeach
                        </h2>
                    </div>
                </div>
            </div>
        </div>
      </div>
    @endif
    
  </div>

  
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 mt-0 header-title">Cards</h4>
                <div class="row bg-light p-3">
                  @foreach ($dashboard['photos'] as $index => $p)
                  {{-- set limit to six --}}
                    @if ($index < 6)
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
                    @endif
                  @endforeach

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
                    <!-- end col -->
                </div>
                <!-- end row -->
                
                @if (count(Auth::user()->photos) > 6)
                <div class="row mb-3 mt-5">
                  <div class="col-12">
                    <div class="text-center">
                      <a href="{{ route('media.index') }}" class="btn btn-lg btn-primary">
                        <i data-feather="loader" class="icon-dual icon-xs mr-2 text-white"></i>
                        Show More 
                      </a>
                    </div>
                  </div>
                </div>
                @endif
            </div>
        </div>
        <!-- end card -->
    </div>
</div>
</div> 
<!-- container-fluid -->
@endsection