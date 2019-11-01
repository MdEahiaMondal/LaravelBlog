@extends('backend.master.master')

@section('title', 'Authors')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{ asset('backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
@endpush


@section('mainContent')
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL AUTHORS <span class="badge" style="background: #F44336;">{{ $authors->count() }}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>SI</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Posts</th>
                                    <th>Favorite Posts</th>
                                    <th>Comments</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>SI</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Posts</th>
                                    <th>Favorite Posts</th>
                                    <th>Comments</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($authors as $key => $author)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $author->name }}</td>
                                        <td>{{ $author->email }}</td>
                                        <td>{{ $author->posts_count }}</td>
                                        <td>{{ $author->favorite_posts_count }}</td>
                                        <td>{{ $author->comments_count }}</td>
                                        <td>{{ $author->created_at->toDateString() }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger waves-effect" type="button" onclick="deleteAuthor({{ $author->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>

                                            <form action="{{ route('admin.author.destroy',$author->id) }}" id="delete-form-{{$author->id}}"
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
        function deleteAuthor(id) {

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
