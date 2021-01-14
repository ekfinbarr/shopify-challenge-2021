@extends('layouts.admin')

@section('title')
{{ trans('Notifications') }}
@endsection



@section('content')
<style>
  .message-list li .col-mail-1 {
    width: 100px;
  }

  .message-list li .col-mail-2 {
    left: 120px;
  }
</style>

<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-md-12">
      <nav aria-label="breadcrumb" class="float-right mt-1">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Notifications</li>
        </ol>
      </nav>
      <h4 class="mb-1 mt-0">@yield('title')</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="email-container bg-transparent">
        <!-- Left sidebar -->
        {{-- LEFT SIDEBAR --}}
        <!-- End Left sidebar -->

        <!-- start right sidebar -->
        {{-- <div class="inbox-rightbar"> --}}
        {{-- HEADER ACTION BUTTONS --}}
        <div class="btn-group mb-2">
          <button type="button" class="btn btn-light" data-toggle="tooltip" data-placement="top" title="Archive"><i
              class="uil uil-archive-alt"></i></button>
          <button type="button" class="btn btn-light" data-toggle="tooltip" data-placement="top" title="Mark as spam"><i
              class="uil uil-exclamation-octagon"></i></button>
          <button type="button" class="btn btn-light delete_all" data-url="{{ url('notifications/delete_all') }}"
            data-toggle="tooltip" data-placement="top" title="Delete"><i class="uil uil-trash-alt"></i></button>
        </div>
        <div class="btn-group mb-2" data-toggle="tooltip" data-placement="top" title="Labels">
          <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="uil uil-label"></i>
            <i class="uil uil-angle-down"></i>
          </button>
        </div>

        <div class="btn-group  mb-2" data-toggle="tooltip" data-placement="top" title="More Actions">
          <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <i class="uil uil-ellipsis-h font-size-13"></i> More
            <i class="uil uil-angle-down"></i>
          </button>
          <div class="dropdown-menu">
            <span class="dropdown-header">More Option :</span>
            <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a>
            <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
            <a class="dropdown-item" href="javascript: void(0);">Add Star</a>
            <a class="dropdown-item" href="javascript: void(0);">Mute</a>
          </div>
        </div>

        <div class="d-inline-block align-middle float-lg-right">
          <div class="row">
            <div class="col-8 align-self-center">
              Showing 1 - 20 of 289
            </div> <!-- end col-->
            <div class="col-4">
              <div class="btn-group float-right">
                <button type="button" class="btn btn-white btn-sm"><i class="uil uil-angle-left"></i></button>
                <button type="button" class="btn btn-primary btn-sm"><i class="uil uil-angle-right"></i></button>
              </div>
            </div> <!-- end col-->
          </div>
        </div>
        {{-- END HEADER ACTION BUTTONS --}}


        {{-- NOTIFICATIONS LIST --}}
        <div class="mt-2">
          <h5 class="mt-3 mb-2 font-size-16">Unread</h5>
          <ul class="message-list">

            @foreach ($user->unreadNotifications as $index => $un)
            <li class="unread">
              <div class="col-mail col-mail-1">
                <div class="checkbox-wrapper-mail">
                  <input type="checkbox" id="{{ 'unread-' . $index }}" class="sub_chk" data-id="{{$un->id}}">
                  <label for="{{ 'unread-' . $index }}" class="toggle"></label>
                </div>
                <span class="star-toggle uil uil-star text-warning"></span>
              </div>
              <div class="col-mail col-mail-2">
                @foreach ($un->data as $un_index => $un_data)
                @if ($un_index < 1) <a href="{{ route('notifications.show', $un) }}" class="subject">
                  {{ Str::limit($un_data, 120, '...') }}
                  </a>
                  @endif
                  @endforeach
                  <div class="date">{{ $un->created_at->diffForHumans() }}</div>
              </div>
            </li>
            @endforeach
          </ul>

          {{-- <h5 class="mt-4 mb-2 font-size-16">Important</h5>
                      <ul class="message-list">
                          <li>
                              <div class="col-mail col-mail-1">
                                  <div class="checkbox-wrapper-mail">
                                      <input type="checkbox" id="chk3">
                                      <label for="chk3" class="toggle"></label>
                                  </div>
                                  <span class="star-toggle uil uil-star"></span>
                                  <a href="#" class="title">Randy, me (5)</a>
                              </div>
                              <div class="col-mail col-mail-2">
                                  <a href="#" class="subject">Last pic over my village
                                      &nbsp;&ndash;&nbsp;
                                      <span class="teaser">Yeah i'd like that! Do you remember the
                                          video you showed me of your train ride between Colombo
                                          and Kandy? The one with the mountain view? I would love
                                          to see that one again!</span>
                                  </a>
                                  <div class="date">5:01 am</div>
                              </div>
                          </li>
                          <li>
                              <div class="col-mail col-mail-1">
                                  <div class="checkbox-wrapper-mail">
                                      <input type="checkbox" id="chk4">
                                      <label for="chk4" class="toggle"></label>
                                  </div>
                                  <span class="star-toggle uil uil-star text-warning"></span>
                                  <a href="#" class="title">Andrew Zimmer</a>
                              </div>
                              <div class="col-mail col-mail-2">
                                  <a href="#" class="subject">Mochila Beta: Subscription Confirmed
                                      &nbsp;&ndash;&nbsp; <span class="teaser">You've been
                                          confirmed! Welcome to the ruling class of the inbox. For
                                          your records, here is a copy of the information you
                                          submitted to us...</span>
                                  </a>
                                  <div class="date">Mar 8</div>
                              </div>
                          </li>
                      </ul> --}}

          <h5 class="mt-4 mb-2 font-size-16">Everything Else</h5>
          <ul class="message-list">
            @foreach ($user->readNotifications as $index => $un)
            <li class="unread">
              <div class="col-mail col-mail-1">
                <div class="checkbox-wrapper-mail">
                  <input type="checkbox" id="{{ 'read-' . $index }}" class="sub_chk" data-id="{{$un->id}}">
                  <label for="{{ 'read-' . $index }}" class="toggle"></label>
                </div>
                <span class="star-toggle uil uil-star text-warning"></span>
              </div>
              <div class="col-mail col-mail-2">
                @foreach ($un->data as $un_index => $un_data)
                @if ($un_index < 1) <a href="{{ route('notifications.show', $un) }}" class="subject">
                  {{ Str::limit($un_data, 120, '...') }}
                  </a>
                  @endif
                  @endforeach
                  <div class="date">{{ $un->created_at->diffForHumans() }}</div>
              </div>
            </li>
            @endforeach
          </ul>
        </div>
        {{-- END NOTIFICATIONS LIST --}}
        {{-- </div> --}}
        <!-- end right sidebar -->
        <div class="clearfix"></div>
      </div>
    </div> <!-- end Col -->
  </div><!-- End row -->
  <script type="text/javascript">
    $(document).ready(function () {


      $('#master').on('click', function (e) {
        if ($(this).is(':checked', true)) {
          $(".sub_chk").prop('checked', true);
        } else {
          $(".sub_chk").prop('checked', false);
        }
      });


      $('.delete_all').on('click', function (e) {


        var allVals = [];
        $(".sub_chk:checked").each(function () {
          allVals.push($(this).attr('data-id'));
        });


        if (allVals.length <= 0) {
          alert("Please select row.");
        } else {


          var check = confirm("Are you sure you want to delete this row?");
          if (check == true) {


            var join_selected_values = allVals.join(",");
            console.log("HEEEYYYY", window.location.href)
            $.ajax({
              url: window.location.href +'/delete_all',
              type: 'DELETE',
              headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: 'ids=' + join_selected_values,
              success: function (data) {
                if (data['success']) {
                  $(".sub_chk:checked").each(function () {
                    $(this).parents("tr").remove();
                  });
                  alert(data['success']);
                } else if (data['error']) {
                  alert(data['error']);
                } else {
                  alert('Whoops Something went wrong!!');
                }
              },
              error: function (data) {
                alert(data.responseText);
              }
            });


            $.each(allVals, function (index, value) {
              $('table tr').filter("[data-row-id='" + value + "']").remove();
            });
          }
        }
      });


      $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        onConfirm: function (event, element) {
          element.trigger('confirm');
        }
      });


      $(document).on('confirm', function (e) {
        var ele = e.target;
        e.preventDefault();


        $.ajax({
          url: ele.href,
          type: 'DELETE',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          success: function (data) {
            if (data['success']) {
              $("#" + data['tr']).slideUp("slow");
              alert(data['success']);
            } else if (data['error']) {
              alert(data['error']);
            } else {
              alert('Whoops Something went wrong!!');
            }
          },
          error: function (data) {
            alert(data.responseText);
          }
        });


        return false;
      });
    });
  </script>

</div> <!-- container-fluid -->

@endsection