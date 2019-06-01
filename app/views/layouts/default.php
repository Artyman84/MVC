<?php
use core\Session;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BeeJee Test</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">BeeJee Test</a>
        </div>
        <div class="navbar-collapse collapse">
            <?php if( !Session::inst()->getVar('is_admin') ) {?>
                <form class="navbar-form navbar-right" role="form" action="/main/login" method="post">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>
                    <button type="submit" name="is_auth" value="1" class="btn btn-success">Sign in</button>
                </form>
            <?php } else { ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="form-group"><a href="/main/logout"><strong><span class="glyphicon glyphicon-log-out"></span> Logout</strong></a></li>
                    </ul>
            <?php } ?>
        </div>
    </div>
</div>


<div class="container" style="">
    <div class="row">
        <?php if( ($error_message = Session::inst()->getVar('error_message')) ) {
            Session::inst()->unsetVar('error_message');?>
            <div class="alert alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 class="text-center"><?php echo $error_message?></h4>
            </div>
        <?php } ?>
        <div class="col-md-12"><?php echo $content;?></div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>