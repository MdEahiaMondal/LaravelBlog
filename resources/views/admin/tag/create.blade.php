@extends('backend.master.master')

@section('title', 'tag-create')

@push('css')


@endpush


@section('mainContent')

    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="header">
                        <h2>ADD NEW TAG</h2>
                    </div>

                    <div class="body">
                        <form action="{{ route('admin.tag.store') }}" method="post">
                            @csrf
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control">
                                    <label class="form-label">Tag Name here...</label>
                                </div>
                            </div>
                            <a class="btn btn-warning m-t-15 waves-effect" href="{{ route('admin.tag.index') }}">BACK</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vertical Layout | With Floating Label -->
    </div>

@endsection



@push('script')

@endpush
