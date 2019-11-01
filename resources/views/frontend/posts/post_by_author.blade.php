@extends('frontend.master.master')

@section('title')
    {{ $author->name }}
 @endsection

@push('css')
    <link href="{{ asset('frontend/css/auth_post/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/auth_post/responsive.css') }}" rel="stylesheet">

    <style>
        .favorit-post{
            color: #F44336;
        }


    </style>
@endpush

@section('mainContent')

    <div class="slider display-table center-text">
        <h1 class="title display-table-cell"><b>{{ $author->name }}</b></h1>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        @if($posts->count() != 0)
                            @foreach($posts as $post)
                                <div class="col-md-6 col-sm-12">
                                    <div class="card h-100">
                                        <div class="single-post post-style-1">

                                            <div class="blog-image"><img src="{{ asset('storage/post/'.$post->image) }}" alt=" {{ $post->title }} "></div>

                                            <a class="avatar" href="{{ route('profile.post',$post->user->username) }}"><img src="{{ asset('storage/profile/'.$post->user->image) }}" alt="Profile Image"></a>

                                            <div class="blog-info">

                                                <h4 class="title">
                                                    <a href="{{ route('post.details', $post->slug) }}"><b></b> {{ $post->title }} </a>
                                                </h4>

                                                <ul class="post-footer">
                                                    <li>
                                                        @guest
                                                            <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first', 'Info', {
                                                    closeButton: true,
                                                    progressBar: true,
                                                })"><i class="ion-heart"></i> {{ $post->favorite_to_users->count() }} </a>
                                                        @else
                                                            <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit()"
                                                               class="{{ !auth()->user()->favorite_posts()->where('post_id',$post->id)->count() == 0 ? 'favorit-post' : '' }}"
                                                            >
                                                                <i class="ion-heart"></i>
                                                                {{ $post->favorite_to_users->count() }} </a>

                                                            <form id="favorite-form-{{ $post->id }}" action="{{ route('post.favorite', $post->id) }}"
                                                                  method="post" style="display: none">
                                                                @csrf
                                                            </form>
                                                        @endguest
                                                    </li>
                                                    <li><a href="#"><i class="ion-chatbubble"></i> {{ $post->comments->count() }} </a></li>
                                                    <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                                                </ul>

                                            </div><!-- blog-info -->
                                        </div><!-- single-post -->
                                    </div><!-- card -->
                                </div><!-- col-lg-4 col-md-6 -->
                            @endforeach
                        @else
                            <div class="col-sm-12">
                                <p class="text-center">There is no post on this category</p>
                            </div>
                        @endif

                    </div><!-- row -->

                    <p>{{ $posts->links() }}</p>
                    {{--<a class="load-more-btn" href="#"><b>LOAD MORE</b></a>--}}

                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 ">

                    <div class="single-post info-area ">

                        <div class="about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <p><img width="200" height="300" src="{{ asset('storage/profile/'.$author->image) }}" alt="Profile Image">  {{ $author->name }}</p> <br>
                            <p>{{ $author->about }}</p> <br>
                            <strong>Author Since : {{ $author->created_at->toDateString() }}</strong> <br>
                            <strong> Total Posts : {{$author->posts->count()}} </strong>
                        </div>
                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- section -->




@endsection




@push('script')

@endpush
