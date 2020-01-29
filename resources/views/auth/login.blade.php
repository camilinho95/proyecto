@extends('layout')

@section('content')
<br>
<div class="card">
    <div class="card-header">{{ __('Inicio de sesión') }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
               <div class="col-md-6 offset-3">
                <div class="col-md-12 m-3">
                    <div class="image offset-4">
                        <img src="{{ asset('img/user-login.png') }}" style="opacity: .8; width:50%">
                    </div>
                    <br>
                    <input id="email" type="email"  placeholder="Digite Correo" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-12 m-3">
                    <input id="password" placeholder="Digite Contraseña" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
               <div class="col-md-10 m-4  offset-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Iniciar sesión') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Olvidaste tu contraseña?') }}
                    </a>
                @endif
            </div>  
               </div>          
            </div>               
        </form>
    </div>
    <br>
    <br>
</div>
@endsection
