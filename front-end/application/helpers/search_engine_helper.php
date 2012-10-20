<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('makeTermQuery')) {

    function makeTermQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Term($term);
        return $query;
    }

}

if (!function_exists('makeFuzzyQuery')) {

    function makeFuzzyQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Fuzzy($term);
        return $query;
    }

}

if (!function_exists('makeWildcardQuery')) {

    function makeWildcardQuery($fieldValue, $fieldName) {
        $term = new Zend_Search_Lucene_Index_Term($fieldValue, $fieldName);
        $query = new Zend_Search_Lucene_Search_Query_Wildcard($term);
        return $query;
    }

}

if (!function_exists('makePhraseQuery')) {

    function makePhraseQuery($fieldValue, $fieldName) {
        $query = new Zend_Search_Lucene_Search_Query_Phrase(array($fieldValue), null, $fieldName);
        return $query;
    }

}



   

    

     