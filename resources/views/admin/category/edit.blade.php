@extends('backend.master.master')

@section('title', 'Category-edit')

@push('css')


@endpush


@section('mainContent')

    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">

                    <div class="header">
                        <h2>EDIT CATEGORY</h2>
                    </div>

                    <div class="body">
                        <form action="{{ route('admin.category.update',$category->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name" name="name" value="{{ $category->name }}"  class="form-control">
                                    <label for="name" class="form-label">Category Name here...</label>
                                </div>
                            </div>


                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="file" id="image" name="image" class="form-control">
                                </div>
                            </div>

                            <a class="btn btn-warning m-t-15 waves-effect" href="{{ route('admin.category.index') }}">BACK</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
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
