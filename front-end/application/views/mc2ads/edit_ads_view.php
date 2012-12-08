<?php
if (isset($ads[0])) {
    $theAd = $ads[0];
}
?>
<div class="wpcf7" id="wpcf7-f473-p29-o1">
    <h3>Cập nhật quảng cáo</h3>
    <?php echo form_open_multipart('mc2ads/save'); ?>   
    <input type="hidden" name="id" value="<?php echo $theAd->id ?>" />
    <input type="hidden" name="image_url" value="<?php echo $theAd->image_url ?>" />
    <p>Ngày tạo: <?php echo date('d/m/Y', $theAd->creation_time) ?> </p>
    
    <p>Tiêu đề<br>
        <span class="wpcf7-form-control-wrap your-name"><input type="text" name="title" value="<?php echo $theAd->title ?>" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" size="40"></span> </p>
    <p>Nội chung chi tiết<br>
        <span class="wpcf7-form-control-wrap your-name">                
            <textarea name="description" rows="5" cols="60" ><?php echo $theAd->description ?></textarea>
        </span> 
    </p>
    
    <p>File hình quảng cáo<br>
        <span class="wpcf7-form-control-wrap your-email">
            <input type="file" name="image_ads" value="" />
        </span> 
    </p> 
    <p><input type="submit" value="Save" class="wpcf7-form-control  wpcf7-submit"><img class="ajax-loader" src="http://www.greengar.com/blog/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden; "></p>

</form>

</div>