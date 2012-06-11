<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Album <?php echo $album_name; ?></title>
        <style>           
            html,body{background:#222;margin:0;}
            body{border-top:4px solid #000;}
            .content{color:#777;font:12px/1.4 "helvetica neue",arial,sans-serif;width:620px;margin:20px auto;}
            h1{font-size:12px;font-weight:normal;color:#ddd;margin:0;}
            p{margin:0 0 20px}
            a {color:#22BCB9;text-decoration:none;}
            .cred{margin-top:20px;font-size:11px;}

            /* This rule is read by Galleria to define the gallery height: */
            #galleria{height:320px}
        </style>

        <!-- load jQuery -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>

        <!-- load Galleria -->
        <script src="http://dl.dropbox.com/u/4074962/image-gallery/galleria-1.2.7.min.js"></script>

    </head>
    <body>
        <div class="content">
            <h1><?php echo $album_name; ?></h1>
            <p><?php echo $album_des; ?></p>

           

            <div id="galleria">
                <a href="http://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Locomotives-Roundhouse2.jpg/800px-Locomotives-Roundhouse2.jpg">
                    <img data-title="Locomotives Roundhouse"
                         data-description="Steam locomotives of the Chicago &amp; North Western Railway."
                         src="http://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Locomotives-Roundhouse2.jpg/100px-Locomotives-Roundhouse2.jpg">
                </a>
                <a href="http://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Icebergs_in_the_High_Arctic_-_20050907.jpg/1000px-Icebergs_in_the_High_Arctic_-_20050907.jpg">
                    <img data-title="Icebergs in the High Arctic"
                         data-description="”The debris loading isn't particularly extensive, but the color is usual.”"
                         src="http://upload.wikimedia.org/wikipedia/commons/thumb/3/36/Icebergs_in_the_High_Arctic_-_20050907.jpg/100px-Icebergs_in_the_High_Arctic_-_20050907.jpg">
                </a>               
            </div>

            <p class="cred">Made by <a href="https://chrome.google.com/webstore/detail/cabfaempdhicccliekdlhcimlgldoeeo" target="_blank">i2tree Selector</a>.</p>
        </div>

        <script>
            // Load the classic theme
            Galleria.loadTheme('http://dl.dropbox.com/u/4074962/image-gallery/galleria.classic.min.js');
            // Initialize Galleria
            Galleria.run('#galleria');
        </script>
    </body>
</html>