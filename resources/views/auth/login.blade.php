@extends('auth')

@section('css_before')
<style>
    .login-section {
        min-height: calc(100vh - 260px);
        display: flex;
        align-items: center;
    }

    .login-heading {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-heading .eyebrow {
        font-size: 12px;
        font-weight: 600;
        color: var(--nexa-sky);
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .login-heading h3 {
        font-family: 'Space Grotesk', 'IBM Plex Sans Thai', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--nexa-navy);
        margin: 0;
    }

    .login-heading .divider {
        width: 48px;
        height: 3px;
        background: linear-gradient(90deg, var(--nexa-blue), var(--nexa-sky));
        border-radius: 3px;
        margin: 14px auto 0;
    }

    .login-section .form-control {
        background: var(--nexa-paper);
        border: 1px solid var(--nexa-line);
        border-radius: 8px;
        padding: 11px 14px;
    }

    .login-section .form-control:focus {
        background: #fff;
        border-color: var(--nexa-sky);
        box-shadow: 0 0 0 0.2rem rgba(47, 178, 240, 0.18);
        outline: none;
    }

    .login-section .text-danger {
        font-size: 13px;
        margin-top: 4px;
    }
</style>
@endsection

@section('navbar')
@endsection

@section('showFromLogin')

<div class="container login-section">
    <div class="row w-100">
        <div class="col-sm-4"></div>
        <div class="col-sm-6">

            <div class="login-heading">
                <div class="eyebrow">NEXA Supply Premium</div>
                <h3>เข้าสู่ระบบ</h3>
                <div class="divider"></div>
            </div>

            <form action="/login" method="post">
                @csrf
                <input type="hidden" name="key" value="{{ old('key', $key ?? request('key')) }}">
                <div class="form-group row mb-2">
                    <div class="col-sm-7">
                        <input type="text" class="form-control" name="username" required
                            placeholder="username" minlength="3" value="{{ old('username') }}">
                        @if($errors->has('username'))
                        <div class="text-danger"> {{ $errors->first('username') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-7">
                        <input type="password" class="form-control" name="password_hash" required
                            placeholder="Password" minlength="3">
                        @if($errors->has('password_hash'))
                        <div class="text-danger"> {{ $errors->first('password_hash') }}</div>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-7 d-flex gap-2">
                        <button type="submit" class="btn-submit-gradient">Login</button>
                        <a href="/" class="btn-cancel-gradient">Cancel</a>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@section('footer')
@endsection

@section('js_before')
@endsection