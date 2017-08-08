<script type="text/javascript" src="<?php echo base_url() ?>scripts/site/changePassword.js"></script>
<div class="mbFeedLeft form">
    <form class="custom-form" method="post">
        <table style="width: 98%;">
            <tr>
                <td colspan="3"><div class="updateStatus" style="text-align: left;color: red;"> </div></td>
            </tr>
            <tr>
                <td width="30%">
                    <label for="name">Old Password:</label>
                </td>
                <td width="30%">
                    <div data-role="fieldcontain">
                        <input type="password" name="oldPassword" id="name" value=""  />
                    </div>
                </td>
                <td><span class="oldpasserror" style="text-align: left;color: red;"></span></td>
            </tr>
            <tr>
                <td>
                    <label for="name">New Password:</label>
                </td>
                <td>
                    <div data-role="fieldcontain">
                        <input type="password" name="newPassword" id="name" value="" />
                    </div>
                </td>
                <td><span class="passerror" style="text-align: left;color: red;"></span></td>
            </tr>
            <tr>
                <td>
                    <label for="name">Confirm New Password:</label>
                </td>
                <td>
                    <div data-role="fieldcontain">
                        <input type="password" name="confNewPassword" id="name" value="" />
                    </div>
                </td>
                <td><span class="confpasserror" style="text-align: left;color: red;"></span></td>
            </tr>
            <tr>
                <td>
                    <label>&nbsp;</label>
                </td>
                <td>
                    <fieldset class="ui-grid-a">
                        <button type="submit" name="submit" data-theme="a">Update</button>
                    </fieldset>
                </td>
            </tr>
        </table>
    </form>
</div>