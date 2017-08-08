<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class Follower extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->load->model('model_user');
        $this->load->helper('user');
    }

    public function index() {
        if ($this->session->userdata('userLogin')) {

            $data['title'] = 'Connection';

            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['allFeeds'] = $this->model_user->getAllFeedList($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_FOLLOWER_LIST, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

}
