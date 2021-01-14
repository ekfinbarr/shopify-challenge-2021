@extends('layouts.admin')

@section('title')
View User Profile
@endsection



@section('content')

<!-- Start Content-->
@if (isset($user))
<!-- Start Content-->
<div class="container-fluid">
  <div class="row page-title">
    <div class="col-md-12">
      <nav aria-label="breadcrumb" class="float-right mt-1">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ trans('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ trans('Users') }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ trans('Profile') }}</li>
        </ol>
      </nav>
      <h4 class="mb-1 mt-0">Profile</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="text-center mt-3">
            <img src="{{ asset('assets/images/users/avatar-7.jpg') }}" alt="" class="avatar-lg rounded-circle" />
            <h5 class="mt-2 mb-0">{{ $user->name ? $user->name : '' }}</h5>
            {{-- <h6 class="text-muted font-weight-normal mt-2 mb-0">User Experience Specialist
            </h6>
            <h6 class="text-muted font-weight-normal mt-1 mb-4">San Francisco, CA</h6> --}}

            {{-- <button type="button" class="btn btn-primary btn-sm mr-1">Follow</button>
            <button type="button" class="btn btn-white btn-sm">Message</button> --}}
          </div>

          <!-- profile  -->
          {{-- <div class="mt-5 pt-2 border-top">
            <h4 class="mb-3 font-size-15">About</h4>
            <p class="text-muted mb-4">Hi I'm Shreyu. I am user experience and user
              interface designer.
              I have been working on UI & UX since last 10 years.</p>
          </div> --}}
          <div class="mt-3 pt-2 border-top">
            <h4 class="mb-3 font-size-15">Contact Information</h4>
            <div class="table-responsive">
              <table class="table table-borderless mb-0 text-muted">
                <tbody>
                  <tr>
                    <th scope="row">Email</th>
                    <td>{{ $user->email ? $user->email : '' }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Phone</th>
                    <td>{{ $user->phone ? $user->phone : '' }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- end card -->

    </div>

    <div class="col-lg-9">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-pills navtab-bg nav-justified" id="pills-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="pills-activity-tab" data-toggle="pill" href="#pills-activity" role="tab"
                aria-controls="pills-activity" aria-selected="true">
                Activity
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="classes-tab" data-toggle="pill" href="#classes" role="tab"
                aria-controls="classes" aria-selected="false">
                Classes
              </a>
            </li>
            @if(Auth::user()->hasRole(['admin', 'super_admin']))
            <li class="nav-item">
              <a class="nav-link" id="roles-tab" data-toggle="pill" href="#roles" role="tab"
                aria-controls="roles" aria-selected="false">
                Roles/Permissions
              </a>
            </li>
            @endif
          </ul>

          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-activity" role="tabpanel"
              aria-labelledby="pills-activity-tab">
              
              <h5 class="mt-3">This Week</h5>
              <div class="left-timeline mt-3 mb-3 pl-4">
                <ul class="list-unstyled events mb-0">
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            02 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">Designing
                            Shreyu Admin</h6>
                          <p class="text-muted font-size-14">Shreyu Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            21 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">UX and UI for
                            Ubold Admin</h6>
                          <p class="text-muted font-size-14">Ubold Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            22 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">UX and UI for
                            Hyper Admin</h6>
                          <p class="text-muted font-size-14">Hyper Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>

              <h5 class="mt-4">Last Week</h5>
              <div class="left-timeline mt-3 pl-4">
                <ul class="list-unstyled events mb-0">
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            02 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">Designing
                            Shreyu Admin</h6>
                          <p class="text-muted font-size-14">Shreyu Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            21 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">UX and UI for
                            Ubold Admin</h6>
                          <p class="text-muted font-size-14">Ubold Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            22 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">UX and UI for
                            Hyper Admin</h6>
                          <p class="text-muted font-size-14">Hyper Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>

              <h5 class="mt-4">Last Month</h5>
              <div class="left-timeline mt-3 pl-4">
                <ul class="list-unstyled events mb-0">
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            02 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">Designing
                            Shreyu Admin</h6>
                          <p class="text-muted font-size-14">Shreyu Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            21 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">UX and UI for
                            Ubold Admin</h6>
                          <p class="text-muted font-size-14">Ubold Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li class="event-list">
                    <div class="pb-4">
                      <div class="media">
                        <div class="event-date text-center mr-4">
                          <div class="bg-soft-primary p-1 rounded text-primary font-size-14">
                            22 hours ago</div>
                        </div>
                        <div class="media-body">
                          <h6 class="font-size-15 mt-0 mb-1">UX and UI for
                            Hyper Admin</h6>
                          <p class="text-muted font-size-14">Hyper Admin - A
                            responsive admin and dashboard template</p>
                        </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>


            <div class="tab-pane fade" id="classes" role="tabpanel" aria-labelledby="classes-tab">

              <h5 class="mt-3">Classes</h5>

              <div class="row mt-3">

                @if (isset($user->classes))
                  @foreach ($user->classes as $uclass)
                    <div class="col-xl-4 col-lg-6">
                      <div class="card border">

                        <div class="card-body">
                          <div class="badge badge-success float-right">Completed</div>
                          <p class="text-success text-uppercase font-size-12 mb-2">Web
                            Design</p>
                          <h5><a href="#" class="text-dark">
                            {{ isset($uclass->label) ? $uclass->label : '' }}
                          </a>
                          </h5>
                          <p class="text-muted mb-4">
                            {{ isset($uclass->school) ? $uclass->school->name : ''}}
                          </p>
                        </div>
                      </div>
                      <!-- end card -->
                    </div>
                  @endforeach
                @endif
                
              </div>
              <!-- end row -->
            </div>

            @if(Auth::user()->hasRole(['admin', 'super_admin']))
            <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">

              <h5 class="mt-3">{{ $user->name . "'s" }} Roles & Permissions</h5>

              <div class="row mt-3">

                @if (isset($user->roles))
                  @foreach ($user->roles as $role)
                    <div class="col-xl-4 col-lg-6">
                      <div class="card border">

                        <div class="card-body">
                          <h5>
                          <a href="{{ route('roles.show', $role) }}" class="text-dark text-uppercase">
                              {{ isset($role->label) ? $role->label : '' }}
                            </a>
                          </h5>
                          <p class="text-muted mb-4">
                            
                            @if (isset($role->permissions))
                              @foreach ($role->permissions as $p)
                              <div class="badge badge-success m-1 row">
                                {{ $p->label }}
                              </div>
                              @endforeach
                            @endif
                          </p>
                        </div>
                      </div>
                      <!-- end card -->
                    </div>
                  @endforeach
                @endif
                
              </div>
              <!-- end row -->


              <h5 class="mt-3">Manage {{ $user->name . "'s " }} roles</h5>
              <div class="row">
                <div class="col-12">
                  <div class="card border">

                    <div class="card-body">
                      <form action="{{ route('assign_user_role', $user) }}" method="post">
                        @csrf
                        @method('POST')
                      <input type="hidden" name="user_id" value="{{ $user->id }}">
                        {{-- <div class="form-group">
                          <div class="custom-control custom-radio mb-2">
                            <button type="submit" class="btn btn-primary">Submit Update</button>
                          </div>
                        </div> --}}
          
                        <hr class="mb-5">
                        
                        @if (isset($roles))
                          @foreach ($roles as $r)
                          <div class="mt-3 col-lg-3">
                            <div class="custom-control custom-checkbox mb-2 col-3">
                            <input type="checkbox" class="custom-control-input" name="roles[]" value="{{ $r->id }}" id="{{ 'role-'.$r->id }}" {{ $user->hasRole($r->name) ? 'checked' : '' }}>
                              <label class="custom-control-label" for="{{ 'role-'.$r->id }}">
                                {{ $r->label ? $r->label : ''}}
                              </label>
                            </div> 
                          </div>
                          @endforeach  
                        @endif
                          
                        <hr class="mt-5 mb-3">
          
                        <div class="form-group mt-2 mb-10">
                          <div class="custom-control custom-radio mb-2">
                            <button type="submit" class="btn btn-soft-primary btn-sm">Submit Update</button>
                          </div>
                        </div>
          
                      </form>
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
  </div>
  <!-- end row -->
</div> <!-- container-fluid -->

@endif


@endsection