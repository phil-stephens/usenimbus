@extends('layouts.droplet')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <h1 class="page-header text-center">Password Required</h1>

                        @include('flash::message')
                        @include('layouts.partials.errors')

                        {!! Form::open() !!}
                        <!-- Password Form Input -->
                        <div class="form-group">
                            {!! Form::label('password', 'Password:') !!}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit field -->
                        <div class="form-group">
                            {!! Form::submit('Submit', ['class' => 'btn btn-default btn-lg']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
        </div>
    </div>
@endsection