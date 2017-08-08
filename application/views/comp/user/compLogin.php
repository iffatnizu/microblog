<!--login part start-->
<script type="text/javascript" src="<?php echo base_url() ?>scripts/site/login.js"></script>
<p style="color: #3BA2C0;text-shadow:0 1px 0 #FFFFFF, -1px -1px 0 #FFFFFF, 1px -1px 0 #FFFFFF, -1px 1px 0 #FFFFFF, 1px 1px 0 #FFFFFF;background: #FFF;padding: 5px;margin-top:5px;border-radius:5px;width: 990px;float: left;">
    <?php
    if ($this->session->userdata('deletedCompleted')) {
        echo 'Your account is successfully deactivated.we keep your data safe. if you want to activate your account, simply login with your username and password. :) ';
    }
    $se['deletedCompleted'] = FALSE;
    $this->session->unset_userdata($se);
    ?>
</p>
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
                <td colspan="3"><div class="registrationstatus" style="text-align: left;color: red;"> </div></td>
            </tr>
            <tr>
                <td valign="top" width="25%">Name</td>
                <td width="40%"><input name="txtName" type="text" placeholder="Name"/></td>
                <td width="35%"><span class="nameerror" style="text-align: left;color: red;"></span></td>
            </tr>
            <tr>
                <td valign="top">E-mail ID</td>
                <td><input name="txtEmail" type="text" placeholder="Email address"/></td>
                <td><span class="emailerror" style="text-align: left;color: red;"></span></td>
            </tr>
            <tr>
                <td valign="top">Password</td>
                <td><input name="txtPassword" type="password" placeholder="Password"/></td>
                <td><span class="passerror" style="text-align: left;color: red;"></span></td>
            </tr>
            <tr>
                <td valign="top">Confirm Password</td>
                <td><input name="txtConPassword" type="password" placeholder="Confirm Password"/></td>
                <td><span class="confpasserror" style="text-align: left;color: red;"></span></td>
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