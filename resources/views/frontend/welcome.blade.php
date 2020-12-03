@extends('frontend.master.master')

@section('title', 'Welcome')

@push('css')
    <link href="{{ asset('frontend/css/home/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/home/responsive.css') }}" rel="stylesheet">
    <style>
        .favorit-post {
            color: #F44336;
        }
    </style>

@endpush

@section('mainContent')

    <div class="main-slider">
        <div class="swiper-container position-static" data-slide-effect="slide" data-autoheight="false"
             data-swiper-speed="500" data-swiper-autoplay="10000" data-swiper-margin="0" data-swiper-slides-per-view="4"
             data-swiper-breakpoints="true" data-swiper-loop="true">
            <div class="swiper-wrapper">

                @foreach($categories as $category)
                    <div class="swiper-slide">
                        <a class="slider-category" href="{{ route('category.posts',$category->slug) }}">
                            <div class="blog-image"><img width="100%" src="{{ $category->slider_image }}"
                                                         alt="{{ $category->name }}"></div>

                            <div class="category">
                                <div class="display-table center-text">
                                    <div class="display-table-cell">
                                        <h3><b>{{ $category->name }}</b></h3>
                                    </div>
                                </div>
                            </div>

                        </a>
                    </div><!-- swiper-slide -->
                @endforeach


            </div><!-- swiper-wrapper -->

        </div><!-- swiper-container -->

    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">

            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        @foreach($posts as $post)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100">
                                    <div class="single-post post-style-1">

                                        <div class="blog-image"><img src="{{ asset('storage/post/'.$post->image) }}"
                                                                     alt=" {{ $post->title }} "></div>

                                        <a class="avatar" href="{{ route('profile.post',$post->user->username) }}"><img
                                                src="{{ asset('storage/profile/'.$post->user->image) }}"
                                                alt="Profile Image"></a>

                                        <div class="blog-info">

                                            <h4 class="title">
                                                <a href="{{ route('post.details', $post->slug) }}"><b></b> {{ $post->title }}
                                                </a>
                                            </h4>

                                            <ul class="post-footer">
                                                <li>
                                                    @guest
                                                        <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first', 'Info', {
                                                    closeButton: true,
                                                    progressBar: true,
                                                })"><i class="ion-heart"></i> {{ $post->favorite_to_users->count() }}
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0);"
                                                           onclick="document.getElementById('favorite-form-{{ $post->id }}').submit()"
                                                           class="{{ !auth()->user()->favorite_posts()->where('post_id',$post->id)->count() == 0 ? 'favorit-post' : '' }}"
                                                        >
                                                            <i class="ion-heart"></i>
                                                            {{ $post->favorite_to_users->count() }} </a>

                                                        <form id="favorite-form-{{ $post->id }}"
                                                              action="{{ route('post.favorite', $post->id) }}"
                                                              method="post" style="display: none">
                                                            @csrf
                                                        </form>
                                                    @endguest
                                                </li>
                                                <li><a href="#"><i
                                                            class="ion-chatbubble"></i>{{ $post->comments->count() }}
                                                    </a></li>
                                                <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                                            </ul>

                                        </div><!-- blog-info -->
                                    </div><!-- single-post -->
                                </div><!-- card -->
                            </div><!-- col-lg-4 col-md-6 -->
                        @endforeach
                    </div>

                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="container">
                        <div class="row">
                            <div class="card" style="width: 100%">
                                <div class="card-header text-left">
                                    <h4>Most Commented</h4>
                                    <small>What people are currently taking about.</small>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach($most_commented as $most_commented_post)
                                        <li class="list-group-item"><a
                                                href="{{ route('post.details', $most_commented_post->slug) }}">{{ Str::limit($most_commented_post->title, 30) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="card" style="width: 100%;">
                                <div class="card-header text-left">
                                    <h4>Most Active users</h4>
                                    <small>Users with most post written.</small>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach($most_active_users as $user)
                                        <li class="list-group-item"><a
                                                href="{{ route('profile.post',$user->username) }}">{{ Str::limit($user->name, 30) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="card" style="width: 100%;">
                                <div class="card-header text-left">
                                    <h4>Most Active in last month</h4>
                                    <small>Users with most post written in last month</small>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @foreach($most_active_users_last_month as $user)
                                        <li class="list-group-item"><a
                                                href="{{ route('profile.post',$user->username) }}">{{ Str::limit($user->name, 30) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>

        </div><!-- container -->
    </section><!-- section -->

@endsection




@push('script')

@endpush
