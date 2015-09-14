@extends('layouts.default')

@section('meta')
    @parent
    <link rel="stylesheet" href="/css/dropzone.min.css"/>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
@endsection

@section('content')

    <h1 class="page-header">Create Droplet</h1>

    @include('users.partials.free')

    <p class="lead">Droplets are collections of files that you would like to share.  They can be open, password-protected, have download limits and everything in between. Drag some files onto your browser to get started.</p>

    <div class="dropzone">
        <div id="previews">

        </div>
    </div>

    <div class="bottom-pane container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default btn-lg" id="select-files">Select files</button>
                    <button type="button" class="btn btn-primary btn-lg" id="start-upload">Start Upload</button>
                </div>
            </div>
        </div>
    </div>

    
{{--{!! Form::open(['route' => 'file_path', 'files' => true]) !!}--}}
    {{--{!! Form::file('file') !!}--}}
    {{--{!! Form::hidden('upload_hash', $hash) !!}--}}
    {{--<!-- Submit field -->--}}
    {{--<div class="form-group">--}}
        {{--{!! Form::submit('go', ['class' => 'btn btn-primary']) !!}--}}
    {{--</div>--}}
{{--{!! Form::close() !!}--}}
@endsection

@section('scripts')
    @parent
    <script src="/js/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        var fileDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: '{{ route('file_path') }}', // Set the url
            addRemoveLinks: true,
            autoProcessQueue: false,

            @unless(Auth::user()->storage())
            maxFiles: 10,
            maxFilesize: 10,
            @else
            maxFiles: 50,
            maxFilesize: 100,
            @endunless

            parallelUploads: 1,
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: "#select-files" // Define the element that should be used as click trigger to select files.
        });

        $('#start-upload').on('click', function(e) {
            e.preventDefault();
            fileDropzone.processQueue();
        });

        fileDropzone.on('processing', function() {
            this.options.autoProcessQueue = true;
        });

        fileDropzone.on('sending', function(file, xhr, formData) {
            // Add additional data to the upload
            formData.append('_token', $('meta[name="csrf_token"]').attr('content'));
            formData.append('upload_hash', '{{ $hash }}');
        });

        fileDropzone.on('queuecomplete', function() {
            window.location.replace('{{ route('droplet_created_path', $hash) }}');
        });
    </script>
@endsection