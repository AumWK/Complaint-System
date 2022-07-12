
<!DOCTYPE html>
<html lang="en" class="bg">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint System</title>
    <link rel="stylesheet" href="{{asset('css/font.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-login.css')}}">
</head>
<body>
   
    <div class="card">
        <div class="block-title font-PT">
            <h1>เข้าสู่ระบบ</h1>
        </div>
        <div class="block-form-login">
            <form action="{{url('/login')}}" method="post">
                @csrf
                <div class="block-input">
                    <input type="text" name="username" placeholder="username">
                    @error('username')<p class="text-danger">{{$message}}</p>@enderror
                </div>
                <div class="block-input">
                    <input type="password" name="password" placeholder="password">
                    @error('password')<p class="text-danger">{{$message}}</p>@enderror
                </div> 
                    @if(session("no_success"))
                        <p class="text-danger error-user">*{{session('no_success')}}*</p>
                    @endif
                <div class="block-bt-login font-PT">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
</body>
</html>
