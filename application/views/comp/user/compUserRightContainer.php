<?php
$mayKnow = peopleYouMayKnow($this->session->userdata('userId'));

//debugPrint($mayKnow);

if (!empty($mayKnow)) {
    ?>
    <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/search.js"></script>
    <script type="text/javascript">
        var userFollowUrl = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FOLLOW); ?>'
        var userConnectionUrl = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CONNECTION); ?>'
        var userUnfollow = '<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_UN_FOLLOW); ?>'
    </script>
    <div class="suggestion">
        <h3><i class="icon-user"></i> PEOPLE YOU MAY KNOW</h3>
        <ul>
            <?php
            foreach ($mayKnow as $suggestion) {
                ?>
                <li>
                    <span class="img">
                        <?php if ($suggestion['userDetails'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                            <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $suggestion['userDetails'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                        <?php } else { ?>
                            <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
                        <?php } ?>

                    </span>
                    <span class="op">
                        <a href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_USERS_FEED . '/' . $suggestion[DbConfig::TABLE_USER_ATT_USER_ID]); ?>"><?php echo $suggestion['userDetails'][DbConfig::TABLE_USER_ATT_NAME]; ?></a>
                        <br/>
                        <?php
                        if ($suggestion['isfollowed'] == '1') {
                            ?>
                            <a class="asu" href="javascript:;" onclick="usersearch.userUnfollow('<?php echo $suggestion['userDetails'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');"><i class="icon-remove"></i> Unfollow</a>
                            <?php
                        } else {
                            ?>
                            <a class="asu" href="javascript:;" onclick="usersearch.userFollow('<?php echo $suggestion['userDetails'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');"><i class="icon-arrow-down"></i> Follow</a>
                            <?php
                        }
                        if ($suggestion['isConnected'] == '1') {
                            ?>
                            <a class="asu" href="javascript:;" onclick="usersearch.userDisconnect('<?php echo $suggestion['userDetails'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');" style="float: right;"><i class="icon-unlink"></i> Disconnect</a>
                            <?php
                        } else {
                            ?>
                            <a class="asu" href="javascript:;" onclick="usersearch.userConnection('<?php echo $suggestion['userDetails'][DbConfig::TABLE_USER_ATT_USER_ID]; ?>');" style="float: right;"><i class="icon-unlink"></i> Connect</a>
                            <?php
                        }
                        ?>
                    </span>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>

    <?php
}
?>
<div class="follower">
    <h3><i class="icon-group"></i> FOLLOWER</h3>
    <ul>
        <?php
        if (!empty($followerList)) {
            foreach ($followerList as $follower) {
                ?>
                <li>
                    <a href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_USERS_FEED . '/' . $follower['userDetail'][DbConfig::TABLE_USER_INFO_ATT_USER_ID]); ?>">
                        <?php if ($follower['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                            <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $follower['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                        <?php } else { ?>
                            <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
                        <?php } ?>

                        <?php echo $follower['userDetail'][DbConfig::TABLE_USER_ATT_NAME]; ?>
                    </a>
                </li>
                <?php
            }
        }
        ?>
        <!--                            <li>
                                        <a href="#">
                                            <img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/>
        
                                            Michael 
                                        </a>
                                    </li>-->

    </ul>
</div>

<div class="connection">
    <h3><i class="icon-group"></i> CONNECTION</h3>
    <ul>
        <?php
        if (!empty($connectionList)) {
            foreach ($connectionList as $connection) {
                ?>
                <li>
                    <a href="<?php echo site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_USERS_FEED . '/' . $connection['userDetail'][DbConfig::TABLE_USER_INFO_ATT_USER_ID]); ?>">
                        <?php if ($connection['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] != '') { ?>
                            <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $connection['userDetail'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" alt="userImg"/>
                        <?php } else { ?>
                            <img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/>
                        <?php } ?>
                    </a>
                </li>
                <?php
            }
        }
        ?>
<!--                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/></a></li>                     
<li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>-->
    </ul>
</div>

<div class="follower">
    <h3><i class="icon-money"></i> ADVERTISEMENT</h3>
    <?php
    $ads = getAllAds();
    ?>
    <ul>
        <?php
        //debugPrint($ads);
        foreach ($ads as $ad) {
            if ($ad[DbConfig::TABLE_ADS_ATT_AD_TYPE] == '2') {
                ?>
                <li class="ads"><a target="_new" href="http://<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_LINK]; ?>"><img src="<?php echo base_url() ?>assets/public/ads/<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_FILE_NAME]; ?>" alt="ads"/></a></li>
                <?php
            } else {
                ?>
                <li id="<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_ID]; ?>" class="ads" style="overflow: hidden">
                    <?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_SCRIPT] ?>

                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>