<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Message extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->email->initialize($config);
    }

    public function sendMsgToUser($userId) {
        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, cxpdecode($_GET['id']));
        $result = $this->db->get(DbConfig::TABLE_USER)->row_array();

        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID, $userId);
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID, $result[DbConfig::TABLE_USER_ATT_USER_ID]);

        $check1 = $this->db->get(DbConfig::TABLE_CHAT_MESSAGE)->row_array();

        if (!empty($check1)) {
            $profileId = $check1[DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID];
        }

        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID, $result[DbConfig::TABLE_USER_ATT_USER_ID]);
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID, $userId);

        $check2 = $this->db->get(DbConfig::TABLE_CHAT_MESSAGE)->row_array();

        if (!empty($check2)) {
            $profileId = $check2[DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID];
        }
        
        if(empty($check1) && empty($check2))
        {
            $profileId = cxpdecode($_GET['id']);
        }


        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID] = $profileId;
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID] = $userId;
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_CHAT_MESSAGE] = $_GET['msg'];
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_TIME] = time();
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID] = $result[DbConfig::TABLE_USER_ATT_USER_ID];

        $i = $this->db->insert(DbConfig::TABLE_CHAT_MESSAGE, $data);

        if ($i) {
            return '1';
        }
    }

    public function getAllUserMsg($userId) {
        $sql = 'SELECT * FROM ' . DbConfig::TABLE_CHAT_MESSAGE . '
                WHERE ' . DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID . ' = "' . $userId . '" OR ' . DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID . ' = "' . $userId . '"
                GROUP BY ' . DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID . '
                ORDER BY ' . DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID . ' ASC
               ';
        //echo $sql;

        $r = $this->db->query($sql)->result_array();

        $data = array();

        foreach ($r as $row) {
            $row['senderName'] = userInfo($row[DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID]);
            $row['receiverName'] = userInfo($row[DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID]);
            $row['unread'] = $this->getUnreadMsg($row[DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID], $row[DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID]);
            array_push($data, $row);
        }

        return $data;
    }

    public function getUnreadMsg($receiverId, $feedId) {
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID, $feedId);
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_IS_READ, '0');
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID, $receiverId);

        $r = $this->db->get(DbConfig::TABLE_CHAT_MESSAGE)->num_rows();

        return $r;
    }

    public function getMessages($usrId) {
        $feedId = cxpdecode($_GET['fid']);
        
        
        
        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID, $usrId);
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_IS_READ] = '1';
        $this->db->set($data);
        $this->db->update(DbConfig::TABLE_CHAT_MESSAGE);
        
        

        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID, $feedId);
        $r = $this->db->get(DbConfig::TABLE_CHAT_MESSAGE)->result_array();

        $data = array();

        foreach ($r as $row) {
            $cssclass = "";
            $ownername = "";

            if ($row[DBConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID] == $this->session->userdata('userId')) {
                $cssclass = "displayright";
                $ownername = $this->getSenderName($row[DBConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID]);
            } else {
                $cssclass = "displayleft";
                $ownername = $this->getSenderName($row[DBConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID]);
            }



            $row['cssclass'] = $cssclass;
            $row['username'] = $ownername;
            array_push($data, $row);
        }

        return json_encode($data);
    }

    public function getSenderName($userId) {
        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, $userId);

        $r = $this->db->get(DbConfig::TABLE_USER)->row_array();

        return $r[DbConfig::TABLE_USER_ATT_NAME];
    }

    public function sendReply($userId) {

        $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID, cxpdecode($_POST['fid']));
        $this->db->order_by(DbConfig::TABLE_CHAT_MESSAGE_ATT_CHAT_ID,'DESC');
        $result = $this->db->get(DbConfig::TABLE_CHAT_MESSAGE,'1')->row_array();

        //echo $this->db->last_query();
        //debugPrint(cxpdecode($_POST['fid']).''.$userId);
        
        if($userId==$result[DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID])
        {
            $receiver = $result[DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID];
        }
        elseif($userId==$result[DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID])
        {
            $receiver = $result[DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID];
        }
//        else{
//            $receiver = $result[DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID];
//        }

        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_FEED_ID] = cxpdecode($_POST['fid']);
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID] = $userId;
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_CHAT_MESSAGE] = $_POST['replyMsg'];
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_TIME] = time();
        $data[DbConfig::TABLE_CHAT_MESSAGE_ATT_RECEIVER_ID] = $receiver;

        $i = $this->db->insert(DbConfig::TABLE_CHAT_MESSAGE, $data);

        $lastId = $this->db->insert_id();

        if ($i) {

            $this->db->where(DbConfig::TABLE_CHAT_MESSAGE_ATT_CHAT_ID, $lastId);
            $r = $this->db->get(DbConfig::TABLE_CHAT_MESSAGE)->row_array();
            $r['cssclass'] = "displayright";
            $r['username'] = $this->getSenderName($r[DbConfig::TABLE_CHAT_MESSAGE_ATT_SENDER_ID]);
            return json_encode($r);
        }
    }

}