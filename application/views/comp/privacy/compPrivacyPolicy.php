<div class="commonpages" style="background: #fff; padding: 15px; border-radius: 5px; margin-top: 5px;">
    <div>
        <h2><i class="icon-question-sign"></i> <?php echo $title ?> ...</h2>
        <div>
            <img width="128" src="<?php echo base_url() ?>assets/images/Gongdaobei-icon.png" alt="privacy" style="float: left;"/>

            <?php
            echo $content[DBConfig::TABLE_CONTENT_ATT_CONTENT_DETAILS];
            ?>
        </div>
    </div>
</div>