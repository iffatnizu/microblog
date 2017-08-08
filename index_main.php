<?php
if (!function_exists('base_url')) {

    function base_url() {
        return 'http://localhost/microblog/';
    }

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Home Micro Blog</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="Your Local Catering"/>
        <meta name="keyword" content="directory, services, restaurent"/>
        <meta name="author" content=""/>
        <!-- Le styles -->
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open Sans"/>
        <link href="<?php echo base_url() ?>assets/css/site.css" rel="stylesheet"/>
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/core/jquery-1.9.1.js"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                  <script src="<?php echo base_url() ?>scripts/plugins/bootstrap/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->

        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/ico/favicon.ico"/>
        <script type="text/javascript">
            var base_url = '<?php echo base_url() ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/site.js"></script>
    </head>

    <body id="microblog">
        <div class="wrapper mainWrapper">
            <div class="wrapper microblogContainer"> 
                <!--header start-->
                <div class="wrapper mbHeader"> 
                    <a href="#">
                        <img id="logo" src="<?php echo base_url() ?>assets/images/logo.jpg" width="120" alt="logo"/>
                    </a>
                </div>
                <div class="wrapper mbSlogan">
                    <p><i class="icon-edit"></i>eque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
                        There is no one who loves pain itself, who seeks after it and wants to have it, simply because it is pain...</p>
                </div>

                <!--login part start-->

                <div class="loginArea">
                    <h4><i class="icon-lock"></i> LOGIN</h4>
                    <br class="clearfix"/>
                    <form class="form-signin" method="post">
                        <table>
                            <tr>
                                <td colspan="2"><div class="loginstatus" style="text-align: left;color: red;"> </div></td>
                            </tr>
                            <tr>
                                <td valign="top">E-mail ID</td>
                                <td><input name="email" type="text"  placeholder="Email address"/></td>
                            </tr>
                            <tr>
                                <td valign="top">Password</td>
                                <td><input name="password" type="password" placeholder="Password"/></td>
                            </tr>
                            <tr>
                                <td valign="top">&nbsp;</td>
                                <td><label class="checkbox">
                                        <input name="remeberme" type="checkbox" value="1"/>
                                        Remember me </label></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input name="signin" class="btn btn-info" type="submit" value="Sign in"/></td>
                            </tr>
                        </table>
                    </form>
                </div>

                <!--registration part-->
                <div class="registrationArea">
                    <h4><i class="icon-key"></i> REGISTRATION</h4>
                    <br class="clearfix"/>
                    <form class="form-registration" method="post">
                        <table style="width: 100%">
                            <tr>
                                <td colspan="2"><div class="loginstatus" style="text-align: left;color: red;"> </div></td>
                            </tr>
                            <tr>
                                <td valign="top">Name</td>
                                <td><input name="txtName" type="text"  placeholder="Name"/></td>
                            </tr>
                            <tr>
                                <td valign="top">E-mail ID</td>
                                <td><input name="txtEmail" type="text"  placeholder="Email address"/></td>
                            </tr>
                            <tr>
                                <td valign="top">Password</td>
                                <td><input name="txtPassword" type="password" placeholder="Password"/></td>
                            </tr>
                            <tr>
                                <td valign="top">Confirm Password</td>
                                <td><input name="txtConPassword" type="password" placeholder="Confirm Password"/></td>
                            </tr>
                            <tr>
                                <td valign="top">&nbsp;</td>
                                <td><label class="checkbox">
                                        <input name="remeberme" type="checkbox" value="1"/>
                                        I accept <a href="#">Terms & Condition</a> </label></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input name="signin" class="btn btn-signup" type="submit" value="Sign Up"/></td>
                            </tr>
                        </table>
                    </form>
                </div>

                <!--footer-->
                <div class="wrapper footer">
                    <ul>
                        <li><a href="">About</a></li>
                        <li><a href="">Help</a></li>
                        <li><a href="">Blog</a></li>
                        <li><a href="">Status</a></li>
                        <li><a href="">Jobs</a></li>
                        <li><a href="/tos">Terms</a></li>
                        <li><a href="/privacy">Privacy</a></li>
                        <li><a href="">Advertisers</a></li>
                        <li><a href="">Businesses</a></li>
                        <li><a href="">Media</a></li>
                        <li><a href="">Developers</a></li>
                        <li><a href="">Resources</a></li>
                    </ul>
                    <br class="clearfix"/>
                    <span class="right copyright">&copy; 2013 Micro Blog</span>
                </div>
            </div>
        </div>
    </body>
</html>
