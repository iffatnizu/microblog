<script src="<?php echo base_url() ?>scripts/site/conversation.js" type="text/javascript"></script>
<div class="mbFeedLeft form">
    <div class="privateChat">
        <h3><i class="icon-envelope"></i> Message inbox </h3>
        <br clear="all"/>
        <?php
        //debugPrint($allmessage);
        if (!empty($allmessage)) {
            ?>
            <div class="msgTitleBox">
                <ul>
                    <?php
                    $i = 1;
                    foreach ($allmessage as $msg) {
                        ?>
                        <li id="pmid_<?php echo cxpencode($msg[DBConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID]) ?>">
                            <a id="pmaid_<?php echo cxpencode($msg[DBConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID]) ?>" class="pm_<?php echo $i; ?>" href="javascript:;" onclick="microblog.getAllMessageById('<?php echo cxpencode($msg[DBConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID]) ?>')">

                                <?php
                                if ($msg[DBConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID] == $this->session->userdata('userId')) {
                                    ?>
                                    <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $msg['receiverName'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" width="24" height="24" alt="receiver"/>
                                    <h6>Chat with <?php echo $msg['receiverName'][DbConfig::TABLE_USER_ATT_NAME]; ?></h6>
                                    <?php
                                } else {
                                    ?>
                                    <img src="<?php echo base_url() ?>assets/public/userProfileImage/<?php echo $msg['senderName'][DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]; ?>" width="24" height="24" alt="receiver"/>
                                    <h6>Chat with <?php echo $msg['senderName'][DbConfig::TABLE_USER_ATT_NAME]; ?></h6>
                                    <?php
                                }
                                ?>
                                <p>
                                    <small>
                                        From : <?php echo $msg['senderName'][DbConfig::TABLE_USER_ATT_NAME] ?><br class="clearfix"/>
                                        <span> Unread : <?php echo $msg['unread'] ?></span>
                                    </small>
                                </p>                       
                            </a>
                        </li>
                        <?php
                        $i++;
                    }
                    ?>
                </ul>
            </div>
            <div class="msgDeatilsBox">
                <div style="min-height: 420px;">
                    <div id="reportArea"></div><br clear="all"/>
                    <ul id="msgList">

                    </ul>
                </div>
                <div class="sendarea">
                    <div class="designelement">
                        <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/cpr_editor.js"></script>
                        <ul id="formateText">
                            <li><a onclick="changeStyle('bold')" href="javascript:;" class="btn"><i class="icon-bold"></i></a></li>
                            <li><a onclick="changeStyle('italic')" href="javascript:;" class="btn"><i class="icon-italic"></i></a></li>
                            <li><a onclick="changeStyle('underline')" href="javascript:;" class="btn"><i class="icon-underline"></i></a></li>                                                                                             
                            <li><a onclick="changeStyle('insertunorderedlist')" href="javascript:;" class="btn"><i class="icon-list-ul"></i></a></li>
                            <li><a onclick="changeStyle('indent')" href="javascript:;" class="btn"><i class="icon-indent-right"></i></a></li>
                            <li><a onclick="changeStyle('outdent')" href="javascript:;" class="btn"><i class="icon-indent-left"></i></a></li>
                            <li><a onclick="changeFontColor()" href="javascript::" class="btn"><i class="icon-pencil"></i></a></li>

                            <li><a onclick="changeLink()" href="javascript:;" class="btn"><i class="icon-font"></i></a></li>                    
                            <li><a onclick="changeStyle('justifyleft')" href="javascript:;" class="btn"><i class="icon-align-left"></i></a></li>
                            <li><a onclick="changeStyle('justifycenter')" href="javascript:;" class="btn"><i class="icon-align-center"></i></a></li>
                            <li><a onclick="changeStyle('justifyright')" href="javascript:;" class="btn"><i class="icon-align-right"></i></a></li> 
                            <li><a onclick="changeStyle('justifyfull')" href="javascript:;" class="btn"><i class="icon-align-justify"></i></a></li>
                        </ul>

                    </div>
                    <div class="sendMsgWriteArea">

                    </div>

                    <ul id="imoticons">
                        <?php
                        $imo = scandir('assets/public/imo');
                        foreach ($imo as $icon) {
                            if ($icon != '.' && $icon != '..') {
                                ?>
                        <li class="imo"> <a onclick="microblog.insertImo('<?php echo $icon ?>');" href="javascript:;"><img src="<?php echo base_url() ?>assets/public/imo/<?php echo $icon ?>" alt="img"/></a></li>
                                        <?php
                                    }
                            }
                       ?>
                    </ul>
                </div>

            </div>

            <br clear="all"/>
            <?php
        } else {
            echo '<h4>No conversation found</h4>';
        }
        ?>
    </div>
</div>