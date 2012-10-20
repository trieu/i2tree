<?php

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class search_engine_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper(array('file', 'search_engine'));
    }

    function index($title, $content, $url, $keywords, $user_id) {
        $this->initLuceneEngine();
        $id = $this->getId($url);

        $indexer = $this->zend->get_Zend_Search_Lucene();

        $doc = new Zend_Search_Lucene_Document();
        $doc->addField(Zend_Search_Lucene_Field::Keyword('id', $id));
        $doc->addField(Zend_Search_Lucene_Field::Keyword('userid', $user_id));
        $doc->addField(Zend_Search_Lucene_Field::Keyword('url', $url));

        $doc->addField(Zend_Search_Lucene_Field::UnStored("content", $content, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::text("title", $title, 'utf-8'));
        $doc->addField(Zend_Search_Lucene_Field::text("keywords", $keywords, 'utf-8'));

        $indexer->addDocument($doc);
        $indexer->commit();
        //$indexer->optimize();
        return TRUE;
    }

    function searchDocsByContent($q, $userid) {
        $hits = array();
        try {
            $this->initLuceneEngine();
            $indexer = $this->zend->get_Zend_Search_Lucene();
            echo $indexer->count();         
            
            $query = Zend_Search_Lucene_Search_QueryParser::parse("(title:$q OR keywords:$q OR content:$q) AND userid:$userid");
//            var_dump($query);            
            
            $hits = $indexer->find($query);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
       //  var_dump($indexer);
       // var_dump($hits); exit;
        return $hits;
    }

    // seed with microseconds
    public function getId($keyHints = '') {
        if ($keyHints === '') {
            $toks = explode(' ', microtime());
            return str_replace(".", "", $toks[0] + $toks[1] + '');
        }
        return md5($keyHints);
    }

    protected function initLuceneEngine() {
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');
        Zend_Search_Lucene::setDefaultSearchField('content');
    }

}