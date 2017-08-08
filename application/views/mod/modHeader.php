<!--header start-->
<?php
$site = getSitParameter();
//debugPrint($site);
?>
<div class="wrapper mbHeader"> 
    <a href="<?php echo site_url();?>">
        <img id="logo" src="<?php echo base_url() ?>assets/public/site/<?php echo $site[DbConfig::TABLE_SETTINGS_ATT_SITE_LOGO] ?>" width="100" alt="logo"/>
    </a>
</div>
<div class="wrapper mbSlogan">
    <p>
        <i class="icon-edit"></i>
        Microblog share your feelings ,connect with new people ,follow your favorite celebrity or <a href="<?php echo site_url(SiteConfig::CONTROLLER_HELP) ?>">learn more !</a>
    </p>
</div>