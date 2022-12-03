<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | HotelPoint</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
</head>
<body style="overflow-y: hidden !important;">
<section class="ftco-section">
    <div class="container" style="">
        <div class="row justify-content-center" style="">
            <div class="col-md-7 col-lg-5" style=" ">
                <div class="login-wrap p-4 p-md-5">
                    <div class="mb-4 d-flex align-items-center justify-content-center">
                        <img src="{{asset('images/logo/HotelPoint-01.png')}}" style="max-width:200px;max-height:64px;"
                             alt=""/>
                    </div>
                    <form method="post" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="email" class="form-control rounded-left" name="email"
                                   value="{{ old('email') }}" required autocomplete="email" placeholder="Username"
                                   autofocus>
                            @error('email')
                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group d-flex">
                            <input id="password" type="password" class="form-control rounded-left" name="password"
                                   required placeholder="Password" autofocus>
                            @error('password')
                            <span class="invalid-input-data" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" name="login_button"
                                    style="background-color:#1BC5BD !important;border-color:#1BC5BD !important;"
                                    class="form-control btn btn-primary rounded submit px-3">Login
                            </button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">
                            </div>
                            <div class="w-50 text-md-right">
                                <a href="{{ route('password.request') }}" style="color:#1BC5BD !important;">Forgot
                                    Password</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
