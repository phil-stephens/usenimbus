@extends('layouts.default')

@section('sidenav')
    @include('droplets.partials.sidenav')
@show

@section('content')
    @include('droplets.partials.share')

    @include('droplets.partials.free')

    {!! Form::model($droplet, ['route' => ['edit_droplet_path', $droplet->id]]) !!}
    <!-- Title Form Input -->
    <div class="form-group">
        {!! Form::text('title', null, ['class' => 'form-control input-lg', 'placeholder' => 'Optional title']) !!}
    </div>

    @include('layouts.partials.errors')

    <!-- Introduction Form Input -->
    <div class="form-group">
        {!! Form::label('introduction', 'Introduction:') !!}
        {!! Form::textarea('introduction', null, ['class' => 'form-control', 'rows' => 5]) !!}

        <p class="help-block">You can use <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet" target="_blank">Markdown</a> syntax for additional styling.</p>
    </div>

    {{--<div class="checkbox">--}}
        {{--<label>--}}
            {{--{!! Form::checkbox('watermark_images', '1'); !!}--}}
            {{--Automatically watermark image previews--}}
        {{--</label>--}}
    {{--</div>--}}

    <!-- Submit field -->
    <div class="bottom-pane container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                {!! Form::submit('Save Changes', ['class' => 'btn btn-primary btn-lg']) !!}
            </div>
        </div>
    </div>

    {!! Form::close() !!}


    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Delete this Droplet</h3>
        </div>
        <div class="panel-body">
            <p>This cannot be undone.</p>

            {!! Form::open(['method' => 'DELETE', 'route' => ['destroy_droplet_path', $droplet->id], 'id' => 'delete-droplet-form']) !!}

            {!! Form::hidden('id', $droplet->id) !!}

            <!-- Submit field -->
            <div class="form-group">
                {!! Form::submit('Delete Droplet Now', ['class' => 'btn btn-danger']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if($droplet->canBeUploadedTo())
        @include('droplets.partials.upload-overlay', ['currentDroplet' => $droplet])
    @endif
@endsection

@section('scripts')
    @parent

    <script>
        $('#delete-droplet-form').on('submit', function(e)
        {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this Droplet?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection