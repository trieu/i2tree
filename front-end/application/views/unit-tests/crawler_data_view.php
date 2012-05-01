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
        $out .= '<br /><a href="javascript:showRecord(\'' . $doc->id . '\')">' . $doc->title . '</a></b><br />';
        // $out .= 'content: ' . $hit->getDocument()->content . '<br />';
        $out .= 'Score: ' . sprintf('%.6f', $hit->score) . '<br />';
    }
    echo $out;
}
?>

<script type="text/javascript" >    
    function getSelectionHtml() {
        var html = "";
        if (typeof window.getSelection != "undefined") {
            var sel = window.getSelection();
            if (sel.rangeCount) {
                var container = document.createElement("div");
                for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                    container.appendChild(sel.getRangeAt(i).cloneContents());
                }
                html = container.innerHTML;
            }
        } else if (typeof document.selection != "undefined") {
            if (document.selection.type == "Text") {
                html = document.selection.createRange().htmlText;
            }
        }
        document.aform.selectedtext.value = html;
        jQuery('#textContent').html(html);
        return html;
    }
    function getSelText() {
        var txt = '';
        if (window.getSelection) {
            txt = window.getSelection();
        } else if (document.getSelection) {
            txt = document.getSelection();
        } else if (document.selection) {
            txt = document.selection.createRange().text;
        } else return;
       // alert(txt);
        document.aform.selectedtext.value = txt;
    }
</script>
<input type="button" value="Get selection" onmousedown="getSelectionHtml();"> 
<form name=aform >
    <textarea name="selectedtext" rows="5" cols="20"></textarea>
</form>
<div id="textContent" ></div>