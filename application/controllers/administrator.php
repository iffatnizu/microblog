<?php

require_once 'siteConfig.php';
require_once 'dbConfig.php';
require_once APPPATH . 'microblog/adminconfig.php';

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Administrator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'site', 'user', 'cookie', 'form', 'url'));
        $this->load->library(array('session', 'imageresizer'));
        $this->load->model('model_administrator');
    }

    public function index() {
        $this->login();
    }

    public function login() {
        if (!$this->session->userdata('_microblogAdminLogin')) {

            if (isset($_POST['submit'])) {
                $login = $this->model_administrator->dologin();

                if ($login != '0') {
                    $session['_microblogAdminLogin'] = true;
                    $session['_microblogAdminID'] = $login[DBConfig::TABLE_ADMIN_ATT_ADMIN_ID];

                    $this->session->set_userdata($session);

                    redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_DASHBOARD));
                } else {
                    $session['_errorlAdminLogin'] = true;
                    $this->session->set_userdata($session);
                }
            }

            $data['title'] = 'Welcome to Administrator Panel';
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
            $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_LOGIN, '', TRUE);
            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_DASHBOARD));
        }
    }

    public function dashboard() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            $data['title'] = 'Dashboard || Microblog Admin';
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
            $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_DASBOARD, '', TRUE);
            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }

    public function logout() {
        $session['_microblogAdminLogin'] = FALSE;
        $session['_microblogAdminID'] = FALSE;
        $this->session->unset_userdata($session);

        redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
    }

    public function sitecontent($contentname, $contentTitle) {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if ($contentname && $contentTitle) {
                if (isset($_POST['updateInformation'])) {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('title', 'Title', 'required');
                    $this->form_validation->set_rules('editor1', 'Description', 'required');
                    if (!$this->form_validation->run() == FALSE) {
                        $update = $this->model_administrator->updateSiteContent();

                        if ($update) {
                            $session['_success'] = true;
                            $this->session->set_userdata($session);
                            redirect($_POST['currentUrl']);
                        }
                    }
                }
                $data['title'] = urldecode($contentTitle) . '|| Microblog Admin';
                $data['contentTitle'] = urldecode($contentTitle);
                $data['contentName'] = $contentname;
                $data['content'] = $this->model_administrator->getSiteContent($contentname);
                $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
                $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
                $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_SITE_CONTENT, $data, TRUE);
                $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
            } else {
                redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
            }
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }

    public function siteparameter() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['submit'])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('siteTitle', 'Site Title', 'required');
                $this->form_validation->set_rules('siteMetaKeyword', 'Site Meta Keyword', 'required');
                $this->form_validation->set_rules('siteMetaDescription', 'Site Meta Description', 'required');
                $this->form_validation->set_rules('siteEmail', 'Site Email Address', 'required');
                $this->form_validation->set_rules('sitePhone', 'Site Phone', 'required');


                if (!$this->form_validation->run() == FALSE) {
                    $u = $this->model_administrator->updateSiteParameter();

                    if ($u == '1') {
                        $session['_success'] = true;
                        $this->session->set_userdata($session);
                        redirect(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_SITE_PARAMETER);
                    }
                }
            }
            $data['title'] = 'Site Parameter || Microblog Admin';
            $data['details'] = getSitParameter();
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
            $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_SITE_PARAMETER, '', TRUE);
            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }

    public function changepassword() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['updatePassword'])) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('old_password', 'Old Password', 'required|callback_checkOldPassword');
                $this->form_validation->set_rules('new_password', 'New Password', 'required|matches[con_new_password]');
                $this->form_validation->set_rules('con_new_password', 'Password Confirmation', 'required');

                if (!$this->form_validation->run() == FALSE) {
                    $update = $this->model_administrator->changepassword();
                    if ($update == '1') {
                        $data['_success'] = true;
                        $this->session->set_userdata($data);
                        redirect(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_CHANGE_PASSWORD);
                    } else {
                        $data['_notmached'] = true;
                        $this->session->set_userdata($data);
                        redirect(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_CHANGE_PASSWORD);
                    }
                }
            }

            $data['title'] = 'Change Administrator Password || Microblog Admin';
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
            $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_SITE_CHANGE_PASSWORD, '', TRUE);
            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }

    public function checkOldPassword($oldPassword = '') {
        $match = $this->model_administrator->checkOldPassword($oldPassword);
        if ($match == '0') {
            $this->form_validation->set_message('checkOldPassword', 'The %s field can not match');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function lists($name="") {
        if ($this->session->userdata('_microblogAdminLogin')) {


            if ($name == true) {
                if ($name == "user") {
                    $data['title'] = 'User List || Microblog Admin';
                    $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_USER_LIST, $data, TRUE);
                }
            }
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);

            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }

    public function userList() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            $ulist = $this->model_administrator->getUserList();
            echo $ulist;
        } else {
            echo "Session Expired";
        }
    }

    public function adManager() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['ad'])) {
                if ($_POST['adType'] == '1' && $_POST['adScript'] == "") {
                    $e['sc_error'] = true;
                    $this->session->set_userdata($e);
                } elseif ($_POST['adType'] == '2' && $_FILES['userfile']['name'] == "") {
                    $e['fi_error'] = true;
                    $this->session->set_userdata($e);
                } elseif ($_POST['adType'] == '2' && $_POST['adLink'] == "") {
                    $e['li_error'] = true;
                    $this->session->set_userdata($e);
                } elseif ($_POST['adType'] == '') {
                    $e['at_error'] = true;
                    $this->session->set_userdata($e);
                } else {
                    $i = $this->model_administrator->insertNewAdd();
                    if ($i) {
                        $e['_success'] = true;
                        $this->session->set_userdata($e);
                        redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_AD_MANAGER));
                    }
                }
            }
            //debugPrint($_FILES);
            $data['title'] = 'Ad Manages || Microblog Admin';
            $data['siteInfo'] = getSitParameter();
            $data['ads'] = $this->model_administrator->getAllAds();
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
            $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_AD_MANAGER, '', TRUE);
            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }

    public function updateNumOfAdsDisplay() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            $u = $this->model_administrator->updateNumOfAdsDisplay();
            echo $u;
        } else {
            echo 'Access denied ';
        }
    }

    public function deleteAdvertisement() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            $d = $this->model_administrator->deleteAdvertisement();
            echo $d;
        } else {
            echo 'Access denied ';
        }
    }

    public function blockedUser() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['submit'])) {
                $b = $this->model_administrator->blockedUser($_POST['userEmail']);
                echo $b;
            }
        } else {
            echo "Session Expired";
        }
    }

    public function unblockedUser() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['submit'])) {
                $ub = $this->model_administrator->unblockedUser($_POST['userEmail']);
                echo $ub;
            }
        } else {
            echo "Session Expired";
        }
    }
    public function deleteReport() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['submit'])) {
                $d = $this->model_administrator->deleteReport($_POST['reportId']);
                echo $d;
            }
        } else {
            echo "Session Expired";
        }
    }
    public function deleteReportePost() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['submit'])) {
                $d = $this->model_administrator->deleteReportePost($_POST['reportId']);
                echo $d;
            }
        } else {
            echo "Session Expired";
        }
    }
    public function deleteFeed() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            if (isset($_POST['submit'])) {
                $d = $this->model_administrator->deleteFeed($_POST['feedId']);
                echo $d;
            }
        } else {
            echo "Session Expired";
        }
    }

    public function reportedUser() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            $data['title'] = 'Reported user || Microblog Admin';
            $data['reportedUser'] = $this->model_administrator->reportedUser();
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
            $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_REPORTED_USER, '', TRUE);
            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }
    
    public function reportedPosts() {
        if ($this->session->userdata('_microblogAdminLogin')) {
            $data['title'] = 'Reported posts || Microblog Admin';
            $data['reportedPosts'] = $this->model_administrator->reportedPosts();
            $admin['header'] = $this->load->view(Adminconfig::VIEW_ADMIN_HEADER, $data, TRUE);
            $admin['navigation'] = $this->load->view(Adminconfig::VIEW_ADMIN_NAVIGATION, '', TRUE);
            $admin['content'] = $this->load->view(Adminconfig::VIEW_ADMIN_COMP_REPORTED_POSTS, '', TRUE);
            $this->load->view(Adminconfig::VIEW_ADMIN_MASTER, $admin);
        } else {
            redirect(site_url(Adminconfig::CONTROLLER_ADMINISTRATOR . Adminconfig::METHOD_ADMINISTRATOR_LOGIN));
        }
    }

}
