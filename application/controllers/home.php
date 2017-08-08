<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class Home extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->load->model('model_home');
        $this->load->library('Encrypt');
    }

    public function index() {
        if ($this->session->userdata('userLogin')) {
//            $page['title'] = 'Home';
//
//            $page['header'] = $this->load->view(SiteConfig::MODULE_HEADER, '', true);
//            $page['content'] = $this->load->view(SiteConfig::COMPONENT_HOME, '', true);
//            $page['footer'] = $this->load->view(SiteConfig::MODULE_FOOTER, '', true);
//            $this->load->view(SiteConfig::SITE_MASTER, $page);
            redirect(site_url(SiteConfig::CONTROLLER_USER.SiteConfig::METHOD_USER_FEED));
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER.SiteConfig::METHOD_USER_LOGIN));
        }
    }
    
    public function customForm()
    {
        $data['title'] = "Test";
        $this->load->view('comp/home/compMasterForm',$data);
    }
    
    public function customFormAction()
    {
//        debugPrint($_POST);
    }

}
