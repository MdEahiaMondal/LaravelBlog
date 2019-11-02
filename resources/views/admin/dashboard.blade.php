@extends('backend.master.master')

@push('css')

@endpush


@section('mainContent')
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>

        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-pink hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">playlist_add_check</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL POST</div>
                        <div class="number count-to" data-from="0" data-to="{{ $posts->count() }}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">favorite</i>
                    </div>
                    <div class="content">
                        <div class="text">POPULAR POST</div>
                        <div class="number count-to" data-from="0" data-to="{{ $popular_posts->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">favorite</i>
                    </div>
                    <div class="content">
                        <div class="text">FAVORITE POST</div>
                        <div class="number count-to" data-from="0" data-to="{{ auth()->user()->favorite_posts->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">library_books</i>
                    </div>
                    <div class="content">
                        <div class="text">PRNDING POST</div>
                        <div class="number count-to" data-from="0" data-to="{{ $total_pending }}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <!-- Task Info -->
                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div class="info-box bg-orange hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL COMMENT</div>
                            <div class="number count-to" data-from="0" data-to="{{ $comments }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    <div class="info-box bg-orange hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">label</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL CATEGORY</div>
                            <div class="number count-to" data-from="0" data-to="{{ $category_count }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">label</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL TAG</div>
                            <div class="number count-to" data-from="0" data-to="{{ $tag_count }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">visibility</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL VIEW</div>
                            <div class="number count-to" data-from="0" data-to="{{ $total_post_view }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">TOTAL AUTHOR</div>
                            <div class="number count-to" data-from="0" data-to="{{ $total_authors }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW AUTHOR</div>
                            <div class="number count-to" data-from="0" data-to="{{ $new_authors_today }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person_add</i>
                        </div>
                        <div class="content">
                            <div class="text">ACTIVE AUTHOR</div>
                            <div class="number count-to" data-from="0" data-to="{{ $active_authors->count() }}" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                <div class="card">
                    <div class="header">
                        <h2>MOST POPULAR POST  <strong class="badge" style="background-color: #db4437">{{ $popular_posts->count() }}</strong></h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th>Rank List</th>
                                    <th>TITLE</th>
                                    <th>Views</th>
                                    <th>Favorite</th>
                                    <th>Comments</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($popular_posts as $key => $popular)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ Str::limit($popular->title, 20) }}</td>
                                        <td>{{ $popular->view_count }}</td>
                                        <td>{{ $popular->favorite_to_users_count }}</td>
                                        <td>{{ $popular->comments_count }}</td>
                                        <td>
                                            @if($popular->status == true)
                                                <span class="label label-success">Publish</span>
                                            @else
                                                <span class="label label-danger">Pending</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a target="_blank" class="label label-primary" href="{{ route('post.details',$popular->slug) }}">View</a>
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            </div>

        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>TOP 10 POPULAR AUTHORS <strong class="badge" style="background-color: #db4437">{{ $active_authors->count() }}</strong> </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th>Rank List</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Posts</th>
                                    <th>Favorite Post</th>
                                    <th>Comments</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($active_authors as $key => $active_author)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $active_author->name }}</td>
                                        <td>{{ $active_author->email }}</td>
                                        <td>{{ $active_author->posts->count() }}</td>
                                        <td>{{ $active_author->favorite_posts_count }}</td>
                                        <td>{{ $active_author->comments_count }}</td>
                                        <td>
                                            <a target="_blank" class="label label-primary" href="{{ route('profile.post',$active_author->username) }}">View</a>
                                        </td>

                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection



@push('script')

    <script src="{{ asset('backend/js/pages/index.js') }}"></script>

@endpush
