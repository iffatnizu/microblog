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
                                "sPaginationType": "full_numbers",
                                "bProcessing": true,
                                "bServerSide": true,
                                "sAjaxSource": "<?php echo site_url(Adminconfig::CONTROLLER_ADMINISTRATOR.Adminconfig::METHOD_ADMINISTRATOR_USER_LIST);?>"
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
                    <div id="dynamic">
                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                            <thead>
                                <tr>
                                    <td width="20%">User Name</td>
                                    <td width="25%">E-mail</td>
                                    <td width="15%">Status</td>
                                </tr>
                            </thead>
                            <tbody>

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
