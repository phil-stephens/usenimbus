@extends('layouts.default')

@section('content')
    <h1 class="page-header">Storage Settings</h1>

    <p class="lead">You do not currently have any cloud storage set up.  Add some and use Nimbus without limits...</p>

    <p>{!! link_to_route('dropbox_oauth_path', 'Add a Dropbox account', [], ['class' => 'btn btn-primary btn-lg']) !!}</p>

    <p>{!! link_to_route('copy_oauth_path', 'Add a Copy.com account', [], ['class' => 'btn btn-primary btn-lg']) !!}</p>

    <p>{!! link_to_route('s3_path', 'Add an Amazon S3 Bucket', [], ['class' => 'btn btn-primary btn-lg']) !!}</p>


    @include('droplets.partials.upload-overlay')
@endsection