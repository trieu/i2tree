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
        <link rel="stylesheet"  href="<?php echo base_url() ?>common-assets/css/jquery.mobile.structure-1.1.0.min.css"/>         
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/jquery/jquery.mobile.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/js-data-handler.js"></script>
        <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
        <style type="text/css">
            .khoi {
                font:italic bold 12px/30px Georgia, serif;
            }
        </style>
        
    </head> 
    <body> 
        <!-- Start of login page --> 
        <div data-role="page" id="login" data-theme="a" >		 
            <div data-role="header"  > 
                <h1>Login</h1> 
            </div><!-- /header --> 

            <div data-role="content">		
                <form method="POST" class="ui-body ui-body-a ui-corner-all" data-ajax="false" >
                    <fieldset>
                        <div data-role="fieldcontain">					
                            <input type="text" name="email" id="email" value="" placeholder="Email" />
                        </div>
                        hoặc
                        <div data-role="fieldcontain">
                            <input type="text" name="phone" id="password" value="" placeholder="Số Điện thoại" />
                        </div>
                        
                        <button type="button" onclick="loginToServer()" data-theme="a" class="ui-btn-hidden" aria-disabled="false">Submit</button>
                    </fieldset>
                </form>
            </div><!-- /content --> 

            <div data-role="footer"> 
                <h4>Page Footer</h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 


        <div data-role="page" id="questions" data-theme="a" >		 
            <div data-role="header"  > 
                <h1>Trắc nghiệm hướng nghiệp</h1> 
            </div><!-- /header --> 

            <div data-role="content">	

                <ul data-role="listview" id="questionsOfText">                    
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
        <div data-role="page" id="worklist"  data-add-back-btn="true"  > 		 
            <div data-role="header" data-theme="a"> 
                <h1>Worklist</h1> 
                <a href="#login" data-icon="home" data-iconpos="notext" data-direction="reverse" class="ui-btn-right jqm-home">Home</a> 
            </div><!-- /header --> 

            <div data-role="content"> 

                <ul data-role="listview"> 
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/extrovert.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ENFJ')">ENFJ (Extrovert, Intuitive, Feeler, Judger)</a></h3> 
                        <p id="ENFJ" keywords="Báo chí">
                            Bạn là người dễ
                            cảm thông và độc đáo. Bạn thích làm việc trong môi trường ngăn nắp. Bạn
                            rất có trách nhiệm. Khi làm bất cứ việc gì, bạn thường dồn hết tâm trí
                            của mình vào đó.
                            *Bạn có thể trở thành một Chuyên viên quảng cáo, Biên tập tạp chí, Nhà sản xuất các chương trình TV, Nhân viên marketing, Nhà văn/Nhà báo.
                        </p> 
                    </li> 
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ENFP')">ENFP (Extrovert, Intuitive, Feeler, Perceiver)</a></h3> 
                        <p id="ENFP" keywords="Khoa học máy tính" >
                            Thật tuyệt vời! Bạn rất thông minh và luôn muốn học hỏi nhiều hơn. Bạn nói khá
                            nhiều và là người khá thoải mái. Bạn rất nhiệt tình, có nhiều sáng
                            kiến. Bạn thường dễ dàng vượt qua mọi khó khăn.
                            *Nghề nghiệp phù hợp với bạn: Nhân viên quảng cáo, chuyên viên Phát triển phần mềm, Nhà báo, Nhà thiết kế, Giám đốc sáng tạo.
                        </p> 
                    </li>
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ENTJ')">ENTJ (Extrovert, Intuitive, Thinker, Judger)</a></h3> 
                        <p id="ENTJ" keywords="Tài chính" >
                            Bạn khá thân thiện với mọi người. Tuy nhiên bạn là người rất kiên quyết và thẳng tính. Vì vậy bạn có thể làm tổn thương người khác. Bạn rất quyết đoán và ngăn nắp.
                            *Bạn có thể trở thành: Giám đốc điều hành, Tư vấn viên, chuyên viên nhà đất, Nhân viên marketing, Nhà phân tích tài chính.
                        </p> 
                    </li>    
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ENTP')">ENTP (Extrovert, Intuitive, Thinker, Perceiver)</a></h3> 
                        <p id="ENTP" keywords="ngân hàng" >
                            Bạn rất có duyên. Mọi người đều thích bạn vì bạn là người thân thiện và thoải mái. Bạn rất sáng tạo, nhưng cũng dễ thay đổi. Khả năng phân tích của bạn khá tốt.
                            *Bạn nên làm những công việc: Đầu tư ngân hàng, Người viết quảng cáo, Hoạch định chiến lược, Phát thanh viên radio/TV.
                        </p> 
                    </li>
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ESFJ')">ESFJ (Extrovert, Sensor, Feeler, Judger)</a></h3> 
                        <p id="ESFJ" keywords="kinh doanh" >
                            Bạn rất năng động và tràn đầy nhiệt huyết. Tuy nhiên bạn khá nhạy cảm và dễ bị tổn thương. Bạn là người ngăn nắp và có trách nhiệm. Bạn không thích sự thay đổi.
                            *Bạn có thể là một chuyên gia kinh doanh Bất động sản, Bác sĩ thú y, Giáo viên, Y tá, Nhân viên kinh doanh, Nhân viên du lịch.
                        </p> 
                    </li>
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ESFP')">ESFP (Extrovert, Sensor, Feeler, Perceiver)</a></h3> 
                        <p id="ESFP" keywords="Bác sĩ" >
                            Bạn khá thoải mái và khôi hài. Vì vậy đừng ngạc nhiên khi thỉnh thoảng bạn cảm thấy mình hơi bốc đồng nhé! Tuy nhiên bạn rất ham học hỏi. Bạn rất năng động và yêu các hoạt động xã hội.
                            *Bạn có thể trở thành một Giáo viên mầm non, Bác sĩ chuyên khoa, Bác sĩ thú y, Nha sĩ.
                        </p> 
                    </li>
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ESTJ')">ESTJ (Extrovert, Sensor, Thinker, Judger)</a></h3> 
                        <p id="ESTJ" keywords="kinh doanh" >
                            Bạn có khuynh hướng nói thẳng những điều bạn nghĩ. Bạn rất thực tế, khó thay đổi ý kiến và nghiêm túc. Bạn yêu thích tính truyền thống và rất giỏi quyết định mọi chuyện.
                            *Bạn có thể trở thành Nhân viên kinh doanh, Nhân viên bất động sản, Dược sĩ, Sĩ quan.
                        </p> 
                    </li>
                    <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('ESTP')">ESTP (Extrovert, Sensor, Thinker, Perceiver)</a></h3> 
                        <p id="ESTP" keywords="Du lịch , Kỹ sư, Chứng khoán" >
                            Bạn là người năng động, vui vẻ và quyến rũ nhưng hơi bốc đồng. Bạn thích thử thách và luôn luôn muốn học hỏi thêm nhiều điều mới lạ. Bạn cũng là người hiếu kỳ, điềm đạm và suy nghĩ lôgic.
                            *Bạn có thể trở thành Nhân viên y tế, Môi giới chứng khoán, Nhân viên bảo hiểm, Kỹ sư, Nhân viên du lịch.
                        </p> 
                    </li>
                     <li> 
                        <img src="http://dl.dropbox.com/u/4074962/database/perceiver.jpg" /> 
                        <h3><a href="javascript:getResultDetails('INFJ')">INFJ (Introvert, Intuitive, Feeler, Judger)</a></h3> 
                        <p id="INFJ" keywords="Sư phạm" >
                            Bạn khá sáng tạo và có khả năng làm việc độc lập. Bạn luôn luôn suy nghĩ kĩ trước khi làm bất cứ việc gì. Bạn luôn dành hết đam mê cho những gì mình làm.
                            *Nghề nghiệp phù hợp với bạn là: Giáo viên, Chuyên viên huấn luyện, Biên tập viên, Giám đốc sáng tạo, Nhà văn.
                        </p> 
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
                <div style="margin: 10px 0px" >
                     <select id="chon_khoi" >
                        <option value="khoi_a">Khối A</option>
                        <option value="khoi_b">Khối B</option>
                        <option value="khoi_c">Khối C</option>
                        <option value="khoi_d">Khối D</option>
                    </select>
                    <div id="khoi_a" class="khoi">              
                        Điểm trung bình Toán:<input type="text" value="" />
                        Điểm trung bình Lý:<input type="text" value="" />
                        Điểm trung bình Hóa:<input type="text" value="" />
                    </div>
                    <div id="khoi_b" class="khoi">              
                        Điểm trung bình Toán:<input type="text" value="" />
                        Điểm trung bình Sinh:<input type="text" value="" />
                        Điểm trung bình Hóa:<input type="text" value="" />
                    </div>
                    <div id="khoi_c" class="khoi">              
                        Điểm trung bình Văn:<input type="text" value="" />
                        Điểm trung bình Sử:<input type="text" value="" />
                        Điểm trung bình Địa:<input type="text" value="" />
                    </div>
                    <div id="khoi_d" class="khoi" >              
                        Điểm trung bình Toán:<input type="text" value="" />
                        Điểm trung bình Văn:<input type="text" value="" />
                        Điểm trung bình Anh:<input type="text" value="" />
                    </div>
                </div>
               
                <div id="result_details"></div>
                <button type="button" onclick="doSearchSchool()" data-theme="a" class="ui-btn-hidden" aria-disabled="false">Tìm trường</button>
                               
                <div id="data_view" style="display: none;"></div>
            </div><!-- /content --> 

            <div data-role="footer"> 
                <h4></h4> 
            </div><!-- /footer --> 
        </div><!-- /page --> 


        <script id="questionTemplate" type="text/x-jquery-tmpl" >
            <li> 
                ${question}
                <fieldset data-role="controlgroup" data-mini="true">
                    {{each options}}                    
                        <input type="radio" name="question-${id}" id="option-${id}-${$index}" value="${id}-${$index}" />
                        <label for="option-${id}-${$index}">${$value}</label>                  
                    {{/each}}     
                </fieldset>
            </li> 
        </script>

    <script type="text/javascript" >
        var baseURL = window.location.href;
        $(document).ready(function(){
            jQuery.getScript('<?php echo base_url() ?>/js-data/questions/test1.js');
        });
			
        function loginToServer(){	
            $.mobile.showPageLoadingMsg();
            var data = {'email' : $('#email').val(), 'password': $('#password').val()};
            var url = "<?php echo site_url('user_account/login') ?>";
            $.post(url, data, function(rs){
                if(rs === 'true'){
                    window.location.href = baseURL + "#questions";
                }     
                $.mobile.hidePageLoadingMsg();
            });
            return false;                
        }
            
        function submitTestAnswers(){
            $.mobile.showPageLoadingMsg();
            var data = {};
            var url = "<?php echo site_url('user_account/login') ?>";
            $.post(url, data, function(rs){
                if(true){                    
                    $.mobile.changePage("#worklist", "transition");
                }     
                $.mobile.hidePageLoadingMsg();
            });           
        }
        
        function doSearchSchool(){      
            $.mobile.showPageLoadingMsg();
            var url = "<?php echo site_url('/unit-tests/crawler_api/search_by_keywords?q=') ?>"+encodeURIComponent( $('#q_keywords').text());
            $.get(url, function(rs){ 
                $('#data_view').html(rs).show();                
                $.mobile.hidePageLoadingMsg();
            }); 
        }
        
        function getResultDetails(id){
            $.mobile.changePage("#study_details", "transition"); 
            var html = $('#'+id).text();  
           // var keywordFestures = ["Khoa học máy tính","Báo chí","Kinh tế","Toán tin","Tài chính"];
            //var keywords = keywordFestures[Math.floor(Math.random()*keywordFestures.length)];
            var keywords = $('#'+id).attr('keywords');
            $('#result_details').html( html + "<br>Keywords: <b id='q_keywords'>" + keywords + "</b>");
            $('.khoi').hide();            
        }
        
        $('#chon_khoi').change(function(){
            $('.khoi').hide();
            $('#'+ $(this).find('option:selected').val() ).show();
        });
        
        
    </script>

</body>
</html>