<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class Terms extends CI_Controller {

    public function Terms() {
        parent::__construct();
        $this->load->library(array('form_validation', 'email'));
        $this->load->model('model_terms');
    }

    public function index() {
        $data['title'] = 'Terms of services';
        $data['content'] = $this->model_terms->getSiteContent('terms');

        $page['header'] = $this->load->view(siteConfig::MODULE_HEADER, $data, TRUE);
        $page['content'] = $this->load->view(siteConfig::COMPONENT_TERMS_OF_SERVICES,$data, TRUE);
        $page['footer'] = $this->load->view(siteConfig::MODULE_FOOTER, '', TRUE);
        $this->load->view(siteConfig::SITE_MASTER, $page);
    }

}
