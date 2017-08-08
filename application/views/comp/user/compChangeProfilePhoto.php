<div class="mbFeedLeft form">
    <?php if ($this->session->userdata('profilePhotoUpdate')) { ?>
        <div class="status" style="float: left; padding: 10px; color: green;">Profile photo successfully updated</div>
        <br clear="all" />
        <?php
        $data['profilePhotoUpdate'] = FALSE;
        $this->session->unset_userdata($data);
    }
    ?>
    <?php if ($this->session->userdata('fileError')) { ?>
        <div class="status" style="float: left; padding: 10px; color: #f00;">
            <?php echo $this->session->userdata('fileError'); ?>
        </div>
        <br clear="all" />
        <?php
        $data['fileError'] = FALSE;
        $this->session->unset_userdata($data);
    }
    ?>
    <form class="custom-form" method="post" action="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CHANGE_PROFILE_PHOTO); ?>" enctype="multipart/form-data">
        <table>
            <tr>
                <td valign="top">
                    <label for="name">Previous Profile Image</label>
                </td>
                <td>
                    <img alt="userImg" src="<?php echo base_url() . SiteConfig::DIR_USER_PROFILE_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" title="Profile Image" style="width: 125px; height: 125px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="name">Upload new profile image:</label>
                </td>
                <td>
                    <div data-role="fieldcontain">
                        <input type="file" name="userfile"/>
                    </div>
                </td>
            </tr>            
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <label>&nbsp;</label>
                </td>
                <td>
                    <fieldset class="ui-grid-a">
                        <button type="submit" name="submit" data-theme="a">Upload</button>
                    </fieldset>
                </td>
            </tr>
        </table>
    </form>
</div>