<?php

define("JS_TEXT_DATA", 1);
define("JS_STRUCTURED_DATA", 2);
define("PREFIX_JS_DATA", 'setDataCallback(');
define("SUFFIX_JS_DATA", ');;');

/**
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_DB_active_record $db
 */
class js_data_model extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
        $this->load->helper('file');
    }

    function get($id) {
        $js_str = read_file("./js-data/$id.js");
        if (is_string($js_str)) {
            $json_str = str_replace(PREFIX_JS_DATA, '', $js_str);
            $json_str = str_replace(SUFFIX_JS_DATA, '', $json_str);
            return $json_str;
        } else {
            $status = array("message" => "$id is found in database");
            $json_str = json_encode($status);
            return $json_str;
        }
    }

    function insert($dataObj, $user_id = 0, $object_type = JS_TEXT_DATA, $indexedContent = '', $isIndexed = TRUE, $keyHints = '') {
        $this->initLuceneEngine();
        $id = $this->getId($keyHints);

        $dataObjStr = '';
        if (!is_string($dataObj)) {
            $dataObjStr = json_encode($dataObj);
        }
        $data = PREFIX_JS_DATA . ' ' . $dataObjStr . ' ' . SUFFIX_JS_DATA;
        if (write_file('./js-data/' . $id . '.js', $data)) {
            $indexer = $this->zend->get_Zend_Search_Lucene();

            $doc = new Zend_Search_Lucene_Document();
            $doc->addField(Zend_Search_Lucene_Field::Keyword('id', $id));
            $doc->addField(Zend_Search_Lucene_Field::Keyword('userid', $user_id));
            $doc->addField(Zend_Search_Lucene_Field::Keyword('object_type', $object_type));

            if ($isIndexed) {
                if ($object_type === JS_TEXT_DATA) {
                    $doc->addField(Zend_Search_Lucene_Field::UnStored("content", $indexedContent, 'utf-8'));
                    $doc->addField(Zend_Search_Lucene_Field::text("title", $dataObj['title'], 'utf-8'));
                } else if ($object_type === JS_STRUCTURED_DATA && is_string($dataObj)) {
                    $dataObj = json_decode($dataObj);

                    //unset Reserved Fields
                    unset($dataObj['id']);
                    unset($dataObj['userid']);
                    unset($dataObj['object_type']);

                    foreach ($dataObj as $key => $value) {
                        $doc->addField(Zend_Search_Lucene_Field::UnStored($key, $value, 'utf-8'));
                    }
                }
            }
            $indexer->addDocument($doc);
            $indexer->commit();
            //$indexer->optimize();
            return TRUE;
        }
        return FALSE;
    }

    function searchDocsByContent($q) {
        $hits = array();
        try {
            $this->initLuceneEngine();
            $indexer = $this->zend->get_Zend_Search_Lucene();

            $query = new Zend_Search_Lucene_Search_Query_Boolean();
            $subquery = Zend_Search_Lucene_Search_QueryParser::parse('+(' . $q . ')');
            $query->addSubquery($subquery, true);
            // $query->addSubquery(self::makeTermQuery('object_type', JS_TEXT_DATA), true);        
            $hits = $indexer->find($query);

            return $hits;
        } catch (Exception $e) {
            echo $e->getTraceAsString();
        }
        return $hits;
    }

    function update($dataObj) {
        
    }

    // seed with microseconds
    public function getId($keyHints = '') {
        if ($keyHints === '') {
            $toks = explode(' ', microtime());
            return str_replace(".", "", $toks[0] + $toks[1] + '');
        }
        return md5($keyHints);
    }

    private function initLuceneEngine() {
        $this->load->library('zend', 'Zend/Search/Lucene');
        $this->load->library('zend');
        $this->zend->load('Zend/Search/Lucene');
        Zend_Search_Lucene::setDefaultSearchField('content');
    }

    static function makeTermQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Term($term);
        return $query;
    }

    static function makeFuzzyQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Fuzzy($term);
        return $query;
    }

    static function makeWildcardQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Wildcard($term);
        return $query;
    }

    static function makePhraseQuery($fieldValue, $fieldName) {
        $query = new Zend_Search_Lucene_Search_Query_Phrase(array($fieldValue), null, $fieldName);
        return $query;
    }

}