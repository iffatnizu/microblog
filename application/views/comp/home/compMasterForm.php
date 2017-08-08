<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?> | Micro Blog</title>
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

        <link rel="shortcut icon" href="<?php echo base_url() ?>assets/ico/favicon.ico"/>
        <script type="text/javascript">
            var base_url = '<?php echo base_url() ?>';
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>scripts/site/site.js"></script>
        <link rel="stylesheet"  href="<?php echo base_url() ?>scripts/plugins/jm/css/jquery.mobile-1.2.0.css" />
        <script src="<?php echo base_url() ?>scripts/plugins/jm/js/jquery-1.7.1.min.js"></script>      
        <script src="<?php echo base_url() ?>scripts/plugins/jm/js/jquery.mobile-1.2.0.js"></script>
    </head>
    <body id="microblog">
        <div class="wrapper mainWrapper">
            <div class="mbUserFeed">
                <div class="mbCoverPhoto">
                    <img src="<?php echo base_url() ?>assets/images/demo-cover-img.png" alt="feed"/>
                </div>
                <div class="mbUserPhoto">
                    <img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/>
                </div>
                <div class="displayInfo">
                    Michael Peterson
                </div>
                <br class="clearfix"/>
                <!--feed---->
                <div class="mbFeedLeft form">
                    <form class="custom-form" action="<?php echo base_url() ?>home/customFormAction" method="post">

                        <table>
                            <tr>
                                <td>
                                    <label for="name">Text Input:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">
                                        <input type="text" name="name" id="name" value=""  />
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="textarea">Textarea:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">

                                        <textarea cols="40" rows="8" name="textarea" id="textarea"></textarea>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="search">Search Input:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">

                                        <input type="search" name="password" id="search" value=""  />
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="slider2">Flip switch:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">

                                        <select name="slider2" id="slider2" data-role="slider">
                                            <option value="off">Off</option>
                                            <option value="on">On</option>
                                        </select>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="slider">Slider:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">

                                        <input type="range" name="slider" id="slider" value="50" min="0" max="100" data-highlight="true"  />
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label>Choose as many snacks as you'd like:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">
                                        <fieldset data-role="controlgroup">

                                            <input type="checkbox" name="checkbox-1a" id="checkbox-1a" class="custom" />
                                            <label for="checkbox-1a">Cheetos</label>

                                            <input type="checkbox" name="checkbox-2a" id="checkbox-2a" class="custom" />
                                            <label for="checkbox-2a">Doritos</label>

                                            <input type="checkbox" name="checkbox-3a" id="checkbox-3a" class="custom" />
                                            <label for="checkbox-3a">Fritos</label>

                                            <input type="checkbox" name="checkbox-4a" id="checkbox-4a" class="custom" />
                                            <label for="checkbox-4a">Sun Chips</label>
                                        </fieldset>
                                    </div>
                                </td>

                            </tr>


                            <tr>
                                <td>
                                    <label>Choose a pet:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">
                                        <fieldset data-role="controlgroup">
                                            <input type="radio" name="radio-choice-1" id="radio-choice-1" value="choice-1" checked="checked" />
                                            <label for="radio-choice-1">Cat</label>

                                            <input type="radio" name="radio-choice-1" id="radio-choice-2" value="choice-2"  />
                                            <label for="radio-choice-2">Dog</label>

                                            <input type="radio" name="radio-choice-1" id="radio-choice-3" value="choice-3"  />
                                            <label for="radio-choice-3">Hamster</label>

                                            <input type="radio" name="radio-choice-1" id="radio-choice-4" value="choice-4"  />
                                            <label for="radio-choice-4">Lizard</label>
                                        </fieldset>
                                    </div>
                                </td>

                            </tr>



                            <tr>
                                <td>
                                    <label for="select-choice-a" class="select">Choose shipping method:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">

                                        <select name="select-choice-a" id="select-choice-a" data-native-menu="false">
                                            <option>Custom menu example</option>
                                            <option value="standard">Standard: 7 day</option>
                                            <option value="rush">Rush: 3 days</option>
                                            <option value="express">Express: next day</option>
                                            <option value="overnight">Overnight</option>
                                        </select>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <label for="select-choice-3" class="select">Your state:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">

                                        <select name="select-choice-3" id="select-choice-3">
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
                                        </select>
                                    </div>
                                </td>

                            </tr>

                            <tr>
                                <td>
                                    <label for="select-choice-1" class="select">Choose shipping method:</label>
                                </td>
                                <td>
                                    <div data-role="fieldcontain">

                                        <select name="select-choice-1" id="select-choice-1">
                                            <option value="standard">Standard: 7 day</option>
                                            <option value="rush">Rush: 3 days</option>
                                            <option value="express">Express: next day</option>
                                            <option value="overnight">Overnight</option>
                                        </select>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label>Button</label>
                                </td>
                                <td>
                                    <fieldset class="ui-grid-a">
                                        <button type="reset" name="reset" data-theme="d">Cancel</button><button type="submit" name="submit" data-theme="a">Submit</button>
                                    </fieldset>
                                </td>

                            </tr>
                        </table>
                    </form>
                </div>
                <!-------------->
                <div class="mbFeedRight">
                    <div class="follower">
                        <h3><i class="icon-group"></i> FOLLOWER</h3>
                        <ul>
                            <li>
                                <a href="#">
                                    <img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/>

                                    Petter Johnson
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/>

                                    Michael 
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="connection">
                        <h3><i class="icon-group"></i> CONNECTION</h3>
                        <ul>
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/></a></li>
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/></a></li>
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/blank-user-photo.png" alt="userImg"/></a></li>
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-2.png" alt="userImg"/></a></li>                     
                            <li><a href="#"><img src="<?php echo base_url() ?>assets/images/pro-pic-1.png" alt="userImg"/></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
