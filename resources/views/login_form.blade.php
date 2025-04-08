<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- font-awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>
        Login | Web bán hàng
    </title>

</head>

<body>
    <form action="{{ route('login') }}" method="POST" class="w-50 mx-auto border mt-5 p-3">
        @csrf
        <h2 class="text-center">Login</h2>
        <div class="mb-3">
            <label for="InputEmail" class="form-label">Email</label>
            <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="InputEmail" name="email">
            @if ($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="InputPassword" class="form-label">Password</label>
            <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="InputPassword" name="password">
            @if ($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember-me">
            <label class="form-check-label" for="remember-me">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
