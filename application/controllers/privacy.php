<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class Privacy extends CI_Controller {

    public function Privacy() {
        parent::__construct();
        $this->load->library(array('form_validation', 'email','session'));
        $this->load->model('model_privacy');
    }

    public function index() {
        $data['title'] = 'Privacy and Policy';
        $data['content'] = $this->model_privacy->getSiteContent('privacy');

        $page['header'] = $this->load->view(siteConfig::MODULE_HEADER, $data, TRUE);
        $page['content'] = $this->load->view(siteConfig::COMPONENT_PRIVACY_POLICY,$data, TRUE);
        $page['footer'] = $this->load->view(siteConfig::MODULE_FOOTER, '', TRUE);
        $this->load->view(siteConfig::SITE_MASTER, $page);
    }
   

}
