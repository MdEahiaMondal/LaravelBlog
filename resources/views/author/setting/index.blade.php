@extends('backend.master.master')

@section('title', 'Seetings')

@push('css')


@endpush


@section('mainContent')

    <div class="container">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        SETTINGS
                    </h2>
                </div>
                <div class="body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">

                        <li role="presentation">
                            <a href="#profile_with_icon_title" data-toggle="tab">
                                <i class="material-icons">face</i> UPDATE PROFILE
                            </a>
                        </li>

                        <li role="presentation" class="active">
                            <a href="#password_change_with_icon_title" data-toggle="tab">
                                <i class="material-icons">edit</i> PASSWORD
                            </a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="profile_with_icon_title">

                           <form class="form-horizontal" action="{{ route('author.profile.update',auth()->id()) }}" method="post" enctype="multipart/form-data">
                               @csrf

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="name">Name : </label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" class="form-control" placeholder="Enter your Name">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="email">Email Address : </label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" class="form-control" placeholder="Enter your email address">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               <div class="row clearfix">
                                   <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                       <label for="image">Profile Image : </label>
                                   </div>
                                   <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                       <div class="form-group">
                                           <div class="form-line">
                                               <input type="file" id="image" name="image"  class="form-control">
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="row clearfix">
                                   <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                       <label for="image">About : </label>
                                   </div>
                                   <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                       <div class="form-group">
                                           <div class="form-line">
                                               <textarea name="about" id="" class="form-control" rows="5">
                                                   {{ auth()->user()->about }}
                                               </textarea>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                    </div>
                                </div>
                           </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade in active" id="password_change_with_icon_title">
                            <form class="form-horizontal" action="{{ route('author.password.update',auth()->id()) }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="currentPassword">Current Password : </label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="password" id="currentPassword" name="currentPassword"  class="form-control" placeholder="Enter Current Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password">New Password : </label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="password" id="password" name="password"  class="form-control" placeholder="Enter New Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                        <label for="password_confirmation">Confirm Password  : </label>
                                    </div>
                                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Enter Confirm New Password">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@push('script')

@endpush
