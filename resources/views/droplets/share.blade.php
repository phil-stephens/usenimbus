@extends('layouts.default')

@section('sidenav')
    @include('droplets.partials.sidenav')
@show

@section('content')
    @include('droplets.partials.share')

    <h1 class="page-header">Share this Droplet by Email</h1>

    @include('layouts.partials.errors')

    {!! Form::open(['route' => ['droplet_share_path', $droplet->id]]) !!}
        {!! Form::hidden('redirect', route('droplet_files_path', $droplet->id)) !!}

        <!-- Emails Form Input -->
        <div class="form-group">
            {!! Form::label('emails', 'Emails:') !!}
            {!! Form::text('emails', null, ['class' => 'form-control', 'required']) !!}
        </div>

        <!-- Msg Form Input -->
        <div class="form-group">
            {!! Form::label('message', 'Optional Message:') !!}
            {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 3]) !!}
        </div>

        <!-- Submit field -->
    <div class="bottom-pane container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                {!! Form::submit('Send Emails', ['class' => 'btn btn-primary btn-lg']) !!}
                {!! link_to_route('droplet_files_path', 'Cancel', $droplet->id) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    @if($droplet->canBeUploadedTo())
        @include('droplets.partials.upload-overlay', ['currentDroplet' => $droplet])
    @endif
@endsection
