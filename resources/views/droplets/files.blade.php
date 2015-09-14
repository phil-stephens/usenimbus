@extends('layouts.default')

@section('meta')
    @parent
    <link rel="stylesheet" href="/js/fancybox/jquery.fancybox.css"/>
@endsection

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
        {!! Form::hidden('watermark_images') !!}
    </div>

    {!! Form::close() !!}

    <div class="page-header">
        <h1 class="pull-left">Files</h1>

        @if( count($files) && $droplet->canBeUploadedTo() )
        <button onclick="$('.upload-overlay').show();" class="btn btn-primary btn-lg pull-right">Add More Files</button>
        @endif
    </div>

    @unless( ! count($files))

    <table class="table table-striped table-middle">
        <tbody>
        @foreach($files as $file)
        <tr>
            <td class="file_name">{{ $file->file_name }}</td>
            <td>
                @if($file->isImage())
                    <a href="{!! $file->present()->previewPath() !!}" class="lightbox" rel="gallery"><i class="fa fa-search"></i></a>
                @endif
            </td>
            <td>{{ byte_format($file->size) }}</td>
            <td>{{ $file->present()->downloadCount() }}</td>
            {{--<td><a href="#" class="btn btn-default">Update</a></td>--}}
            <td>
                {!! Form::open(['method' => 'DELETE', 'route' => ['destroy_file_path', $droplet->id, $file->id], 'class' => 'delete-file-form']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <p>There are currently no files in this Droplet.</p>
        <button onclick="$('.upload-overlay').show();" class="btn btn-primary btn-lg">Add More Files</button>
    @endunless

    @if($droplet->canBeUploadedTo())
    @include('droplets.partials.upload-overlay', ['currentDroplet' => $droplet])
    @endif
@endsection

@section('scripts')
    @parent
    <script src="/js/fancybox/jquery.fancybox.pack.js"></script>

    <script>
        $(document).ready(function() {
            $('.lightbox').fancybox({
                padding : 0
            });
        });

        $('.delete-file-form').on('submit', function(e)
        {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to delete this file?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection