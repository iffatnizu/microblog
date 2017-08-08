<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"></meta>
        <title><?php echo $title; ?> | <?php echo getSiteTitle(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"></meta>
        <meta name="description" content="Your Local Catering"></meta>
        <meta name="keyword" content="directory, services, restaurent"></meta>
        <meta name="author" content=""></meta>
        <!-- Le styles -->

        <link href="<?php echo base_url() ?>assets/css/site.css" rel="stylesheet"/>
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/core/jquery-1.9.1.js"></script>
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
                  <script src="<?php echo base_url() ?>scripts/plugins/bootstrap/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->

        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/favicon.ico"/>
        <script type="text/javascript">
            var base_url = '<?php echo base_url() ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/site.js"></script>
    </head>
    <body id="microblog">
        <div class="wrapper mainWrapper">
            <div class="mbUserFeed">

                <?php
                if (isset($header)) {
                    echo $header;
                }
                ?>
                <?php
                if (isset($leftConaitner)) {
                    echo $leftConaitner;
                }
                ?>

                <div class="mbFeedRight">
                    <?php
                    if (isset($rightConaitner)) {
                        echo $rightConaitner;
                    }
                    ?>
                </div>
            </div>

            <?php
                if (isset($footer)) {
                    echo $footer;
                }
                ?>
            
        </div>


        <div id="lightBox">
            <div class="lightBoxContainer">
                <div class="lightBoxContent">
                    <div class="lightBoxTop">
                        <span class="lbtTitle">Title</span><span class="lbtStatus"></span>
                        <span class="lbtClose"><a onclick="removeLightBox()" href="javascript:;"><i class="icon-remove"></i></a></span>
                    </div>
                    <div class="lbtBody">

                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo base_url(); ?>scripts/plugins/bootstrap/bootstrap.js"></script> 
        <script type="text/javascript">
                !function ($) {
                $(function(){
                    // carousel demo
                    $('#myCarousel').carousel({
                        interval: 7000
                    })
                })
            }(window.jQuery)
        </script> 
        <script src="<?php echo base_url(); ?>scripts/plugins/bootstrap/holder.js"></script>
    </body>
</html>
