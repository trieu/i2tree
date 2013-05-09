<?php if ($status === 'save_ok') { ?>
    <h3>OK, đang chuyển trang ...</h3>
<?php } else if ($status === 'fail') { ?>
    <h3>hệ thống đang có lỗi! Vui lòng thử lại, đang chuyển trang ...</h3>
<?php } ?>
    
<script>
    setTimeout(function(){
        location.href = '<?php echo $redirect_url ?>';
    }, 2000);
</script>