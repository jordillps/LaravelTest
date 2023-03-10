@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
@endpush

@section('content')

<div class="content-wrapper">
    
    @include('admin.partials.header')

    <section class="content container-fluid">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('User') }}
                        </span>
                        @if(Auth::user()->isAdmin())
                            <div class="float-right">
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                {{ __('Create New') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @include('flash::message')

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="item_datatable" class="table table-striped" style="width:100%">
                            <thead class="thead">
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        @if(count($user->getMedia('images'))>0)
                                            <td><img src="{{ $user->getMedia('images')[0]->getUrl() }}" alt="" style="width:40px;"></td>
                                        @else
                                            <td></td>
                                        @endif
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            
                                                <a class="btn btn-sm btn-primary " href="{{ route('users.show',$user) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                <a class="btn btn-sm btn-success" href="{{ route('users.edit',$user) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-item-id="{{ $user->id }}" data-item-name="{{ $user->name }}" data-target="#modal-delete"><i class="fa fa-fw fa-trash"></i>
                                                    Delete
                                                  </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- {!! $users->links() !!} --}}
        </div>
    </section>    
</div>

<form id="deleteItemForm" action="" method="POST">
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Are you sure?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Delete</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</form>
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script>
        $('#flash-overlay-modal').modal();

        $(document).ready( function () {
            var locale_lang = "{{app()->getLocale()}}";
            switch(locale_lang) {
                case 'en':
                    var language_datatable = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json";
                    break;
                case 'es':
                    var language_datatable = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json";
                    break;
                case 'ca':
                    var language_datatable = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Catalan.json";
                    break;
                default:
                    var language_datatable = "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json";
            }
            $('#item_datatable').DataTable({
                    "language": {
                        "url": language_datatable
                    },
            });

            $('#deleteItemForm').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                const id = 'id';
                $('.modal-title').text('Delete ' + button.data('item-name'));
                var route = "{{ route('users.destroy',  'id' ) }}";
                route = route.replace('id',button.data('item-id'));
                $('#deleteItemForm').attr('action', route);
            });

        });

    </script>
@endpush
