<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class About extends CI_Controller {

    public function About() {
        parent::__construct();
        $this->load->library(array('form_validation', 'email'));
        $this->load->model('model_about');
    }

    public function index() {
        $data['title'] = 'Who we are';
        $data['content'] = $this->model_about->getSiteContent('about');
        $page['header'] = $this->load->view(siteConfig::MODULE_HEADER, $data, TRUE);
        $page['content'] = $this->load->view(siteConfig::COMPONENT_ABOUT_US, '', TRUE);
        $page['footer'] = $this->load->view(siteConfig::MODULE_FOOTER, '', TRUE);
        $this->load->view(siteConfig::SITE_MASTER, $page);
    }

}
