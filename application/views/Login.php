<!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <html>
        <head>                        
            <link media="all" type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">  
            <link media="all" type="text/css" rel="stylesheet" href="./css/LoginStyle.css">       
                                    
        </head>
        <body>
            <div class="container">
            <div class="card card-container">
                <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
                <img id="profile-img"  src="./images/logo.png" />
                <p id="profile-name" class="profile-name-card"></p>
                <form class="form-signin">
                    <span id="reauth-email" class="reauth-email"></span>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                    <div id="remember" class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Conectarse</button>
                </form><!-- /form -->
                <a href="#" class="forgot-password">
                    Forgot the password?
                </a>
            </div><!-- /card-container -->
    </div>