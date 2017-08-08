<script type="text/javascript" src="<?php echo base_url() ?>scripts/site/editProfile.js"></script>
<div class="mbFeedLeft form">
    <form class="custom-form" method="post">
        <table>
            <tr>
                <td colspan="3"><div class="updateStatus" style="text-align: left;color: red;"> </div></td>
            </tr>
            <tr>
                <td width="25%">
                    <label for="name">Name:</label>
                </td>
                <td width="50%">
                    <div data-role="fieldcontain">
                        <input type="text" name="name" id="name" value="<?php echo $userInfo[DbConfig::TABLE_USER_ATT_NAME]; ?>"  />
                    </div>
                </td>
                <td width="25%"><span class="nameerror" style="text-align: left;color: red;"></span></td>
            </tr>
            <tr>
                <td>
                    <label for="name">Email:</label>
                </td>
                <td>
                    <div data-role="fieldcontain">
                        <input type="text" name="name" id="name" value="<?php echo $userInfo[DbConfig::TABLE_USER_ATT_EMAIL]; ?>" readonly=""  />
                    </div>
                </td>
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