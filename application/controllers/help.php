<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class Help extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation', 'email','session'));
        $this->load->model('model_help');
    }

    public function index() {
        $data['title'] = 'Help';
        $data['content'] = $this->model_help->getSiteContent('help');

        $page['header'] = $this->load->view(siteConfig::MODULE_HEADER, $data, TRUE);
        $page['content'] = $this->load->view(siteConfig::COMPONENT_HELP,$data, TRUE);
        $page['footer'] = $this->load->view(siteConfig::MODULE_FOOTER, '', TRUE);
        $this->load->view(siteConfig::SITE_MASTER, $page);
    }
   

}
