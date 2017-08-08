<?php

function getEmailIsExists($email = '') {
    $CI = &get_instance();
    $CI->load->model('model_user');
    return $CI->model_user->getEmailIsExists($email);
}

function getOldPasswordStatus($userId = '', $password = '') {
    $CI = &get_instance();
    $CI->load->model('model_user');
    return $CI->model_user->getOldPasswordStatus($userId, $password);
}

function userInfo($userId)
{
    $CI = &get_instance();
    $CI->load->model('model_user');
    return $CI->model_user->userInfo($userId);
}
