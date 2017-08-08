<div class="mbFeedLeft form">
    <?php if ($this->session->userdata('coverImageUpdate')) { ?>
        <div class="status" style="float: left; padding: 10px; color: green;">Cover photo successfully updated</div>
        <br clear="all" />
        <?php
        $data['coverImageUpdate'] = FALSE;
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
    <form class="custom-form" method="post" action="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CHANGE_COVER_IMAGE); ?>" enctype="multipart/form-data">
        <table>
            <tr>
                <td valign="top">
                    <label for="name">Previous Cover Image</label>
                </td>
                <td>
                    <img alt="Cover Image" src="<?php echo base_url() . SiteConfig::DIR_USER_COVER_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE]; ?>" title="Profile Image" style="width: 175px; height: 125px;" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="name">Upload new cover image:</label>
                </td>
                <td>
                    <div data-role="fieldcontain">
                        <input type="file" name="userfile" value=""  />
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