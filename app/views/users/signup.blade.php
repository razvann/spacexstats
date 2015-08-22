@extends('templates.main')
@section('title', 'Sign Up')

@section('content')
<body class="signup">

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper single-page">
        <h1>Join SpaceX Stats</h1>
        <main>
            {{ Form::open(array('route' => 'users.signup')) }}
            {{ Form::label('username', 'Username:') }}
            {{ Form::text('username') }}
            {{ $errors->first('username')  }}

            {{ Form::label('email', 'Email:') }}
            {{ Form::email('email') }}
            {{ $errors->first('email')  }}

            {{ Form::label('password', 'Password:') }}
            {{ Form::password('password') }}
            {{ $errors->first('password')  }}

            {{ Form::label('password_confirmation', 'Confirm Password:') }}
            {{ Form::password('password_confirmation') }}
            {{ $errors->first('password_confirmation')  }}

            {{ Form::label('eula', 'I agree to the terms and conditions') }}
            {{ Form::checkbox('eula', true) }}
            {{ $errors->first('eula')  }}

            {{ Form::submit('Join') }}
            {{ Form::close() }}
        </main>
    </div>
</body>
@stop