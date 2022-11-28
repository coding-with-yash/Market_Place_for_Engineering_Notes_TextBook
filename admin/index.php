<?php
include_once 'php_files/config.php';
//checking session
session_start();
if(isset($_SESSION['admin_name'])) {
    header("Location: ".$base_url."admin/dashboard.php");
}
?>
<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin : SHBS</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="login-form">
                        <h1 class="logo">Second Hand Book Store</h1>
                        <!-- Form -->
                        <form id="adminLogin" method ="POST" autocomplete="off">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control password" placeholder="password" required>
                            </div>
                            <input type="submit" name="login" class="btn" value="login"/>
                        </form>
                        <!-- /Form -->
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/admin_actions.js"></script>
    </body>
</html>
