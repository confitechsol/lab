<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>LIMS</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        <link href="css/app.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
      </head>
      <body>
        <main>
          <header>
            <div class="container">
              <div class="logo">
                <img style="height:90px; width:90px;" src="{{ url('/')}}/assets/images/rntcp-logomod.png" />
              </div>

            </div>
          </header>
          <section class="main-body">
            <div class="container">
              <div class="login-left">
                <img src="images/ashok-stambha.jpg" alt="ashok-stambha"/>
                <h2>Ministry of Health &amp; Family Welfare<br/> Government of India</h2>
                <!-- <h3><u>Economic Development Digital Solution</u></h3> -->
                <h1>
                  Laboratory Information Management System
                </h1>


              </div>
              <div class="login-right">
                <div class="login-form">
                  <form method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <h2>Login to LIMS</h2>
                    <div class="input_text">
                      <!-- <img src="images/user.svg" alt="user id"> -->
                      <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                    </div>
                    <div class="input_text">
                      <!-- <img src="images/password.svg" alt="password"> -->
                      <input id="password" type="password" class="form-control" name="password" required>
                      @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                    </div>
                      <input type="submit" class="btn" value="Login">
					  <h6>Version 1.8</br>
					  Date of Release: 26-May-2020</h6>
			      </form>
				    
                </div>
				
              </div>
			
            </div>
          </section>
        </main>
      </body>
  </html>
