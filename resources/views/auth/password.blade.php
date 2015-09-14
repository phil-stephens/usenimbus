@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

                <h1 class="page-header text-center">Reset Your Password</h1>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif


                        @include('layouts.partials.errors')

                        {!! Form::open() !!}
                        <!-- Email Form Input -->
                        <div class="form-group">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit field -->
                        <div class="form-group">
                            {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-default btn-lg']) !!}
                        </div>
                        {!! Form::close() !!}

                <hr/>
            </div>
        </div>
    </div>

@endsection
