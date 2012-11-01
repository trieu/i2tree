<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('cleanUserInput')) {

    function cleanUserInput($dirty) {
        if (get_magic_quotes_gpc()) {
            $clean = mysql_real_escape_string(stripslashes($dirty));
        } else {
            $clean = mysql_real_escape_string($dirty);
        }
        return $clean;
    }

}

if (!function_exists('aesEncrypt')) {

    function aesEncrypt($sValue, $sSecretKey) {
        return trim(
                        base64_encode(
                                mcrypt_encrypt(
                                        MCRYPT_RIJNDAEL_256, $sSecretKey, $sValue, MCRYPT_MODE_ECB, mcrypt_create_iv(
                                                mcrypt_get_iv_size(
                                                        MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB
                                                ), MCRYPT_RAND)
                                )
                        )
        );
    }

}

if (!function_exists('aesDecrypt')) {

    function aesDecrypt($sValue, $sSecretKey) {
        return trim(
                        mcrypt_decrypt(
                                MCRYPT_RIJNDAEL_256, $sSecretKey, base64_decode($sValue), MCRYPT_MODE_ECB, mcrypt_create_iv(
                                        mcrypt_get_iv_size(
                                                MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB
                                        ), MCRYPT_RAND
                                )
                        )
        );
    }

}
