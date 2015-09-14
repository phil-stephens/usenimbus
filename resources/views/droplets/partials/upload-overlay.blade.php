<?php $hash = md5( uniqid(Auth::id() . '.', true) ); ?>

<div class="upload-overlay">

    @if( ! isset($currentDroplet))
    @include('users.partials.free')
    @else
    @include('droplets.partials.free')
    @endif

    <div class="dropzone">
        <div id="previews" class="dropzone-previews"></div>
    </div>

    <div class="top-pane container-fluid">
        <h3 class="pull-left">
            @if( ! isset($currentDroplet))
            Create New Droplet
            @else
            Add Files to Droplet
            @endif
        </h3>

        <div class="pull-right">
            <button type="button" class="btn btn-default" id="cancel-btn">Cancel</button>
        </div>
    </div>

    <div class="bottom-pane container-fluid">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default btn-lg" id="select-files">Select files</button>
            <button type="button" class="btn btn-primary btn-lg" id="start-upload">Start Upload</button>
        </div>
    </div>



</div>

@section('meta')
    @parent
    <link rel="stylesheet" href="/css/dropzone.min.css"/>
    <meta name="csrf_token" content="{{ csrf_token() }}" />
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
            @if( ! isset($currentDroplet))

                @if(Auth::user()->storage())
                maxFiles: 50,
                maxFilesize: 100,
                @else
                maxFiles: 10,
                maxFilesize: 10,
                @endif

            @else

                @if($currentDroplet->storage_id)
                maxFiles: 50,
                maxFilesize: 100,
                @else
                maxFiles: {{ 10 - $currentDroplet->files()->count() }},
                maxFilesize: 10,
                @endif

            @endif
            parallelUploads: 1,
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: "#select-files" // Define the element that should be used as click trigger to select files.
        });

        fileDropzone.on('dragenter', function(event) {
            $('.upload-overlay').show();
        });

        fileDropzone.on('addedfile', function(file) {
            $('.upload-overlay').show();
        });

        $('#start-upload').on('click', function(e) {
            e.preventDefault();
            fileDropzone.processQueue();
        });

        fileDropzone.on('processing', function() {
            this.options.autoProcessQueue = true;
        });

        $('#cancel-btn').on('click', function(e) {
            e.preventDefault();
            fileDropzone.removeAllFiles(true);
            $('.upload-overlay').hide();
        });

        fileDropzone.on('sending', function(file, xhr, formData) {
            // Add additional data to the upload
            formData.append('_token', $('meta[name="csrf_token"]').attr('content'));
            @if( ! isset($currentDroplet))
            formData.append('upload_hash', '{{ $hash }}');
            @else
            formData.append('droplet_id', '{{ $currentDroplet->id }}');
            @endif
        });

        fileDropzone.on('queuecomplete', function() {
            @if( ! isset($currentDroplet))
            window.location.replace('{{ route('droplet_created_path', $hash) }}');
            @else
             window.location.replace('{{ route('droplet_files_path', $currentDroplet->id) }}');
            @endif
        });
    </script>
@endsection