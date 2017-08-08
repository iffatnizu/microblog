<?php

function debugPrint($object, $title = "", $isMarkup = false) {
    echo '<font color="red">Debug <<< START';
    if (!empty($title)) {
        echo "$title: ";
    }
    if ($isMarkup == false) {
        echo "<pre>";
        print_r($object);
        echo "</pre>";
    } else {
        echo htmlspecialchars($object);
    }
    echo 'END >>></font>';
}

function getUserInfoByUserId($userId = '') {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getUserInfoByUserId($userId);
}

function getSitParameter() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getSitParameter();
}

function getNameByUserId($userId = '') {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getNameByUserId($userId);
}

function getAllAds() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getAllAds();
}

function peopleYouMayKnow($userId) {
    $CI = &get_instance();
    $CI->load->model('model_user');
    return $CI->model_user->peopleYouMayKnow($userId);
}
function cxpencode($str='') {
    $str2 = base64_encode($str);
    $str3 = strrev($str2);
    $str4 = bin2hex($str3);
    $str5 = base64_encode($str4);
    $str6 = strrev($str5);
    $encrypt = bin2hex($str6);
    return $encrypt;
}

function cxpdecode($encrypt='') {
    $str = '';
    for ($i = 0; $i < strlen($encrypt) - 1; $i+=2) {
        $str .= chr(hexdec($encrypt[$i] . $encrypt[$i + 1]));
    }
    $str6 = strrev($str);
    $str5 = base64_decode($str6);
    $str4 = '';
    for ($i = 0; $i < strlen($str5) - 1; $i+=2) {
        $str4 .= chr(hexdec($str5[$i] . $str5[$i + 1]));
    }
    $str3 = strrev($str4);
    $decode = base64_decode($str3);
    return $decode;
}

function getSiteTitle() {
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getSiteTitle();
}

function getNumOfUnreadMsgByUser($usrId)
{
    $CI = &get_instance();
    $CI->load->model('model_common');
    return $CI->model_common->getNumOfUnreadMsgByUser($usrId);
}