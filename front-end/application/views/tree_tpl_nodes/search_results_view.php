<?php

if (isset($hits)) {
    $out = '';
    foreach ($hits as $hit) {
        $doc = $hit->getDocument();
        $out .= '<br /><a href="' . $doc->url . '">' . $doc->title . '</a></b><br />';
        $out .= 'keywords: ' . $doc->keywords . '<br />';
       // $out .= 'Score: ' . sprintf('%.6f', $hit->score) . '<br />';
    }
    echo $out;
}
?>