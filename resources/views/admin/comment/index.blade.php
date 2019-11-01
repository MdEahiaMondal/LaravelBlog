@extends('backend.master.master')

@section('title', 'Comments')

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
                            ALL Comments <span class="badge" style="background: #F44336;">{{ $comments->count() }}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th class="text-center">Comments Info</th>
                                        <th class="text-center">Posts Info</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Comments Info</th>
                                        <th class="text-center">Posts Info</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                @foreach($comments as $key => $comment)
                                    <tr>
                                       <td>
                                           <div class="media">
                                               <div class="media-left">
                                                   <a href="">
                                                       <img class="media-object" width="64" height="64" src="{{ asset('storage/profile/'.$comment->user->image) }}" alt="">
                                                   </a>
                                               </div>

                                               <div class="media-body">
                                                   <h4 class="media-heading">{{ $comment->user->name }}
                                                       <small> {{ $comment->created_at->diffForHumans() }} </small>
                                                   </h4>
                                                   <p>{{ $comment->body }}</p>
                                                   <a target="_blank" href="{{ route('post.details',$comment->post->slug.'#comments') }}">Replay</a>
                                               </div>
                                           </div>
                                       </td>

                                        <td>
                                           <div class="media">
                                               <div class="media-right">
                                                   <a target="_blank" href="{{ route('post.details',$comment->post->slug) }}">
                                                       <img class="media-object" width="64" height="64" src="{{ asset('storage/post/'.$comment->post->image) }}" alt="">
                                                   </a>
                                               </div>

                                               <div class="media-body">
                                                   <a target="_blank" href="{{ route('post.details',$comment->post->slug) }}">
                                                       <h4 class="media-heading">{{ Str::limit($comment->post->title, '40') }}
                                                           <small> {{ $comment->created_at->diffForHumans() }} </small>
                                                       </h4>
                                                   </a>
                                                   <p> by <strong>{{ $comment->post->user->name }}</strong></p>
                                               </div>
                                           </div>
                                       </td>


                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="deleteComment({{ $comment->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>

                                            <form action="{{ route('admin.comment.destroy', $comment->id) }}"
                                                  method="post" id="delete-form-{{$comment->id}}" style="display: none">
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

        function deleteComment(id) {

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
