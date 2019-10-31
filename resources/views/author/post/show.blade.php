@extends('backend.master.master')

@section('title', 'Post-create')

@push('css')

@endpush


@section('mainContent')

    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->

        <a href="{{ route('author.post.index') }}" class="btn btn-warning">BACK</a>


        @if($post->is_approved == false)
            <button type="button"  class="btn btn-default pull-right">
                <i class="material-icons">done</i>
                <span>Apporove</span>
            </button>
            @else
            <button type="button" class="btn btn-success pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Apporoved</span>
            </button>
            @endif

        <br>
        <br>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">

                        <div class="header">
                            <h2>
                                {{ $post->title }}
                                <small>Posted by  <strong><a href="">{{ $post->user->name }}</a></strong> on {{ $post->created_at->toFormattedDateString() }} </small>
                            </h2>

                        </div>

                        <div class="body">
                            {!! $post->body !!} {{--// this remove all tag in text--}}
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="card">
                        <div class="header" style="background: #fd9f01">
                            <h2>CATEGORIES</h2>
                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                                <span class="badge" style="background: #fd9f01">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="card">
                        <div class="header" style="background: #ef6c02">
                            <h2>TAG</h2>
                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                                <span class="badge" style="background: #ef6c02">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="card">
                        <div class="header" style="background: #c1380e">
                            <h2>IMAGE</h2>
                        </div>
                        <div class="body">
                            <img class="img img-thumbnail" width="350" src="{{ Storage::url('post/'.$post->image) }}" alt="">
                        </div>
                    </div>

                </div>
            </div>
        <!-- Vertical Layout | With Floating Label -->
    </div>

@endsection



@push('script')

@endpush
