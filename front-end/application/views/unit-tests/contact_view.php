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
                PHP <input type="checkbox" name="position[]" value="PHP" />
                Java <input type="checkbox" name="position[]" value="Java" />
            </span> 
        </p>

        <p><input type="submit" value="Save" class="wpcf7-form-control  wpcf7-submit"><img class="ajax-loader" src="http://www.greengar.com/blog/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden; "></p>

    </form>

</div>