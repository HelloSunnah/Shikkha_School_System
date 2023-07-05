<!DOCTYPE html>
<!-- Coding By CodingNepal - youtube.com/codingnepal -->
<style>
  @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
  }

  body {
    margin: 0;
    padding: 0;
    background: linear-gradient(120deg, #2980b9, #8e44ad);
    height: 100vh;
    overflow: hidden;
  }

  .center {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    background: white;
    border-radius: 10px;
    box-shadow: 10px 10px 15px rgba(0, 0, 0, 0.05);
  }

  .center h1 {
    text-align: center;
    padding: 20px 0;
    border-bottom: 1px solid silver;
  }

  .center form {
    padding: 0 40px;
    box-sizing: border-box;
  }

  form .txt_field {
    position: relative;
    border-bottom: 2px solid #7127ea;
    margin: 30px 0;
  }

  .txt_field input {
    width: 100%;
    padding: 0 5px;
    height: 40px;
    font-size: 16px;
    border: none;
    background: none;
    outline: none;
  }

  .txt_field label {
    position: absolute;
    top: 50%;
    left: 5px;
    color: #7127ea;
    transform: translateY(-50%);
    font-size: 16px;
    pointer-events: none;
    transition: .5s;
  }

  .txt_field span::before {
    content: '';
    position: absolute;
    top: 40px;
    left: 0;
    width: 0%;
    height: 1px;
    background: #7127ea;
    transition: .5s;
  }

  .txt_field input:focus~label,
  .txt_field input:valid~label {
    top: -5px;
    color: #7127ea;
  }

  .txt_field input:focus~span::before,
  .txt_field input:valid~span::before {
    width: 100%;
  }

  .pass {
    margin: -3px 0 20px 0px;
    color: #a6a6a6;
    cursor: pointer;
  }

  .pass:hover {
    text-decoration: underline;
  }

  input[type="submit"] {
    width: 100%;
    height: 50px;
    border: 1px solid;
    background: #7127ea;
    border-radius: 25px;
    font-size: 18px;
    color: #e9f4fb;
    font-weight: 700;
    cursor: pointer;
    outline: none;
  }

  input[type="submit"]:hover {
    border-color: white;
    transition: .5s;
  }

  .signup_link {
    margin: 30px 0;
    text-align: center;
    font-size: 16px;
    color: #666666;
  }

  .signup_link a {
    color: #2691d9;
    text-decoration: none;
  }

  .signup_link a:hover {
    text-decoration: underline;
  }
</style>

<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Shikkha-Forgot-Password</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>


  <div class="center">
    <center>
      <div class="col-xxl-3 col-xl-3 col-lg-2 col-md-6 col-6">
        <div class="logo">
          <a  href="{{ route('home') }}">
            <img style="margin-top: 40px;" src="{{ asset('images/logo/logo.svg') }}" alt="logo">
          </a>
        </div>
      </div>
      <h2 style="color:#7127ea; padding-top:0px">Forgot Password</h2>


    </center>

    <form method="post" action="{{route('user.forgot.password.post')}}">
      @csrf
      <div class="txt_field">

        <input type="email" required name="email">
        <span></span>
        <label>Email</label>


      </div>
      <center> <strong> @if (session('status'))
          <div style="color: red;" class="alert alert-danger">
            {{ session('status')}}
          </div>
        </strong>
        @endif
      </center>

      <input type="submit" value="Send Link">
      <div class="signup_link">
        Not a member? <a href="{{route('getStarted.post')}}">Signup</a>
      </div>
    </form>
  </div>

</body>

</html>