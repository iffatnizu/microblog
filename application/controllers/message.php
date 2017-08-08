<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class Message extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation', 'email', 'session'));
        $this->load->helper('user');
        $this->load->model('model_message');
        $this->load->model('model_user');
    }

    public function index() {
        $this->inbox();
    }

    public function sendMsgToUser() {
        if ($this->session->userdata('userLogin')) {
            if ($this->session->userdata('userId') != cxpdecode($_GET['id'])) {
                $m = $this->model_message->sendMsgToUser($this->session->userdata('userId'));
                echo $m;
            }
        } else {
            echo 'Access denied';
        }
    }

    public function inbox() {
        if ($this->session->userdata('userLogin')) {
            $data['title'] = 'Inbox';
            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['allFeeds'] = $this->model_user->getAllFeedList($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));
            $data['allmessage'] = $this->model_message->getAllUserMsg($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_MESSAGE_INBOX, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(base_url());
        }
    }

    public function getMessages() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_GET['submit'])) {
                $m = $this->model_message->getMessages($this->session->userdata('userId'));
                echo $m;
            } else {
                echo 'Nice try';
            }
        } else {
            echo 'Access Denied';
        }
    }
    
    public function sendReply()
    {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['submit'])) {
                $m = $this->model_message->sendReply($this->session->userdata('userId'));
                echo $m;
            } else {
                echo 'Nice try';
            }
        } else {
            echo 'Access Denied';
        }
    }

}
