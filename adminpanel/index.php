<? include_once "connect.php";
	if($_SESSION['Admin_UserID']>0)
	{
 		$mfp->mf_redirect("dashboard.php");
		exit;
	}
?>

<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title><?=$SITE_NAME;?> | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            	<?=$mfp->mf_viewmessage();?>
            <form class="form-signin" id="loginform" action="checklogin.php" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text"name="username" id="username" class="form-control" placeholder="Username" value="<?php echo $_COOKIE['remember_me_user']; ?>" autofocus required/>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="<?php echo $_COOKIE['remember_me_pass']; ?>" required/>
                    </div>          
                    <div class="form-group">
                      <label>  <input type="checkbox" name="login-check" id="login-check"  onChange="chkStatus(this.value);" <?php if($_COOKIE['remember_me_user']!="") { echo 'checked="checked"'; echo 'value="1"'; } else { echo 'value="0"'; } ?>/> Remember me</label>
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>
                    <p><a data-toggle="modal" href="#myModal">I forgot my password</a></p>
                </div>
                <script type="text/javascript">
				function chkStatus(rem)
				{
					if(rem == 0)
					{
						document.getElementById('login-check').value = 1;
					}
					else
					{
						document.getElementById('login-check').value = 0;
					}
				}
			</script>
            </form>
            
            <form  class="form-forget"  action="forgotpass.php" method="post" onSubmit="return ChkEmail();">
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password?</h4>
                           
                      </div>
                      <div class="modal-body">
                          <p>Enter your e-mail address below to reset your password.</p>
                          <input type="text" name="email" id="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix" required>

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="submit">Submit</button>
                      </div>
                  </div>
              </div>
          </div>
		  
          <!-- modal -->

      </form>

            <?php /*?><div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div><?php */?>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>        

    </body>
</html>