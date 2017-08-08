<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?> | <?php echo getSiteTitle(); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="Your Local Catering"/>
        <meta name="keyword" content="directory, services, restaurent"/>
        <meta name="author" content=""/>
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
            <div class="wrapper microblogContainer">
                <?php echo (isset($header)) ? $header : ''; ?>
                <?php echo (isset($content)) ? $content : ''; ?>
                <?php echo (isset($footer)) ? $footer : ''; ?>
            </div>
        </div>
    </body>
</html>
