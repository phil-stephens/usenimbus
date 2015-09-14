@extends('layouts.default')

@section('content')
<h1 class="page-header">Edit Your Profile</h1>

@include('layouts.partials.errors')

{!! Form::model(Auth::user(), ['route' => 'edit_user_path']) !!}

<!-- Name Form Input -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Form Input -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Password Form Input -->
<div class="form-group">
    {!! Form::label('password', 'New Password:') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<!-- Password_confirmation Form Input -->
<div class="form-group">
    {!! Form::label('password_confirmation', 'Confirm New Password:') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>


<!-- Submit field -->
<div class="bottom-pane container-fluid">
    <div class="row">
        <div class="col-md-10 col-sm-9 col-md-offset-2 col-sm-offset-3">
            {!! Form::submit('Save Changes', ['class' => 'btn btn-primary btn-lg']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}

<div class="panel panel-danger">
    <div class="panel-heading">
        <h3 class="panel-title">Close Your Account</h3>
    </div>
    <div class="panel-body">
        <p>This cannot be undone.</p>

        {!! Form::open(['method' => 'DELETE', 'route' => 'destroy_user_path', 'id' => 'delete-user-form']) !!}

        {!! Form::hidden('id', Auth::id()) !!}

        <!-- Submit field -->
        <div class="form-group">
            {!! Form::submit('Close Account Now', ['class' => 'btn btn-danger']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>

@include('droplets.partials.upload-overlay')
@endsection

@section('scripts')
    @parent

    <script>
        $('#delete-user-form').on('submit', function(e)
        {
            e.preventDefault();

            var theForm = this;

            bootbox.confirm('Are you sure you want to close your account?', function(result) {
                if(result)
                {
                    theForm.submit();
                }
            });
        });
    </script>
@endsection