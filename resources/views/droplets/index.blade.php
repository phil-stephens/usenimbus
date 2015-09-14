@extends('layouts.default')

@section('content')

    <div class="page-header">
        <h1 class="pull-left">Droplets</h1>

        <a href="{{ route('create_droplet_path') }}" class="btn btn-primary btn-lg pull-right">Create New Droplet</a>
    </div>

    @include('users.partials.free')

    <table class="table table-striped table-middle">
        <tbody>
        @foreach($droplets as $droplet)
            <tr>
                <td>{!! link_to_route('droplet_files_path', $droplet->present()->title(), $droplet->id) !!}</td>
                <td>{{ $droplet->present()->fileCount() }}</td>
                <td><a href="{{ route('edit_droplet_path', $droplet->id) }}" class="btn btn-default">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('droplets.partials.upload-overlay')
@endsection