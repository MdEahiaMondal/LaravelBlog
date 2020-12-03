@extends('backend.master.master')

@section('title', 'Category-create')

@push('css')


@endpush


@section('mainContent')

    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="header">
                        <h2>ADD NEW Category</h2>
                    </div>

                    <div class="body">
                        <form action="{{ route('admin.category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label for="name" class="form-label">Category Name here...</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"  class="form-control">
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label for="">Background Image</label>
                                    <input type="file" id="background_image" name="background_image" class="form-control">
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label for="">Slider Image</label>
                                    <input type="file" id="image" name="slider_image" class="form-control">
                                </div>
                            </div>

                            <a class="btn btn-warning m-t-15 waves-effect" href="{{ route('admin.category.index') }}">BACK</a>
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
