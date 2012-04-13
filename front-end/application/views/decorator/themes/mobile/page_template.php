<!DOCTYPE html> 
<html> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <?php foreach ($page_decorator->getPageMetaTags() as $name => $content) { ?>
            <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
        <?php } ?>
        <title><?php echo $page_decorator->getPageTitle(); ?></title> 

        <link rel="stylesheet" href="<?php echo base_url() ?>common-assets/css/light.min.css" />
        <link rel="stylesheet"  href="<?php echo base_url() ?>common-assets/css/jquery.mobile.structure-1.0.1.min.css"/>         
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.mobile.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/js-data-handler.js"></script>
    </head> 
    <body> 
        <!-- Start of login page --> 
        <div data-role="page" id="login" data-theme="a" >		 
            <div data-role="header"  > 
                <h1>Login</h1> 
            </div><!-- /header --> 

            <div data-role="content">							
                <div data-role="fieldcontain">					
                    <input type="text" name="name" id="name" value="" placeholder="Username" />
                </div>
                <div data-role="fieldcontain">
                    <input type="password" name="password" id="password" value="" placeholder="Password" />
                </div>
                <a href="javascript: loginToServer()" data-role="button" data-icon="check" data-theme="c" class="ui-btn ui-btn-icon-left ui-btn-corner-all ui-shadow ui-btn-hover-c ui-btn-up-c">
                    <span class="ui-btn-inner ui-btn-corner-all">
                        <span class="ui-btn-text">OK</span><span class="ui-icon ui-icon-check ui-icon-shadow"></span>
                    </span>
                </a>
            </div><!-- /content --> 

            <div data-role="footer"> 
                <h4>Page Footer</h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 


        <div data-role="page" id="questions" data-theme="a" >		 
            <div data-role="header"  > 
                <h1>Câu hỏi Trắc nghiệm hướng nghiệp</h1> 
            </div><!-- /header --> 

            <div data-role="content">							
                <ul data-role="listview"> 
                    <li> 
                        1. Nếu có một buổi tối rảnh rỗi, bạn thích làm gì?
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="radio-choice-1" id="radio-mini-1" value="choice-1" checked="checked" />
                            <label for="radio-mini-1">a. Đi dự tiệc</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-2" value="choice-2"  />
                            <label for="radio-mini-2">b. Ở nhà và lướt web</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-3" value="choice-3"  />
                            <label for="radio-mini-3">c. Ghép hình, nghe nhạc</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-4" value="choice-4"  />
                            <label for="radio-mini-4">d. Đi xem phim</label>
                        </fieldset>
                    </li> 
                    <li> 

                    </li>
                    <li> 

                    </li> 
                    <li>	

                    </li> 
                </ul> 

            </div><!-- /content --> 

            <div data-role="footer"> 
                <h4></h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 


        <!-- Start of Worklist page --> 
        <div data-role="page" id="worklist"   > 		 
            <div data-role="header" data-theme="a"> 
                <h1>Worklist</h1> 
                <a href="#login" data-icon="home" data-iconpos="notext" data-direction="reverse" class="ui-btn-right jqm-home">Home</a> 
            </div><!-- /header --> 

            <div data-role="content"> 

                <ul data-role="listview"> 
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">Broken Bells</a></h3> 
                        <p>Broken Bells</p> 
                    </li> 
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">Warning</a></h3> 
                        <p>Hot Chip</p> 
                    </li>
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">Hot Fuss</a></h3> 
                        <p>Killers</p> 
                    </li> 
                    <li>	
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">The Suburbs</a></h3> 
                        <p>Arcade Fire</p> 
                    </li> 
                </ul> 		 

            </div><!-- /content --> 
            <div data-role="footer"> 
                <h4>Page Footer</h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 

        <!-- Start of study_details page --> 
        <div data-role="page" id="study_details" data-theme="a" data-add-back-btn="true"  > 		 
            <div data-role="header"> 
                <h1>Study Details</h1> 
            </div><!-- /header --> 

            <div data-role="content">	
                <a id="data_url" href="#" target="_blank" ></a>
                <div id="data_view" style="display: none;"></div>

                <script type="text/javascript" >                   

                    jQuery.cachedScript('http://localhost/js-data/13343024957621.js').done(function(script, textStatus) {
                        jQuery('#data_view').slideDown();
                    });
                </script>		
            </div><!-- /content --> 

            <div data-role="footer"> 
                <h4>Page Footer</h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 


        <script type="text/javascript" >
            var baseURL = window.location.href;
            $(document).ready(function(){
                //alert('done');
            });
			
            function loginToServer(){				
                window.location.href = baseURL + "#questions";
            }
        </script>

    </body>
</html>