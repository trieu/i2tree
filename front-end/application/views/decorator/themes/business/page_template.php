<!DOCTYPE html> 
<html> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="distribution" content="global">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    <meta name=viewport content="width=device-width,user-scalable=yes" />


    <?php foreach ($page_decorator->getPageMetaTags() as $name => $content) { ?>
        <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
    <?php } ?>

    <base href="<?php echo base_url() ?>" />

    <title><?php echo $page_decorator->getPageTitle(); ?></title>

    <meta name="generator" content="i2tree 1.0">

    <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>common-assets/themes/business/style.css" type="text/css" media="screen" />

</head>
<body id="home" class="full_width">
    <div id="container" class="container_16">
        <div  class="header clearfix">
            <h1 id="logo">Greengar Studios</h1>
            <ul class="nav" style="display: none;">
                <li id="nav_home"><a href="http://www.greengar.com/">home</a></li>
                <li id="nav_about"><a href="http://www.greengar.com/about">about</a></li>
                <li id="nav_apps"><a href="http://www.greengar.com/apps">apps</a></li>
                <li id="nav_gallery"><a href="http://www.whiteboardgallery.com" target="_blank">gallery</a></li>
                <li id="nav_support"><a href="https://www.facebook.com/GreengarStudios/app_473520689340615" target="_blank">support</a></li>		
                <li id="nav_contact"><a href="http://www.greengar.com/contact">contact</a></li>
                <li id="nav_jobs"><a href="http://www.greengar.com/jobs">jobs</a></li>
            </ul>
        </div>



        <div id="content_primary" class="section">

            <div class="article">
                <div class="header">
                    <h1>Thông tin sinh viên</h1>
                </div>    

                <?php
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                    if ($id > 0) {
                        $url = base_url() . "/index.php/contact/";
                        echo "<h3>Cảm ơn bạn, thông tin đã được lưu</h3><script>setTimeout(function(){ location = '$url';  },2000);</script>";
                    }
                }
                ?>


                <div class="content">
                    <div class="wpcf7" id="wpcf7-f473-p29-o1">
                        <form action="<?php echo base_url() ?>/index.php/contact/save" method="post" class="wpcf7-form">

                            <p>Sinh viên năm<br>
                                <span class="wpcf7-form-control-wrap reason">
                                    <select name="year" class="wpcf7-form-control  wpcf7-select">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </span> 
                            </p>

                            <p>Tên<br>
                                <span class="wpcf7-form-control-wrap your-name"><input type="text" name="name" value="" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" size="40"></span> </p>
                            <p>Trường<br>
                                <span class="wpcf7-form-control-wrap your-name"><input type="text" name="school" value="DHBKHCM" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" size="40"></span> </p>
                            <p>Email<br>
                                <span class="wpcf7-form-control-wrap your-email"><input type="text" name="email" value="" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" size="40"></span> </p>
                            <p>Điện thoại<br>
                                <span class="wpcf7-form-control-wrap your-email"><input type="text" name="phone" value="" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" size="40"></span> </p>

                            <p>Vị trí ứng tuyển<br>
                                <span class="wpcf7-form-control-wrap reason">
                                    <select name="position" class="wpcf7-form-control  wpcf7-select">
                                        <option value="PHP Developer">PHP Developer</option>
                                        <option value="iOS Developer">iOS Developer</option>
                                        <option value="Designer">Designer</option>                        
                                    </select>
                                </span> 
                            </p>

                            <p><input type="submit" value="Save" class="wpcf7-form-control  wpcf7-submit"><img class="ajax-loader" src="http://www.greengar.com/blog/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden; "></p>
                            
                        </form>

                    </div>
                </div>
            </div>       
        </div>    
        <div id="content_secondary" class="aside">

        </div>
    </div>    





</body>
</html>