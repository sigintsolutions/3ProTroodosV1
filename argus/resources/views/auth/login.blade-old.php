@extends('layouts.app')
@section('content')

<div class="container-fluid">
        <div class="row">
            <div class="euz_logscreen">
				<div id="euz_logbg" class="p-3">
					<h5 class="euz_b">Login <span class="euz_tex_light">ARGUS Panoptes - Administration </span></h5>
				</div>
				
@if(\Session::has('message'))
                        <p class="alert alert-info">
                            {{ \Session::get('message') }}
                        </p>
                    @endif				
                <form class="pt-3" method="POST" action="{{ route('login') }}">
				{{ csrf_field() }}
					<div class="input-group mb-3 px-3">
						<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-user-tie"></i></span>
						</div>
						<input name="email" type="text" class="form-control" placeholder="{{ trans('Username') }}">
						<?php /*?><input type="text" class="form-control" placeholder="Username"><?php */?>
					</div>
					<div class="input-group mb-3 px-3">
						<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
						</div>
						<?php /*?><input type="password" class="form-control" placeholder="Password"><?php */?>
						<input name="password" type="password" class="form-control" placeholder="{{ trans('global.login_password') }}">
					</div>
					<?php /*?><div id="dvCaptcha" class="mb-3 px-3" style="width: 100%"></div><?php */?>
					<div class="form-group row">
    <div class="col-md-6 offset-md-4">
        <div class="g-recaptcha" data-sitekey="6LeqfcIUAAAAAMW28EOHjuJHE_EzxYEaSx40exKH{{ config('GOOGLE_RECAPTCHA_KEY') }}"></div>
        @if ($errors->has('g-recaptcha-response'))
            <span class="invalid-feedback" style="display: block;">
                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
        @endif
    </div>
</div>
					<hr class="mb-0">
					<input type="submit" class="btn euz_save_btn" value='{{ trans('global.login') }}'>
					<?php /*?><a href="Dashboard.html" class="btn euz_save_btn">Login</a><?php */?>
					<input type="reset" class="btn euz_cancel_btn" value="Cancel">
				</form>
            </div>
        </div>		
    </div>

<?php /*?><div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    @if(\Session::has('message'))
                        <p class="alert alert-info">
                            {{ \Session::get('message') }}
                        </p>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <h1>
                            <div class="login-logo">
                                <a href="#">
                                    {{ trans('global.site_title') }}
                                </a>
                            </div>
                        </h1>
                        <p class="text-muted">{{ trans('global.login') }}</p>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input name="email" type="text" class="form-control" placeholder="{{ trans('global.login_email') }}">
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input name="password" type="password" class="form-control" placeholder="{{ trans('global.login_password') }}">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="submit" class="btn btn-primary px-4" value='{{ trans('global.login') }}'>
                                <label class="ml-2">
                                    <input name="remember" type="checkbox" /> {{ trans('global.remember_me') }}
                                </label>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                    {{ trans('global.forgot_password') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div><?php */?>
@endsection