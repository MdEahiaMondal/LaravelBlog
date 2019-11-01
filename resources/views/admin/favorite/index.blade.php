@extends('backend.master.master')

@section('title', 'Post')

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
                            ALL FAVORITE POST <span class="badge" style="background: #F44336;">{{ $posts->count() }}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th><i class="material-icons">favorite</i></th>
                                        <th><i class="material-icons">comment</i></th>
                                        <th><i class="material-icons">visibility</i></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>SI</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th><i class="material-icons">favorite</i></th>
                                        <th><i class="material-icons">comment</i></th>
                                        <th><i class="material-icons">visibility</i></th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                @foreach($posts as $key => $post)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ Str::limit($post->title, 15) }}</td>
                                        <td>{{ $post->user->name }}</td>
                                        <td>{{ $post->favorite_to_users->count() }}</td>
                                        <td>{{ $post->comments->count() }}</td>
                                        <td>{{ $post->view_count }}</td>

                                        <td class="text-center">

                                            <a class="btn btn-primary" title="Edit Post" href="">
                                                <i class="material-icons">visibility</i>
                                            </a>

                                            <button class="btn btn-danger waves-effect" type="button" onclick="removePost({{ $post->id }})">
                                                    <i class="material-icons">remove</i>
                                            </button>

                                            <form action="{{ route('post.favorite', $post->id) }}" id="remove-form-{{$post->id}}"
                                                  method="post" style="display: none;">
                                                    @csrf
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


        function approved(id) {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You want to approve this post !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, approved it!',
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
                    document.getElementById('approve-form').submit();

                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'The post remain pending :)',
                        'info'
                    )
                }
            })

        }



        function removePost(id) {

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
                   document.getElementById('remove-form-'+id).submit();

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
