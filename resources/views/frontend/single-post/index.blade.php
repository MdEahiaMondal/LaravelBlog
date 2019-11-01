@extends('frontend.master.master')

@section('title', $post->title)

@push('css')
    <link href="{{ asset('frontend/css/single-post/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('frontend/css/single-post/responsive.css') }}" rel="stylesheet">

    <style>
        .favorit-post{
            color: #F44336;
        }

        .header-bg{
            background-image: url(" {{ asset('storage/post/'.$post->image) }} ");
        }
    </style>


@endpush

@section('mainContent')

    <div class="slider header-bg">

    </div><!-- slider -->

    <section class="post-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-9 col-md-12 no-right-padding">

                    <div class="main-post">

                        <div class="blog-post-inner">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="{{ route('profile.post',$post->user->username) }}"><img src="{{ asset('storage/profile/'.$post->user->image) }}" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>{{ $post->user->name }}</b></a>
                                    <h6 class="date">on {{ $post->created_at->diffForHumans() }}</h6>
                                </div>

                            </div><!-- post-info -->

                            <h3 class="title"><a href="#"><b> {{ $post->title }} </b></a></h3>

                            <p class="para">{!! html_entity_decode($post->body) !!}</p>
                        </div><!-- blog-post-inner -->

                        <div class="post-icons-area">
                            <ul class="post-icons">

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

                            <ul class="icons">
                                <li>SHARE : </li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-3 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>ABOUT AUTHOR</b></h4>
                            <p>{{ $post->user->about }}</p>
                        </div>


                        <div class="tag-area">
                            <h4 class="title"><b>CATEGORY</b></h4>
                            <ul class="mb-4">
                                @if($post->categories->count() != 0)
                                    @foreach($post->categories as $category)
                                        <li><a href="{{ route('category.posts', $category->slug) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                    @else
                                    <li>There is no category</li>
                                 @endif
                            </ul>
                        </div>

                        <div class="tag-area">
                            <h4 class="title"><b>TAG CLOUD</b></h4>
                            <ul>

                                @if($post->tags->count() != 0)
                                    @foreach($post->tags as $tag)
                                        <li><a href="{{ route('tag.posts', $tag->slug) }}">{{ $tag->name }}</a></li>
                                    @endforeach
                                @else
                                    <li>There is no tag</li>
                                @endif

                            </ul>
                        </div>

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">

                @foreach($randomPosts as $randomPost)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ asset('storage/post/'.$randomPost->image) }}" alt="Post Image"></div>

                                <a class="avatar" href="{{ route('profile.post',$randomPost->user->username) }}"><img src="{{ asset('storage/profile/'.$randomPost->user->image) }}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{ route('post.details',$randomPost->slug) }}"><b> {{ $randomPost->title }} </b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                                <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first', 'Info', {
                                                    closeButton: true,
                                                    progressBar: true,
                                                })"><i class="ion-heart"></i> {{ $randomPost->favorite_to_users->count() }} </a>
                                            @else
                                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $randomPost->id }}').submit()"
                                                   class="{{ !auth()->user()->favorite_posts()->where('post_id',$randomPost->id)->count() == 0 ? 'favorit-post' : '' }}"
                                                >
                                                    <i class="ion-heart"></i>
                                                    {{ $randomPost->favorite_to_users->count() }} </a>

                                                <form id="favorite-form-{{ $randomPost->id }}" action="{{ route('post.favorite', $randomPost->id) }}"
                                                      method="post" style="display: none">
                                                    @csrf
                                                </form>
                                            @endguest
                                        </li>
                                        <li><a href="#"><i class="ion-chatbubble"></i> {{ $randomPost->comments->count() }} </a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{ $randomPost->view_count }}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-md-6 col-sm-12 -->

                @endforeach


            </div><!-- row -->

        </div><!-- container -->
    </section>

    <section class="comment-section">
        <div class="container">
            <h4><b>POST COMMENT</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        @guest
                            <p>For post a new comment. You need to login first. <a style="color: #126bfd" href="{{ route('login') }}">Login</a> </p>
                            @else
                            <form method="post" action="{{ route('comment.store', $post->id) }}">
                                @csrf
                                <div class="row">

                                    <div class="col-sm-12">
									<textarea name="body" rows="2" class="text-area-messge form-control"
                                              placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                                    </div><!-- col-sm-12 -->

                                    <div class="col-sm-12">
                                        <button class="submit-btn" type="submit" id="form-submit"><b>POST COMMENT</b></button>
                                    </div><!-- col-sm-12 -->

                                </div><!-- row -->
                            </form>
                        @endguest
                    </div><!-- comment-form -->

                    <h4><b>COMMENTS( {{ $post->comments()->count() }} )</b></h4>

                    <div class="commnets-area">

                        @if($post->comments()->count() > 0)
                            @foreach($post->comments as $comment)
                                <div class="comment">

                                    <div class="post-info">

                                        <div class="left-area">
                                            <a class="avatar" href="#"><img src="{{ asset('storage/profile/'.$comment->user->image) }}" alt="Profile Image"></a>
                                        </div>

                                        <div class="middle-area">
                                            <a class="name" href="#"><b>{{ $comment->user->name }}</b></a>
                                            <h6 class="date">on {{ $comment->created_at->diffForHumans() }}</h6>
                                        </div>

                                        <div class="right-area">
                                            <h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
                                        </div>

                                    </div><!-- post-info -->

                                    <p>{{ $comment->body }}</p>

                                </div>
                            @endforeach
                                <a class="more-comment-btn" href="#"><b>VIEW MORE COMMENTS</b></a>
                            @else
                            <p>There is a no comment on this post</p>
                         @endif



                   {{--     <div class="comment">
                            <h5 class="reply-for">Reply for <a href="#"><b>Katy Lui</b></a></h5>

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img src="images/avatar-1-120x120.jpg" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#"><b>Katy Liu</b></a>
                                    <h6 class="date">on Sep 29, 2017 at 9:48 am</h6>
                                </div>

                                <div class="right-area">
                                    <h5 class="reply-btn" ><a href="#"><b>REPLY</b></a></h5>
                                </div>

                            </div><!-- post-info -->

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur
                                Ut enim ad minim veniam</p>

                        </div>--}}
                    </div><!-- commnets-area -->


                </div><!-- col-lg-8 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section>

@endsection




@push('script')

@endpush
