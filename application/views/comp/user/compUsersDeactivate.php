<div class="mbFeedLeft">
    <div class="connectionList">
        <h4><i class="icon-remove"></i> Are you sure you want to deactivate your account?</h4>

        <p><small>Deactivating your account will disable your profile and remove your name and picture from most things you've shared on <?php echo base_url() ?>. Some information may still be visible to others, such as your name in their friends list and messages you sent.</small></p>

        <br class="clearfix"/>


        <hr/>

        <form action="<?php echo base_url() . SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_DEACTIVATE; ?>" method="POST">
            <table width="100%">
                <tr>
                    <td>Reason for leaving (Required):</td>
                    <td>
                        <?php
                        foreach ($dr as $d) {
                            ?>
                            <p style="margin: 5px;"> <input style="margin-right: 10px;" type="radio" name="leaving-reason" value="<?php echo $d[DbConfig::TABLE_ACCOUNT_DEACTIVATE_REASON_ATT_ID] ?>"/> <?php echo $d[DbConfig::TABLE_ACCOUNT_DEACTIVATE_REASON_ATT_REASON] ?> </p><br class="clearfix"/>

                            <?php
                        }
                        ?>
                            <span style="color: red;"><?php echo form_error('leaving-reason[]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Please explain further:</td>
                    <td>                   
                        <textarea name="explain" style="width: 430px; height: 131px;"></textarea> <span style="color: red;"><?php echo form_error('explain'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>                   
                        <input type="submit" class="btn btn-danger" name="confirm" value="Confirm"/> &nbsp;
                        <input style="margin-left: 10px;" type="reset" class="btn btn-default" name="cancel" value="Cancel"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>