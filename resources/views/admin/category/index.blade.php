@extends('backend.master.master')

@section('title', 'Category')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush


@section('mainContent')
    <div class="container-fluid">
        <div class="block-header">
            <h2 >
                <a class="btn btn-primary" href="{{ route('admin.category.create') }}">
                    <i class="material-icons">add</i>
                    <span> Add New Category</span>
                </a>
            </h2>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            CATEGORY TABLE <span class="badge" style="background: #F44336">{{ $categories->count() }}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>SI</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Post count</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SI</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Post count</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td width="50%"><img width="50%" src="{{ $category->background_image }}" alt=""></td>
                                        <td> <span class="badge" style="background: #F44336;">{{ $category->posts->count() }}</span> </td>
                                        <td class="text-center">
                                            <a class="btn btn-primary" title="Edit Item" href="{{ route('admin.category.edit',$category->id) }}">
                                                <i class="material-icons">edit</i>
                                            </a>

                                            <button class="btn btn-danger waves-effect" type="button" onclick="deleteCategory({{ $category->id }})">
                                                    <i class="material-icons">delete</i>
                                            </button>

                                            <form action="{{ route('admin.category.destroy', $category->id) }}" id="delete-form-{{$category->id}}"
                                                  method="post" style="display: none;">
                                                    @csrf
                                                @method('DELETE')

                                            </form>



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
        <!-- #END# Exportable Table -->
    </div>
@endsection



@push('script')

    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="{{ asset('backend/') }}/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <script src="{{asset('backend/')}}/js/pages/tables/jquery-datatable.js"></script>

    {{--// for tag delete--}}
    <script>
        function deleteCategory(id) {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                   /* swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )*/
                   event.preventDefault();
                   document.getElementById('delete-form-'+id).submit();

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })

        }
    </script>

@endpush
