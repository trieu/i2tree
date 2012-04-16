<script type="text/javascript" src="<?php echo base_url() ?>common-assets/js/js-data-handler.js"></script>

<a id="data_url" href="#" target="_blank" ></a>
<div id="data_view" style="display: none;"></div>

<script type="text/javascript" >
    var baseUrl = '<?php echo base_url("/js-data/") ?>/';
    function showRecord(id) {        
        var url = baseUrl + id + '.js';
        jQuery.cachedScript(url).done(function(script, textStatus) {
            jQuery('#data_view').slideDown();
        });
    }
    
<?php if (isset($id)) { ?>
        showRecord('<?php echo $id ?>');            
<?php } ?>
    
</script>


<?php
if (isset($hits)) {
    $out = '';
    foreach ($hits as $hit) {
        $doc = $hit->getDocument();
        $out .= '<br /><a href="javascript:showRecord(' . $doc->id . ')">'. $doc->title .'</a></b><br />';
        // $out .= 'content: ' . $hit->getDocument()->content . '<br />';
        $out .= 'Score: ' . sprintf('%.6f', $hit->score) . '<br />';
    }
    echo $out;
}
?>