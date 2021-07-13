<!DOCTYPE HTML>

<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <title>HotDesk - {{ Voyager::setting("admin.title") }}</title>
    <meta name="description" content="admin login">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="{{ voyager_asset('js/jquery.min.js') }}"></script>
    <script src="{{ voyager_asset('js/select2.min.js') }}"></script>
    <script src="{{ voyager_asset('js/login.js') }}"></script>
    <link href="{{ voyager_asset('style/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ voyager_asset('style/style.css') }}">
</head>
<body class="{{ __('voyager::generic.is_rtl') != 'true' ? 'en' : '' }}">
  <div class="login">
    <div class="box">
            <div class="logo">HotDesk</div>
            <form action="{{ route('voyager.login') }}" method="POST">
                @if(!$errors->isEmpty())
                @foreach($errors->all() as $err)
                <div class="alert error">
                  {{ $err }}
                </div>
                @endforeach
                @endif
                {{ csrf_field() }}
                    <div class="form-group form-group-default" id="emailGroup" data-en="Email" data-fa="ایمیل">
                        <label>{{ __('voyager::generic.email') }}</label>
                        <div class="controls">
                            <input type="text" name="email" id="email" value="{{ old('email') }}" placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                         </div>
                    </div>

                    <div class="form-group form-group-default" id="passwordGroup" data-en="Password" data-fa="رمز عبور">
                        <label>{{ __('voyager::generic.password') }}</label>
                        <div class="controls">
                            <input type="password" name="password" placeholder="{{ __('voyager::generic.password') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="buttons">
                      <input type="hidden" name="remember" id="remember" value="1">

                      <button type="submit" class="btn btn-blue arrow" data-en="Login" data-fa="ورود">
                          {{ __('voyager::generic.login') }}
                      </button>
                    </div>
              </form>
    </div>
    <div class="form-group lang selectbox">
      <label>Language</label>
      <div class="select">
        <select name="state" data-minimum-results-for-search="Infinity">
          <option value="fa" {{ __('voyager::generic.is_rtl') == 'true' ? 'selected' : '' }}>persian</option>
          <option value="en" {{ __('voyager::generic.is_rtl') != 'true' ? 'selected' : '' }}>english</option>
        </select>
      </div>
    </div>
    </div>
<script>
    var btn = document.querySelector('button[type="submit"]');
    var form = document.forms[0];
    btn.addEventListener('click', function(ev){
        if (form.checkValidity()) {
            btn.querySelector('.signingin').className = 'signingin';
            btn.querySelector('.signin').className = 'signin hidden';
        } else {
            ev.preventDefault();
        }
    });

</script>
</body>

</html>
