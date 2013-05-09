<?php
if (isset($ads[0])) {
    $obj = $ads[0];
?>
<div class="wpcf7" id="wpcf7-f473-p29-o1">
    <h3>Cập nhật thông tin giới thiệu</h3>
    <?php echo form_open_multipart('mc2ads_advertiser/save'); ?>   
    <input type="hidden" name="id" value="<?php echo $obj->id ?>" />
    
    <p>Ngày tạo: <?php echo date('d/m/Y', $obj->creation_time) ?> </p>
    
    <p>Tên<br>
        <span class="wpcf7-form-control-wrap your-name"><input type="text" name="name" value="<?php echo $obj->name ?>" size="40"></span> </p>
    <p>Nội chung chi tiết<br>
        <span class="wpcf7-form-control-wrap your-name">                
            <textarea name="description" rows="5" cols="60" ><?php echo $obj->description ?></textarea>
        </span> 
    </p>    
    
    <p><input type="submit" value="Save" class="wpcf7-form-control  wpcf7-submit"><img class="ajax-loader" src="http://www.greengar.com/blog/wp-content/plugins/contact-form-7/images/ajax-loader.gif" alt="Sending ..." style="visibility: hidden; "></p>

</form>

</div>

<script type="text/javascript" >
    $(document).ready(function(){
        $('textarea[name="description"]').cleditor({width:"99%", height:"260px"});
    });
</script>
<?php } else { ?>
<b>Không tìm thấy thông tin yêu cầu</b>
<?php } ?>
