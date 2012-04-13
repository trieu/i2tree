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
                        1. Nếu mô tả về mình, bạn là người:
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="radio-choice-1" id="radio-mini-1" value="choice-1" checked="checked" />
                            <label for="radio-mini-1">a. Nói nhiều hơn là nghe người khác nói.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-2" value="choice-2"  />
                            <label for="radio-mini-2">b. Lắng nghe người khác nhiều hơn là nói.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-3" value="choice-3"  />
                            <label for="radio-mini-3">c. Chú ý các tiểu tiết. </label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-4" value="choice-4"  />
                            <label for="radio-mini-4">d. Chú ý bức tranh toàn cảnh và những việc có thể xảy ra.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-5" value="choice-5"  />
                            <label for="radio-mini-5">e. Quyết định mọi việc rất khách quan. </label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-6" value="choice-6"  />
                            <label for="radio-mini-6">f. Quyết định mọi việc theo giá trị riêng của chúng và cảm nhận của bạn.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-7" value="choice-7"  />
                            <label for="radio-mini-7">g. Thực hiện đúng kế hoạch đặt ra, không muốn thay đổi.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-8" value="choice-8"  />
                            <label for="radio-mini-8">h. Linh hoạt khi thực hiện các kế hoạch.</label>
                        </fieldset>
                    </li> 
                    <li> 
                        2. Trong những buổi họp mặt hay tranh luận cùng bạn bè, bạn … 
                        <fieldset data-role="controlgroup" data-mini="true">
                            <input type="radio" name="radio-choice-1" id="radio-mini-1" value="choice-1" checked="checked" />
                            <label for="radio-mini-1">a. Nói nhiều hơn là nghe người khác nói.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-2" value="choice-2"  />
                            <label for="radio-mini-2">b. Lắng nghe người khác nhiều hơn là nói.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-3" value="choice-3"  />
                            <label for="radio-mini-3">c. Chú ý các tiểu tiết. </label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-4" value="choice-4"  />
                            <label for="radio-mini-4">d. Chú ý bức tranh toàn cảnh và những việc có thể xảy ra.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-5" value="choice-5"  />
                            <label for="radio-mini-5">e. Quyết định mọi việc rất khách quan. </label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-6" value="choice-6"  />
                            <label for="radio-mini-6">f. Quyết định mọi việc theo giá trị riêng của chúng và cảm nhận của bạn.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-7" value="choice-7"  />
                            <label for="radio-mini-7">g. Thực hiện đúng kế hoạch đặt ra, không muốn thay đổi.</label>

                            <input type="radio" name="radio-choice-1" id="radio-mini-8" value="choice-8"  />
                            <label for="radio-mini-8">h. Linh hoạt khi thực hiện các kế hoạch.</label>
                        </fieldset>
                    </li>                                
                </ul> 
                <a href="javascript: submitTestAnswers()" data-role="button" data-icon="check" data-theme="c" class="ui-btn ui-btn-icon-left ui-btn-corner-all ui-shadow ui-btn-hover-c ui-btn-up-c">
                    <span class="ui-btn-inner ui-btn-corner-all">
                        <span class="ui-btn-text">Gửi câu trả lời</span><span class="ui-icon ui-icon-check ui-icon-shadow"></span>
                    </span>
                </a>
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
                        <h3><a href="#study_details">ENFJ (Extrovert, Intuitive, Feeler, Judger)</a></h3> 
                        <p>
                            Bạn là người dễ cảm thông và độc đáo. Bạn thích làm việc trong môi trường ngăn nắp. Bạn
                            rất có trách nhiệm. Khi làm bất cứ việc gì, bạn thường dồn hết tâm trí
                            của mình vào đó.
                        </p> 
                    </li> 
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">ENFP (Extrovert, Intuitive, Feeler, Perceiver)</a></h3> 
                        <p>Thật tuyệt
                            vời! Bạn rất thông minh và luôn muốn học hỏi nhiều hơn. Bạn nói khá
                            nhiều và là người khá thoải mái. Bạn rất nhiệt tình, có nhiều sáng
                            kiến. Bạn thường dễ dàng vượt qua mọi khó khăn.</p> 
                    </li>
                    <li> 
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">Hot Fuss</a></h3> 
                        <p>Bạn khá thân thiện với mọi người. 
                            Tuy nhiên bạn là người rất kiên quyết và thẳng tính. 
                            Vì vậy bạn có thể làm tổn thương người khác. Bạn rất quyết đoán và ngăn nắp.
                        </p> 
                    </li> 
                    <li>	
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">The Suburbs</a></h3> 
                        <p>Arcade Fire</p> 
                    </li> 
                    <li>	
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">The Suburbs</a></h3> 
                        <p>Arcade Fire</p> 
                    </li> 
                    <li>	
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">The Suburbs</a></h3> 
                        <p>Arcade Fire</p> 
                    </li> 
                    <li>	
                        <img src="http://farm4.static.flickr.com/3222/2707565362_1bb79fa7d8.jpg" /> 
                        <h3><a href="#study_details">The Suburbs</a></h3> 
                        <p>Arcade Fire</p> 
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
            
            function submitTestAnswers(){
                //TODO 
                window.location.href = baseURL + "#worklist";
            }
        </script>

    </body>
</html>