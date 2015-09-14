@extends('layouts.default')

@section('content')
    <h1 class="page-header">Setup Amazon S3 Storage</h1>

    @include('layouts.partials.errors')

    {!! Form::open(['route' => 's3_path']) !!}
    <!-- Key Form Input -->
    <div class="form-group">
        {!! Form::label('key', 'Key:') !!}
        {!! Form::text('key', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Secret Form Input -->
    <div class="form-group">
        {!! Form::label('secret', 'Secret:') !!}
        {!! Form::text('secret', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Region Form Input -->
    <div class="form-group">
        {!! Form::label('region', 'Region:') !!}
        {!! Form::select('region', config('storage.amazon.regions'), null, ['class' => 'form-control']) !!}
    </div>
    
    <!-- Bucket Form Input -->
    <div class="form-group">
        {!! Form::label('bucket', 'Bucket Name:') !!}
        {!! Form::text('bucket', null, ['class' => 'form-control']) !!}
    </div>




    <!-- Submit field -->
    <div class="bottom-pane container-fluid">
        <div class="row">
            <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
                {!! Form::submit('Save Settings', ['class' => 'btn btn-primary btn-lg']) !!}
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    @include('droplets.partials.upload-overlay')
@endsection