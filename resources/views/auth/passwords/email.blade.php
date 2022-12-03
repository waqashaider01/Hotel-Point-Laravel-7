<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | HotelPoint</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap" rel="stylesheet">
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
                    <h2 class="font-weight-bolder text-dark text-center">Restore Your Password</h2>
                    <form method="post" action="{{ route('password.email') }}" class="login-form">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" autocomplete="off" class="form-control rounded-left"
                                   placeholder="Enter Email" required="">
                            @error('email')
                            <span class="invalid-input-data" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit"
                                    style="background-color:#1BC5BD !important;border-color:#1BC5BD !important;"
                                    class="form-control btn btn-primary rounded submit px-3">Submit
                            </button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">
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
