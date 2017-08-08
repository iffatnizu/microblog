<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Common extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUserInfoByUserId($userId = '') {
        $this->db->select('*');
        $this->db->from(DbConfig::TABLE_USER);
        $this->db->join(DbConfig::TABLE_USER_INFO, DbConfig::TABLE_USER_INFO . '.' . DbConfig::TABLE_USER_INFO_ATT_USER_ID.' = '.DbConfig::TABLE_USER . '.' . DbConfig::TABLE_USER_ATT_USER_ID, 'left');
        $this->db->where(DbConfig::TABLE_USER . '.' . DbConfig::TABLE_USER_ATT_USER_ID, $userId);
        return $this->db->get()->row_array();
    }
    
    public function getSitParameter() {
        $this->db->select(DBConfig::TABLE_SETTINGS_ATT_SITE_TITLE);
        $this->db->select(DBConfig::TABLE_SETTINGS_ATT_SITE_META_KEYWORD);
        $this->db->select(DBConfig::TABLE_SETTINGS_ATT_SITE_META_DESCRIPTION);
        $this->db->select(DBConfig::TABLE_SETTINGS_ATT_SITE_LOGO);
        $this->db->select(DBConfig::TABLE_SETTINGS_ATT_SITE_EMAIL);
        $this->db->select(DBConfig::TABLE_SETTINGS_ATT_SITE_PHONE);
        $this->db->select(DBConfig::TABLE_SETTINGS_ATT_SITE_DISPLAY_ADS_NO);
        

        return $this->db->get(DBConfig::TABLE_SETTINGS)->row_array();
    }

    public function getNameByUserId($userId = ''){
        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, $userId);
        $query = $this->db->get(DbConfig::TABLE_USER);
        if($query->num_rows() > 0){
            $result = $query->row_array();
            return $result[DbConfig::TABLE_USER_ATT_NAME];
        }
    }
    
    public function getAllAds()
    {
        $result = $this->db->get(DbConfig::TABLE_SETTINGS)->row_array();
        
        return $this->db->get(DbConfig::TABLE_ADS,$result[DbConfig::TABLE_SETTINGS_ATT_SITE_DISPLAY_ADS_NO])->result_array();
    }
    
    public function getSiteTitle() {
        $result = $this->db->get(DbConfig::TABLE_SETTINGS)->row_array();
        return $result[DbConfig::TABLE_SETTINGS_ATT_SITE_TITLE];
    }
    
    public function getNumOfUnreadMsgByUser($usrId)
    {
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID,$usrId);
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_IS_READ,'0');
        
        $r = $this->db->get(DbConfig::TABLE_CHAT_MESSAGE)->num_rows();
        
        //echo $this->db->last_query();
        
        return $r;
    }
}