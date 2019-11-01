@extends('frontend.master.master')

@section('title', 'All Posts')

@push('css')
    <link href="{{ asset('frontend/css/posts/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/posts/responsive.css') }}" rel="stylesheet">

    <style>
        .favorit-post{
            color: #F44336;
        }
    </style>
@endpush

@section('mainContent')

        <div class="slider display-table center-text">
            <h1 class="title display-table-cell"><b> ALL POST </b></h1>
        </div><!-- slider -->

        <section class="blog-area section">
            <div class="container">

                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ asset('storage/post/'.$post->image) }}" alt=" {{ $post->title }} "></div>

                                <a class="avatar" href="#"><img src="{{ asset('storage/profile/'.$post->user->image) }}" alt="Profile Image"></a>

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
                                        <li><a href="#"><i class="ion-chatbubble"></i>6</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                    @endforeach
                </div><!-- row -->

                <p> {{ $posts->links() }} </p>
               {{-- <a class="load-more-btn" href="#"><b>LOAD MORE</b></a>--}}

            </div><!-- container -->
        </section><!-- section -->





@endsection




@push('script')

@endpush
