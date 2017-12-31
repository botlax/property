@extends('skel')

@section('title')
Login | Talal Contracting Co.
@endsection

@section('body-class')
login
@endsection

@section('content')
    <header>
       <h1>Talal Contracting Company</h1>
    </header>
    <div id="login-form">
        <form class="clearfix" role="form" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
            
            <div class="form-input">
                {!! Form::label('email', 'Email ID') !!}
                {!! Form::text('email') !!}
                @if ($errors->has('email'))
                    <span class="error">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div><div class="form-input">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password') !!}
                 @if ($errors->has('password'))
                    <span class="error">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div><div class="form-misc clearfix">

                 <div class="remember-wrap">
                    {!! Form::checkbox('remember') !!}
                    {!! Form::label('remember', 'Remember me') !!}
                </div>

            </div>
                                  

            {!! Form::submit('Let me in.'); !!}
        </form>

        <p>&copy; Copyright {{date('Y')}} Talal Trading & Contracting Co.</p>
    </div>
@endsection

@section('js')
    
@endsection
