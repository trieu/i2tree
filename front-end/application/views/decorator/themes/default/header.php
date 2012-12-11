<table width="100%" style="clear:both;">
    <tr>
        <td width="85%">
            <div class="page_logo">                
                <a href="<?php echo base_url() ?>" title="<?php echo lang('home_page_heading') ?>" >
                    <img src="<?php echo base_url() ?>common-assets/images/logo_pcmobiles.gif" />
                </a>
            </div>
        </td>
        <td width="15%" >
            <div style="float: right">
                <?php if ($is_login == TRUE): ?>                
                    <span class="vietnamese_english" >User: </span>
                    <a title="<?php echo $first_name; ?>" href="javascript:"><?php echo $login_name; ?></a>              
                    | <?php action_url_a('user_account/logout', 'Logout'); ?>              
                <?php endif; ?>
            </div>
        </td>
    </tr>
</table>

<div class="page_menu">
    <ul id="top_menu_bar" class="sf-menu">            
        <li class="current">
            <a href="javascript:" title="">Menu chức năng</a>
            <ul>
                <li>
                    <a href="javascript: " >Thông tin khuyến mãi</a>
                    <ul>
                        <li><?php action_url_a('mc2ads/add', 'Tạo mới'); ?></li>
                        <li><?php action_url_a('mc2ads/manage', 'Danh sách'); ?></li>                     
                    </ul>
                </li>
                <li>
                    <a href="javascript: " >Thông tin chung</a>
                    <ul>
                        <li><?php action_url_a('mc2ads_advertiser/manage', 'Thông tin giới thiệu'); ?></li>
                    </ul>
                </li>
            </ul>
        </li>            

    </ul>
</div>

<script type="text/javascript" language="JavaScript">
    
    jQuery(document).ready(function(){          
        jQuery('#top_menu_bar').superfish();
    });

    function switchPageToLanguage(from, to){
        var currentUrl = window.location + "";
        if(currentUrl == "<?php echo base_url(); ?>" ){
            currentUrl += "tiengviet.php";
        }
        currentUrl = currentUrl.replace(from, to);
        window.location = currentUrl;
    };
</script>