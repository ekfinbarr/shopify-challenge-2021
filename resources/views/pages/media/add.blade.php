@extends('layouts.admin')

@section('title')
New Photo Media
@endsection



@section('content')
    <!-- bootstrap 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <!-- link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css" /-->
    <!-- the font awesome icon library if using with `fas` theme (or Bootstrap 4.x). Note that default icons used in the plugin are glyphicons that are bundled only with Bootstrap 3.x. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <!-- piexif.min.js is needed for auto orienting image files OR when restoring exif data in resized images and when you
        wish to resize images before upload. This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/piexif.min.js" type="text/javascript"></script>
    <!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
        This must be loaded before fileinput.min.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/sortable.min.js" type="text/javascript"></script>
    <!-- popper.min.js below is needed if you use bootstrap 4.x (for popover and tooltips). You can also use the bootstrap js 
       3.3.x versions without popper.min.js. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
        dialog. bootstrap 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- the main fileinput plugin file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/fileinput.min.js"></script>
    <!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script>
    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/locales/LANG.js"></script>


<div class="row page-title">
  <div class="col-md-12">
    <nav aria-label="breadcrumb" class="float-right mt-1">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('media.index') }}">{{ trans('Media') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
      </ol>
    </nav>
    <h4 class="mb-1 mt-0">@yield('title')</h4>
  </div>
</div>

<div class="row">
  <!-- end col -->
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-0 mb-1">{{ trans('New Media form') }}</h4>
        <p class="sub-header">{{ trans('Fill in the form to add a new lesson') }}</p>

        <div class="row mg-2">
          <div class="col-12">
            <form action="{{ route('media.store') }}" method="post" enctype="multipart/form-data">
              @csrf
              
              <div class="row">

                <div class="col-lg-10">
                  <div class="form-group">
                    <label class="control-label">Media File</label>
                    {{-- <input class="form-control" value="{{ old('name') }}" placeholder="Title/Name of Image" type="text" name="name" id="photo-name"
                      required /> --}}
                    <input id="input-b1" name="image" type="file" class="file" data-browse-on-zone-click="true">
                    <div class="invalid-feedback">Please provide a valid file</div>
                  </div>
                </div>

                <div class="col-lg-10">
                  <div class="form-group">
                    <label class="control-label">Name</label>
                    <input class="form-control" value="{{ old('name') }}" placeholder="Title/Name of Image" type="text" name="name" id="photo-name"/>
                    <div class="invalid-feedback">Please provide a valid name</div>
                  </div>
                </div>


                <div class="col-10">
                <div class="form-group">
                  <label class="control-label">Description</label>
                  <textarea class="form-control" value="{{ old('description') }}" placeholder="Media description" rows="3" required name="description"
                    id="lesson-description"></textarea>
                  <div class="invalid-feedback">Please provide a valid input</div>
                </div>
              </div>

              <div class="form-group col-lg-5">
                <label for="sw-dots-first-name">Category</label>
                <select name="category_id" class="custom-select custom-select-md mb-2" required>
                  <option disabled>-- Select Category --</option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->label }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-lg-5">
                <label for="sw-dots-first-name">Media Type</label>
                <select name="media_type_id" class="custom-select custom-select-md mb-2" required>
                  <option disabled>-- Select Media Type --</option>
                  @foreach ($media_types as $type)
                  <option value="{{ $type->id }}">{{ $type->label }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-lg-5">
                <label for="sw-dots-first-name">Media Format</label>
                <select name="media_format_id" class="custom-select custom-select-md mb-2">
                  <option disabled>-- Select Media Format --</option>
                  @foreach ($media_formats as $format)
                  <option value="{{ $format->id }}">{{ $format->label }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group col-lg-5">
                <label for="sw-dots-first-name">Media Access</label>
                <select name="access_id" class="custom-select custom-select-md mb-2">
                  <option disabled>-- Select Access Type --</option>
                  @foreach ($access_types as $access)
                  <option value="{{ $access->id }}">{{ $access->label }}</option>
                  @endforeach
                </select>
              </div>


              <div class="col-lg-5">
                <div class="form-group">
                  <label class="control-label">Price</label>
                  <input class="form-control" value="{{ old('price') }}" placeholder="Price tag" type="number" min="0" step="any" value="0.00" name="price" id="photo-price" />
                  <div class="invalid-feedback">Please provide a valid input</div>
                </div>
              </div>

              <div class="col-lg-5">
                <div class="form-group">
                  <label class="control-label">Publication Status </label>
                  <select class="form-control custom-select" value="{{ old('published') }}" name="published" id="published" required>
                    <option value="true" selected>Publish</option>
                    <option value="false">Unpublish</option>
                  </select>
                  <div class="invalid-feedback">Please select a status</div>
                </div>
              </div>


              <hr class="mt-5 mb-3">

              <div class="col-lg-12 mb-lg-5 mt-2">
                <div class="form-group mt-2 mb-10">
                  <div class="custom-control custom-radio mb-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </div>
              </div>

            </form>

          </div> <!-- end col -->
          
        </div> <!-- end row -->


      </div>
    </div>
    <!-- end card -->
  </div>
  <!-- end col -->
  <style>
    .sw-toolbar-bottom {
      visibility: hidden;
    }
  </style>
</div>

@endsection