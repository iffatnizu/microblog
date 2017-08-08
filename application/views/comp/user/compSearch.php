<script type="text/javascript" src="<?php echo base_url() ?>scripts/site/search.js"></script>
<script type="text/javascript">
    var userFollowUrl = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FOLLOW); ?>'
    var userConnectionUrl = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CONNECTION); ?>'
    var userUnfollow = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_UN_FOLLOW); ?>'
    var userDisconected = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_DISCONNECTED); ?>'
</script>
<div class="mbFeedLeft">
    <div class="connectionList">
        <h4><i class="icon-user"></i> Search Result</h4>

        <br class="clearfix"/>
        <?php
        //debugPrint($userList);
        if (!empty($userList)) {
            ?>

            <ul>
                <?php
                //debugPrint($usersList);
                foreach ($userList as $users) {
                    ?>
                    <li>
                        <a href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_USERS_FEED . '/' . $users[DbConfig::TABLE_USER_ATT_USER_ID]); ?>">
                            <?php if ($users['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                                <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $users['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                            <?php } else { ?>
                                <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
                            <?php } ?>

                            <span><?php echo $users['userDetail'][DbConfig::TABLE_USER_ATT_NAME]; ?></span>
                        </a>
                        <br class="clear" />
                        <?php
                        if ($this->session->userdata('userId') != $users[DbConfig::TABLE_USER_ATT_USER_ID]) {
                            ?>
                            <hr style="width: 100%;"/>
                            <?php
                            if ($users['isfollowed'] == '1') {
                                ?>
                                <a href="javascript:;" onclick="usersearch.userUnfollow('<?php echo $users['userDetail'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');"><i class="icon-remove"></i> Unfollow</a>
                                <?php
                            } else {
                                ?>
                                <a href="javascript:;" onclick="usersearch.userFollow('<?php echo $users['userDetail'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');"><i class="icon-arrow-down"></i> Follow</a>
                                <?php
                            }
                            if ($users['isConnnected'] == '1') {
                                ?>
                                <a href="javascript:;" onclick="usersearch.userDisconnect('<?php echo $users['userDetail'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');" style="float: right;"><i class="icon-unlink"></i> Disconnect</a>
                                <?php
                            } else {
                                ?>
                                <a href="javascript:;" onclick="usersearch.userConnection('<?php echo $users['userDetail'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');" style="float: right;"><i class="icon-unlink"></i> Connect</a>
                                <?php
                            }
                        }
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <br clear="all"/>
            <?php ?>
            <h6><?php echo sizeof($userList) ?> result found for <b><?php echo isset($_GET['u']) ? $_GET['u'] : "" ?></b></h6>
            <?php
        } else {
            ?>
            <h6>No result found</h6>
            <?php
        }
        ?>
    </div>
</div>