<meta name="apple-itunes-app" content="app-id=301962306">
<link href="<?php echo base_url() ?>common-assets/css/responsive.css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/respond.src.js"></script>

<div data-role="page" class="type-home ui-page ui-body-c ui-page-active">
    <div data-role="content"  class="ui-content" role="main">
        <div class="content-secondary">
            <div id="header">
                <div class="ui-grid-a">
                    <div class="ui-block-a">
                        <p> Brain Tuner</p>
                        <p> Global Score</p>
                    </div>
                    <div class="ui-block-b">
                        <img width="80" height="80" alt="Brain Tuner Pro" src="http://a4.mzstatic.com/us/r1000/060/Purple/v4/b5/a5/30/b5a53095-47a4-59ce-d2e9-c8520989a812/mzl.ewtbgjct.175x175-75.jpg">
                    </div>
                </div>
            </div>
<div style = "padding-bottom: 1em; padding-top: 0.5em;">
            <select name="select-choice-0" id="select-choice-0" data-native-menu="false">
                <option value="20" data-theme="f">Problems: 20</option>
                <option value="60">Problems: 60</option>
                <option value="100">Problems: 100</option>
            </select></div>
	<select name="select-choice-0" id="select-choice-0" data-native-menu="false">
                <option value="date" data-theme="f">Daily Highscore</option>
                <option value="week">Weekly Highscore</option>
                <option value="all">All-time Highscore</option>
            </select>
            <ul data-role="listview" class="ui-listview ui-listview-inset ui-corner-all ui-shadow" data-dividertheme="f">
                <li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-f ui-corner-top">
                    My Rank
                </li>
                <li class="ui-corner-bottom ui-li-last">
                    <div class="ui-grid-a">
                        <div class="ui-block-a">Rank</div>
                        <div class="ui-block-b">12312312</div>
                    </div>
                    <div class="ui-grid-a">
                        <div class="ui-block-a">Name</div>
                        <div class="ui-block-b">12312312</div>
                    </div>
                    <div class="ui-grid-a">
                        <div class="ui-block-a">Time</div>
                        <div class="ui-block-b">12312312</div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="content-primary">
            <ul data-role="listview" class="ui-listview ui-listview-inset ui-corner-all ui-shadow" data-dividertheme="f">
                <li data-role="list-divider" role="heading" class="ui-li ui-li-divider ui-bar-f ui-corner-top">
                    <div class="float-left-col" style="width: 3em; padding-right: 1em;">Rank</div>
                    <div style="width: 5em; float: right; text-align: center;">Time</div>
                    <div class="date-col float-right-col" style="width: 6em;">Date</div>
                    <div class="device-col float-right-col" style="width: 4em;">Device</div>
                    <div style="text-align: center;">Name</div>
                </li>
            <?php
                $r = 1;
                foreach ($scorers as $scorer) { ?>
                <li <?php if($r==20) {?> class="ui-corner-bottom ui-li-last" <?php }?>>
                    <div class="float-left-col" style="width: 3em;"><?php echo $r++; ?></div>
                    <div class="float-left-col" style="width: 3em;">
                        <img class="flag-image" src="http://greengarstudios.com/bt2/common-assets/images/flags/32/<?php echo strtolower($scorer->country_code); ?>.png" alt="<?php echo strtolower($scorer->country_code); ?>"/>
                    </div>
                    <div class="float-right-col" style="width: 5em;"><?php echo number_format(floatval($scorer->finish_time), 3); ?></div>
                    <div class="date-col float-right-col" style="width: 6em;"><?php echo date('m/Y', $scorer->timestamp);?></div>
                    <div class="device-col float-right-col" style="width: 4em;">
                        <img class="device-image" src="http://greengarstudios.com/bt2/common-assets/images/devices/<?php echo $scorer->device == '' ? 'iPhone' : $scorer->device  ; ?>.png" alt="<?php echo $scorer->device == '' ? 'iPhone' : $scorer->device  ; ?>" style="height:1.5em"/>
                    </div>
                    <div style="white-space: nowrap;text-overflow: ellipsis;overflow: hidden;-moz-binding: url(ellipsis.xml#ellipsis); display:block; overflow:hidden">
                        <span style="margin:1px"><?php echo $scorer->name; ?></span>
                    </div>
                </li>
            <?php } ?>
            </ul>
            
        </div>
    </div>
        <div data-role="footer" class="footer-docs ui-footer ui-bar-c" data-theme="c" role="contentinfo">
            <p style="font-weight: normal;font-size: .9em;margin: 1em 15px;">© 2012 Greengar Studios</p>
        </div>
</div><!-- /page -->
