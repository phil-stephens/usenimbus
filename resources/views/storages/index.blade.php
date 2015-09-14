@extends('layouts.default')

@section('content')
    <h1 class="page-header">Storage Settings</h1>

    @include('storages.partials.' . $credentials->driver)

    <div class="bottom-pane container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                {!! Form::open(['method' => 'DELETE', 'route' => ['destroy_storage_path', $storage->id], 'id' => 'delete-storage-form']) !!}
                {!! Form::submit('Remove This Storage', ['class' => 'btn btn-danger btn-lg']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @include('droplets.partials.upload-overlay')
@endsection

@section('scripts')
    @parent

    <script>
        $('#delete-storage-form').on('submit', function(e)
        {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('<p>Are you sure you want to remove this storage from your account?</p>' +
            '<ul>' +
            '<li>All Droplets that use this Storage will be permanently removed</li>' +
            '<li>All Files that use this Storage will be permanently removed</li>' +
            '<li>This CANNOT be undone!</li>' +
            '</ul>', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection