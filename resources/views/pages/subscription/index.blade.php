@extends('layouts.admin')

@section('title')
{{ trans('Timetable Lesson Subscriptions') }}
@endsection



@section('content')

<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title align-items-center">
    <div class="col-md-3 col-xl-6">
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
    @if (Auth::check())
    <div class="col-md-9 col-xl-6 text-md-right">
      <div class="mt-4 mt-md-0">
        <a href="{{ route('timetables.index') }}" type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0">
          <i class="uil-plus mr-1"></i>
          {{ trans('Add Subscription') }}
        </a>
      </div>
    </div>
    @endif
  </div>

  <div class="row">
    @if (isset($subscriptions))
    <div class="col-xl-12 col-lg-12">
      <div class="card">
        <div class="card-body p-3">
          <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>{{ trans('Class') }}</th>
                <th>{{ trans('Lesson') }}</th>
                <th>{{ trans('Start time') }}</th>
                <th>{{ trans('End time') }}</th>
                <th>{{ trans('Teacher') }}</th>
                <th>{{ trans('Notifications') }}</th>
                <th>{{ trans('Status') }}</th>
                <th>{{ trans('Actions') }}</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($subscriptions as $index => $subscription)
              <tr>
                <th scope="row">{{ $index + 1 }}</th>
                <td>{{ $subscription->class ? Str::limit($subscription->label, 70, '...') : '' }}</td>
                <td>{{ $subscription->lesson ? Str::limit($subscription->lesson->title, 70, '...') : '' }}</td>
                <td>{{ $subscription->lesson ? $subscription->lesson->start_time . $subscription->lesson->start_period : '' }}</td>
                <td>{{ $subscription->lesson ? $subscription->lesson->end_time . $subscription->lesson->end_period : '' }}</td>
                <td>{{ $subscription->lesson->teacher ? $subscription->lesson->teacher->name : '' }}</td>
                <td><i class="{{ $subscription->notifications ? 'uil-bell' : 'uil-bell-slash '}}"></td>
                <td>
                  <span class="badge p-1 {{ $subscription->active ? 'badge-soft-primary' : 'badge-soft-danger' }}">
                    {{ $subscription->active ? trans('Active') : trans('Inactive') }}
                  </span>
                </td>
                <td>
                  <div class="btn-group dropdown">
                    <button class="btn btn-primary">Options</button>
                    <button id="my-dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-caret-down" aria-hidden="true"></i>
                      <span class="sr-only">Toggle dropdown</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                      <a class="dropdown-item" href="{{ route('subscriptions.show', $subscription) }}">View</a>
                      <a class="dropdown-item"
                        href="{{ $subscription->timetable ? route('timetables.show', $subscription->timetable) : '#' }}">View
                        Timetable</a>
                      @if (Auth::check() && Auth::user()->hasRole(['admin', 'super_admin']))
                      <a class="dropdown-item" href="{{ route('subscriptions.edit', $subscription) }}">Edit</a>
                      <a class="dropdown-item" href="{{ route('subscriptions.destroy', $subscription) }}">Delete</a>
                      @endif
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <script>
            $(document).ready(function () {
              // $('#datatable-buttons').DataTable();
            });
          </script>
        </div>
      </div>
      <!-- end card -->
    </div>
    @endif

  </div>
  <!-- end row -->

</div> <!-- container-fluid -->

@endsection