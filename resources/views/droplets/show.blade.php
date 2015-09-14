@extends('layouts.droplet')

@section('meta')
    @parent
    <link rel="stylesheet" href="/js/fancybox/jquery.fancybox.css"/>
@endsection

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                {!! $droplet->present()->title('<h1 class="page-header text-center">', '</h1>', false) !!}

                {!! $droplet->present()->htmlIntroduction('<div class="lead">', '</div>') !!}

                @if(count($files) == 1)
                    @foreach($files as $file)
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <p><i class="fa fa-file-o fa-5x"></i></p>

                        <p class="file_name">{{ $file->file_name }}</p>

                        <p>{{ byte_format($file->size) }}</p>

                        <p>
                        @if($file->isDownloadable())
                            <a href="{!! $file->present()->downloadPath() !!}" class="btn btn-default">Download</a>
                        @else
                            Download Unavailable
                        @endif
                        </p>
                    </div>
                    @endforeach

                @else
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
                            <td>
                                @if($file->isDownloadable())
                                <a href="{!! $file->present()->downloadPath() !!}" class="btn btn-default">Download</a>
                                @else
                                Download Unavailable
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>

        </div>
    </div>
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
    </script>
@endsection