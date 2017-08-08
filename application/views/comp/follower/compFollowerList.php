<div class="mbFeedLeft">
    <div class="connectionList">
        <h4><i class="icon-user"></i> Follower</h4>

        <br class="clearfix"/>
        <ul>
            <?php
            if (!empty($followerList)) {
                foreach ($followerList as $follower) {
                    ?>
                    <li>
                        <a href="javascript:;">
                            <?php if ($follower['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                                <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $follower['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                            <?php } else { ?>
                                <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
                            <?php } ?>

                            <span><?php echo $follower['userDetail'][DbConfig::TABLE_USER_ATT_NAME]; ?></span>
                        </a>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </div>
</div>