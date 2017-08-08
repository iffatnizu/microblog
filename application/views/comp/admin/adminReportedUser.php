<div id=main role=main>
    <div id=main-content>
        <h1><?php echo $title ?></h1>

        <div class=grid_12>
            <div class=block-border>
                <div class=block-content>

                    <link href="<?php echo base_url() ?>scripts/plugins/datatable/css/demo_table_jui.css" rel="stylesheet" type="text/css"/>
                    <link href="<?php echo base_url() ?>assets/css/jquery-ui.css" rel="stylesheet" type="text/css"/>

                    <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>scripts/plugins/datatable/js/jquery.js"></script>
                    <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>assets/admin/js/user.js"></script>
                    <script type="text/javascript" language="javascript" src="<?php echo base_url() ?>scripts/plugins/datatable/js/jquery.dataTables.js"></script>
                    <script type="text/javascript" charset="utf-8">
                        $(document).ready(function() {
                            var oTable = $('#example').dataTable( {                               
                                "bJQueryUI": true,
                                "sPaginationType": "full_numbers"
                            });
                        } );
                    </script>
                    <style>
                        .ui-icon{
                            float: right;
                            margin-top: 4px;
                        }
                        .dataTables_info{
                            font-size: small;
                        }
                    </style>
                    <?php
                    //debugPrint($reportedUser);
                    ?>
                    <div id="dynamic">
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                            <thead>
                                <tr>
                                    <td width="25%">Report By</td>
                                    <td width="25%">Report To</td>
                                    <td width="25%">Reason</td>
                                    <td width="25%">Action</td>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($reportedUser as $usr) {
                                    ?>

                                    <tr>
                                        <td width="25%"><?php echo $usr['reportedBy'][DbConfig::TABLE_USER_ATT_NAME] ?></td>
                                        <td width="25%"><?php echo $usr['reportTo'][DbConfig::TABLE_USER_ATT_NAME] ?></td>
                                        <td width="25%"><?php echo $usr[DbConfig::TABLE_REPORTED_USERS_ATT_REPORT_REASON] ?></td>
                                        <td width="25%">

                                            <?php
                                            if ($usr['reportTo'][DbConfig::TABLE_USER_ATT_IS_ACTIVE] == '1') {
                                                ?>
                                                <a onclick="microblog.blockedUser('<?php echo $usr['reportTo'][DbConfig::TABLE_USER_ATT_EMAIL] ?>')" href="javascript:;" class="btn btn-small btn-danger">Block</a>
                                                <?php
                                            }
                                            elseif ($usr['reportTo'][DbConfig::TABLE_USER_ATT_IS_ACTIVE] == '0') {
                                                ?>
                                                <a onclick="microblog.unblockedUser('<?php echo $usr['reportTo'][DbConfig::TABLE_USER_ATT_EMAIL] ?>')" href="javascript:;" class="btn btn-small btn-info">Un Block</a>
                                                <?php
                                            }
                                            ?>

                                            <a onclick="microblog.deleteReport('<?php echo $usr[DbConfig::TABLE_REPORTED_USERS_ATT_ID] ?>')" href="javascript:;" class="btn btn-small btn-default"> Delete</a>
                                        </td>
                                    </tr>


                                    <?php
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>

                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
