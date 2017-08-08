<div id=main role=main>
    <div id=main-content>

        <script type="text/javascript">
            function getAdType(value)
            {
                if(value!="")
                {
                    if(value=='1')
                    {
                        $("tr[id=script]").show();
                        $("tr[id=file]").hide();
                        $("tr[id=file_link]").hide();
                    }
                    else if(value=='2')
                    {
                        $("tr[id=script]").hide();
                        $("tr[id=file]").show();
                        $("tr[id=file_link]").show();
                    }
                }
            }
            function updateNumOfAdsDisplay(value)
            {
                if(value!="")
                {
                    $.ajax({
                        type:"GET",
                        url:"<?php echo base_url() . Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_UPDATE_NUM_OF_DISPLAY ?>",
                        data:{
                            "id":value
                        },
                        success:function(res)
                        {
                            if(res=='1')
                            {
                                alert("Setting Successfully Updated");
                            }
                        }
                    })
                }
            }
            function deleteAd(value)
            {
                var r = confirm("Are you sure ?");
                
                if(r)
                {
                    $.ajax({
                        type:"POST",
                        url:"<?php echo base_url() . Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_DELETE_ADVERTISEMENT ?>",
                        data:{
                            "id":value
                        },
                        success:function(res)
                        {
                            if(res=='1'){
                                location.reload();
                            }
                        }
                    })    
                }
            }
        </script>

        <?php
        if ($this->session->userdata('_success')) {
            echo '<p>Advetisement successfully updated</p>';
        }
        if ($this->session->userdata('sc_error')) {
            echo '<p>Please Insert Ad Script</p>';
        }
        if ($this->session->userdata('fi_error')) {
            echo '<p>Please Upload Ad Image</p>';
        }
        if ($this->session->userdata('li_error')) {
            echo '<p>Please Insert Image Link</p>';
        }
        if ($this->session->userdata('at_error')) {
            echo '<p>Please Select Ad Type</p>';
        }
        $session['_success'] = false;
        $session['sc_error'] = false;
        $session['fi_error'] = false;
        $session['at_error'] = false;
        $this->session->unset_userdata($session);
        ?>

        <h1>Site Parameter : Advertisement Manager</h1>




        <div class=grid_12>
            <div class=block-border>
                <div class=block-content>
                    <style>
                        p{
                            font-size: 11px;
                            color: red;
                        }
                    </style>
                    <table>
                        <?php
                        $s = "";
                        $s_ = "";
                        if ($siteInfo[DbConfig::TABLE_SETTINGS_ATT_SITE_DISPLAY_ADS_NO] == '3') {
                            $s = 'selected="selected"';
                        } elseif ($siteInfo[DbConfig::TABLE_SETTINGS_ATT_SITE_DISPLAY_ADS_NO] == '5') {
                            $s_ = 'selected="selected"';
                        }
                        ?>
                        <tr>
                            <td>Number of ad display </td>
                            <td>
                                <select name="display" onchange="updateNumOfAdsDisplay(this.value)">
                                    <option value="">-Please Select-</option>
                                    <option <?php echo $s; ?> value="3">3 ads</option>
                                    <option <?php echo $s_; ?> value="5">5 ads</option>
                                </select>
                            </td>
                        </tr>

                    </table>

                    <h4><i class="icon-star"></i> Add New</h4>
                    <hr/>
                    <form enctype="multipart/form-data" method="POST" action="<?php echo base_url() . Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_AD_MANAGER; ?>">
                        <table>
                            <tr>
                                <td style="width: 120px;">Ad Type</td>
                                <td>
                                    <select name="adType" onchange="getAdType(this.value)">
                                        <option value="">-Please Select-</option>
                                        <option value="1">Script</option>
                                        <option value="2">File</option>
                                    </select>
                                </td>
                            </tr>
                            <tr id="script" style="display: none;">
                                <td>Insert Ad Script</td>
                                <td>
                                    <textarea name="adScript"></textarea>
                                </td>
                            </tr>
                            <tr id="file_link" style="display: none;">
                                <td>Ad Link</td>
                                <td>
                                    <input type="text" name="adLink"/>
                                </td>
                            </tr>
                            <tr id="file" style="display: none;">
                                <td>Upload File</td>
                                <td>
                                    <input type="file" name="userfile"/>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                                <td>
                                    <input type="submit" class="btn btn-info" name="ad" value="Add"/>
                                </td>
                            </tr>

                        </table>
                    </form>

                    <h4><i class="icon-star"></i> View All</h4>
                    <hr/>
                    <ul class="ads">
                        <?php
                        //debugPrint($ads);
                        foreach ($ads as $ad) {
                            if ($ad[DbConfig::TABLE_ADS_ATT_AD_TYPE] == '2') {
                                ?>
                                <li class="ads"><a target="_new" href="http://<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_LINK]; ?>"><img src="<?php echo base_url() ?>assets/public/ads/<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_FILE_NAME]; ?>" alt="ads"/></a><a onclick="deleteAd('<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_ID]; ?>');" class="btn btn-danger" href="javascript:;">X</a></li>
                                <?php
                            } else {
                                ?>
                                <li id="<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_ID]; ?>" class="ads">
                                    <textarea  readonly="readonly" disabled="disabled" style="width: 185px;height: 270px;"><?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_SCRIPT] ?></textarea>
                                    <a onclick="deleteAd('<?php echo $ad[DbConfig::TABLE_ADS_ATT_AD_ID]; ?>');" class="btn btn-danger" href="javascript:;">X</a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>


    </div>
</div>
