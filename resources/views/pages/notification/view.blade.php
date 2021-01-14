@extends('layouts.admin')

@section('title')
{{ trans('View Notifications') }}
@endsection


@section('content')
<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-md-12">
      <nav aria-label="breadcrumb" class="float-right mt-1">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('notifications.index') }}">Notifications</a></li>
          <li class="breadcrumb-item active" aria-current="page">View Detail</li>
        </ol>
      </nav>
      <h4 class="mb-1 mt-0">Notification Detail</h4>
    </div>
  </div>

  <!-- Right Sidebar -->
  <div class="row">
    <div class="col-lg-12">
      <div class="email-container">
        <!-- Left sidebar -->
        {{-- LEFT SIDE --}}
        <!-- End Left sidebar -->

        <div class="inbox-rightbar p-4">
          @if (isset($notification))
          <div class="btn-group mb-2">
            @if (!$notification->is_spam)
            <a href="{{ route('notifications.toggle_spam', [$notification, 'status'=> true]) }}" type="button" disabled class="btn btn-light" data-toggle="tooltip" data-placement="top"
                title="Mark as spam"><i class="uil uil-exclamation-octagon"></i></a>
            @endif
            <a href="{{ route('notifications.delete', $notification) }}" type="button" class="btn btn-light" data-toggle="tooltip" data-placement="top" title="Delete"><i
                class="uil uil-trash-alt"></i></a>
          </div>
          <div class="btn-group mb-2" data-toggle="tooltip" data-placement="top" title="More Actions">
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="uil uil-ellipsis-h font-size-13"></i> More
              <i class="uil uil-angle-down"></i>
            </button>
            <div class="dropdown-menu">
              <span class="dropdown-header">More Option :</span>
              <a class="dropdown-item" href="{{ route('notifications.toggle_read', [$notification, 'id' => $notification->id, 'status' => false]) }}">
                Mark as Unread
              </a>
              {{-- <a class="dropdown-item" href="javascript: void(0);">Add to
                                  Tasks</a>
                              <a class="dropdown-item" href="javascript: void(0);">Add Star</a>
                              <a class="dropdown-item" href="javascript: void(0);">Mute</a> --}}
            </div>
          </div>

          <div class="mt-2">
            <h5>Hi {{ $user ? $user->name . ',': '' }}</h5>

            <hr />

            <div class="media mb-4 mt-1">
              <div class="media-body">
                <span class="float-right">{{ $notification->created_at->format('d/m/Y H:m a') }}</span>
                {{-- <h6 class="m-0 font-14">{{ isset($user) ? $user->name : '' }}</h6> --}}
              </div>
            </div>

            {{-- <p><b>Hi Bro...</b></p> --}}
            <div class="text-muted">
              @foreach ($notification->data as $index => $data)
              <p>
                {{ $data }}
              </p>
              @endforeach
            </div>

            <hr />

          </div> <!-- card-box -->
          @endif


        </div>
        <!-- end inbox-rightbar-->
      </div>

      <!-- end card -->
    </div> <!-- end Col -->

  </div><!-- End row -->

</div> <!-- container-fluid -->

@endsection