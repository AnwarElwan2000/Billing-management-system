@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">المستخدم</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل
                    الملف الشخصي</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        @if (session()->has('update_profile'))
            <script>
                window.onload = function() {
                    notif({
                        msg: "تم تعديل الملف الشخصي بنجاح",
                        type: 'success'
                    })
                }
            </script>
        @endif
        <!-- Col -->
        <div class="col-lg-4">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                            <div class="main-img-user profile-user">
                                @foreach (Auth::User()->roles_name as $roles)
                                    @if (Auth::User()->upload_img !== null && $roles == 'owner')
                                        <img alt="" src="{{ asset('owner_img/' . Auth::User()->upload_img) }}"><a
                                            class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                    @elseif(Auth::User()->upload_img !== null && $roles == 'user')
                                        <img alt="" src="{{ asset('user_img/' . Auth::User()->upload_img) }}"><a
                                            class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                    @else
                                        <img alt="" src="{{ URL::asset('assets/img/faces/6.jpg') }}"><a
                                            class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                    @endif
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between mg-b-20">
                                <div>
                                    <h5 class="main-profile-name">{{ Auth::User()->name }}</h5>
                                    <p class="main-profile-name-text">{{ Auth::User()->email }}</p>
                                </div>
                            </div>
                            <h6>
                                @if (Auth::User()->Status == 'مفعل')
                                    <span class="label text-success">
                                        <div class="dot-label bg-success ml-1"></div>{{ Auth::User()->Status }}
                                    </span>
                                @else
                                    <span class="label text-danger">
                                        <div class="dot-label bg-danger ml-1"></div>{{ Auth::User()->Status }}
                                    </span>
                                @endif
                            </h6>
                            <h5>
                                @foreach (Auth::User()->roles_name as $roles)
                                    {{ $roles }}
                                @endforeach
                            </h5>
                            <div class="main-profile-bio">
                                pleasure rationally encounter but because pursue consequences that are extremely
                                painful.occur in which toil and pain can procure him some great pleasure.. <a
                                    href="">More</a>
                            </div><!-- main-profile-bio -->
                            <div class="row">
                                <div class="col-md-4 col mb20">
                                    <h5>947</h5>
                                    <h6 class="text-small text-muted mb-0">Followers</h6>
                                </div>
                                <div class="col-md-4 col mb20">
                                    <h5>583</h5>
                                    <h6 class="text-small text-muted mb-0">Tweets</h6>
                                </div>
                                <div class="col-md-4 col mb20">
                                    <h5>48</h5>
                                    <h6 class="text-small text-muted mb-0">Posts</h6>
                                </div>
                            </div>
                            <hr class="mg-y-30">
                            <label class="main-content-label tx-13 mg-b-20">Social</label>
                            <div class="main-profile-social-list">
                                <div class="media">
                                    <div class="media-icon bg-primary-transparent text-primary">
                                        <i class="icon ion-logo-github"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Github</span> <a href="">github.com/spruko</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-success-transparent text-success">
                                        <i class="icon ion-logo-twitter"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Twitter</span> <a href="">twitter.com/spruko.me</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-info-transparent text-info">
                                        <i class="icon ion-logo-linkedin"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>Linkedin</span> <a href="">linkedin.com/in/spruko</a>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-icon bg-danger-transparent text-danger">
                                        <i class="icon ion-md-link"></i>
                                    </div>
                                    <div class="media-body">
                                        <span>My Portfolio</span> <a href="">spruko.com/</a>
                                    </div>
                                </div>
                            </div>
                            <hr class="mg-y-30">
                            <h6>Skills</h6>
                            <div class="skill-bar mb-4 clearfix mt-3">
                                <span>HTML5 / CSS3</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-primary-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 85%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                            <div class="skill-bar mb-4 clearfix">
                                <span>Javascript</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-danger-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 89%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                            <div class="skill-bar mb-4 clearfix">
                                <span>Bootstrap</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-success-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 80%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                            <div class="skill-bar clearfix">
                                <span>Coffee</span>
                                <div class="progress mt-2">
                                    <div class="progress-bar bg-info-gradient" role="progressbar" aria-valuenow="85"
                                        aria-valuemin="0" aria-valuemax="100" style="width: 95%"></div>
                                </div>
                            </div>
                            <!--skill bar-->
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="main-content-label tx-13 mg-b-25">
                        Conatct
                    </div>
                    <div class="main-profile-contact-list">
                        <div class="media">
                            <div class="media-icon bg-primary-transparent text-primary">
                                <i class="icon ion-md-phone-portrait"></i>
                            </div>
                            <div class="media-body">
                                <span>Mobile</span>
                                <div>
                                    +245 354 654
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-success-transparent text-success">
                                <i class="icon ion-logo-slack"></i>
                            </div>
                            <div class="media-body">
                                <span>Slack</span>
                                <div>
                                    @spruko.w
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-icon bg-info-transparent text-info">
                                <i class="icon ion-md-locate"></i>
                            </div>
                            <div class="media-body">
                                <span>Current Address</span>
                                <div>
                                    San Francisco, CA
                                </div>
                            </div>
                        </div>
                    </div><!-- main-profile-contact-list -->
                </div>
            </div>
        </div>

        <!-- Col -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4 main-content-label">Edit Profile</div>
                    <form action="{{ route('profile.update') }}" method="post" class="form-horizontal"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group ">
                            <div class="mb-4 main-content-label">User Data</div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Name</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="hidden" name="user_id" value="{{ Auth::User()->id }}">
                                        <input type="text" required name="name" class="form-control"
                                            placeholder="edit name" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Email</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" required name="email" class="form-control"
                                            placeholder="edit email" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Password</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" required name="password" class="form-control"
                                            placeholder="edit password" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Upload Image</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="file" name="img" class="form-control btn btn-primary"
                                            placeholder="edit image" value="">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-left">
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light">Update
                                Profile</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Col -->
        </div>
        <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
