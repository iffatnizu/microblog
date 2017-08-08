<div id=main role=main>

    <div id=main-content>
        <h1>Dashboard</h1>
        <p>Here you have a quick overview of some features</p>
        <div class=grid_12>
            <div class=block-border>
                <div class=block-content>
                    <ul class=shortcut-list>
                        <li> <a href="<?php echo site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_SITE_PARAMETER); ?>"> <i class="icon-cogs"></i>  <br/> Setting </a> </li>
                        <li> <a href="<?php echo site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_SITE_CONTENT . "about/" . urlencode('About Us') . ""); ?>"> <i class="icon-paper-clip"></i> <br/> Content Management </a> </li>
                        <li> <a href="<?php echo site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_AD_MANAGER); ?>"> <i class="icon-building"></i> <br/> Advertise Manager </a> </li>                      
                        <li> <a href="<?php echo site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_REPORTED_POSTS); ?>"> <i class="icon-briefcase"></i> <br/> Feed Management </a> </li>
                        <li> <a href="<?php echo site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LIST . 'user'); ?>"> <i class="icon-user"></i> <br/> User Management </a> </li>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
