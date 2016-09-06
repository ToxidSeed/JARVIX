<!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <html>
        <head>                        
            <link media="all" type="text/css" rel="stylesheet" href="./css/bootstrap.min.css">  
            <link media="all" type="text/css" rel="stylesheet" href="./css/LoginStyle.css">
            <script type="text/javascript">
                    var path = '/jarvix/js/app/';
                    base_url = '<?php echo base_url();?>'+'index.php/';                    
            </script>  
            <script type="text/javascript" src="<?php echo base_url();?>js/angular/angular.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>js/app/MyApp/LoginV1.js"></script>
             
        </head>
        <body>     
            <div class="container" ng-app="app" ng-controller="Login">
            <div class="card card-container">
                <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
                <img id="profile-img"  src="./images/logo.png" />
                <p id="profile-name" class="profile-name-card"></p>
                <form class="form-signin">
                    <!--<span id="reauth-email" class="reauth-email"></span>-->
                    <!--<input ng-model="email" type="email" id="inputEmail" class="form-control" placeholder="Email address">-->
                    <input ng-model="email" type="email"  id="inputEmail" class="form-control" placeholder="Email address">
                    <input ng-model="password" type="password" id="inputPassword" class="form-control" placeholder="Password">
                    <div id="remember" class="checkbox">
                        <label>
                            <input type="checkbox" value="remember-me"> Remember me
                        </label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block btn-signin" ng-click="login()">Conectarse</button>
                </form><!-- /form -->
                <a href="#" class="forgot-password">
                    Forgot the password?
                </a>
            </div><!-- /card-container -->            
    </div>