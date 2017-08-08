<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once 'siteConfig.php';
require_once 'dbConfig.php';

class User extends CI_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();

        $this->load->model('model_user');
        $this->load->helper('user');
        $this->load->library('Encrypt');
        $this->load->library('form_validation');
    }

    public function login() {
        if (!$this->session->userdata('userLogin')) {
            $page['title'] = 'Home';
            
            $page['header'] = $this->load->view(SiteConfig::MODULE_HEADER, '', true);
            $page['content'] = $this->load->view(SiteConfig::COMPONENT_USER_LOGIN, '', true);
            $page['footer'] = $this->load->view(SiteConfig::MODULE_FOOTER, '', true);
            $this->load->view(SiteConfig::SITE_MASTER, $page);
        } else {
            redirect(site_url());
        }
    }

    public function checkLogin() {
        if (isset($_POST['signin'])) {
            $login = $this->model_user->checkLogin();
            if (!empty($login) && $login != '0') {

                if ($login[DBConfig::TABLE_USER_ATT_IS_ACTIVE] == '1') {
                    $session['userId'] = $login[DBConfig::TABLE_USER_ATT_USER_ID];
                    $session['userLogin'] = TRUE;

                    $this->session->set_userdata($session);
                    $this->model_user->updateLoginInfo($this->session->userdata('userId'));
                    echo '1';
                } elseif ($login[DBConfig::TABLE_USER_ATT_IS_ACTIVE] == '0') {
                    echo '2';
                }
            } else {
                echo $login;
            }
        }
    }

    public function signup() {
        if (isset($_POST['signup'])) {
            $emailStatus = getEmailIsExists($_POST['email']);
            if ($emailStatus == 0) {
                $registration = $this->model_user->registration();
                echo '1';
            } else {
                echo '0';
            }
        }
    }

    public function logout() {
        if ($this->session->userdata('userId')) {
            $data['userId'] = FALSE;
            $data['userLogin'] = FALSE;

            $this->session->unset_userdata($data);

            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function feed() {
        if ($this->session->userdata('userLogin')) {
            $data['title'] = 'Connection';
            if (isset($_POST['share'])) {
                $this->model_user->postFeed($this->session->userdata('userId'));
            }
            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['allFeeds'] = $this->model_user->getAllFeedList($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));


            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_LEFT_CONTAINER, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function loadMore() {
        $loadFrom = $this->encrypt->decode($_GET['id']);
        if ($this->session->userdata('userLogin')) {
            $data = $this->model_user->loadMoreFeed($this->session->userdata('userId'), $loadFrom);

            if (!empty($data)) {
                echo json_encode($data);
            } else {
                echo "[]";
            }
        } else {
            echo 'Session time out.please login again';
        }
    }

    public function likeFeed() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['isLike'])) {
                $feedId = $_POST['feedId'];
                $result = $this->model_user->likeFeed($feedId, $this->session->userdata('userId'));
                echo $result;
            } else {
                redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FEED));
            }
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function dislikeFeed() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['isDislike'])) {
                $feedId = $_POST['feedId'];
                $result = $this->model_user->dislikeFeed($feedId, $this->session->userdata('userId'));
                echo $result;
            } else {
                redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FEED));
            }
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function commentOnFeed() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['isSubmit'])) {
                $feedId = $_POST['feedId'];
                $message = $_POST['message'];
                $result = $this->model_user->commentOnFeed($feedId, $this->session->userdata('userId'), $message);
                echo $result;
            } else {
                redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FEED));
            }
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function editProfile() {
        if ($this->session->userdata('userLogin')) {
            $data['title'] = 'Edit User Profile';

            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['allFeeds'] = $this->model_user->getAllFeedList($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_EDIT_PROFILE, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function updateProfile() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['update'])) {
                $update = $this->model_user->updateProfile($this->session->userdata('userId'));
                echo $update;
            }
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function changePassword() {
        if ($this->session->userdata('userLogin')) {
            $data['title'] = 'Change Password';

            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['allFeeds'] = $this->model_user->getAllFeedList($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_CHANGE_PASSWORD, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function updatePassword() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['updatePass'])) {
                $passStatus = getOldPasswordStatus($this->session->userdata('userId'), $_POST['oldPassword']);
                if ($passStatus == 1) {
                    $registration = $this->model_user->updatePassword($this->session->userdata('userId'));
                    echo '1';
                } else {
                    echo '0';
                }
            }
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function changeProfilePhoto() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['submit'])) {
                $this->model_user->changeProfilePhoto($this->session->userdata('userId'));
            }

            $data['title'] = 'Change Profile Photo';

            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['allFeeds'] = $this->model_user->getAllFeedList($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_CHANGE_PROFILE_PHOTO, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function changeCoverImage() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['submit'])) {
                $this->model_user->changeCoverImage($this->session->userdata('userId'));
            }

            $data['title'] = 'Change Profile Photo';

            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['allFeeds'] = $this->model_user->getAllFeedList($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_CHANGE_COVER_IMAGE, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function search() {
        if ($this->session->userdata('userLogin')) {
            if (!empty($_GET)) {
                if (isset($_GET['doSearch']) && $_GET['u'] != "") {
                    $data['userList'] = $this->model_user->searchUser($this->session->userdata('userId'));
                }
            }

            $data['title'] = 'Search';

            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_SEARCH, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function usersFeed($userId = '') {
        if ($this->session->userdata('userLogin')) {
            $data['title'] = 'Users Feed';
            $data['userName'] = getNameByUserId($userId);
            $data['usrId'] = $userId;
            $data['allFeeds'] = $this->model_user->getUsersAllFeed($userId);
            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_USERS_FEED, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function follow() {
        if ($this->session->userdata('userLogin')) {
            $followerId = $_POST['userId'];
            $result = $this->model_user->userFollow($followerId, $this->session->userdata('userId'));
            echo $result;
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function unfollow() {
        if ($this->session->userdata('userLogin')) {
            $followerId = $_POST['userId'];
            $result = $this->model_user->unfollow($followerId, $this->session->userdata('userId'));
            echo $result;
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function connection() {
        if ($this->session->userdata('userLogin')) {
            $userId = $_POST['userId'];
            $result = $this->model_user->userConnection($this->session->userdata('userId'), $userId);
            echo $result;
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function sendBlockedReport() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_GET['submit'])) {
                if ($this->session->userdata('userId') != $_GET['uid']) {
                    $r = $this->model_user->sendBlockedReport($this->session->userdata('userId'));
                    echo $r;
                } else {
                    echo 'Access denied';
                }
            }
        } else {
            echo 'Access denied';
        }
    }

    public function sendReportUser() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_GET['submit'])) {
                if ($this->session->userdata('userId') != cxpencode($_GET['id'])) {
                    $r = $this->model_user->sendReportUser($this->session->userdata('userId'));
                    echo $r;
                } else {
                    echo 'Access denied';
                }
            }
        } else {
            echo 'Access denied';
        }
    }

    public function deactivate() {
        if ($this->session->userdata('userLogin')) {

            if (isset($_POST['confirm'])) {


                $this->form_validation->set_rules('explain', 'Explain', 'required');
                $this->form_validation->set_rules('leaving-reason[]', 'Leaving reason', 'required');

                if (!$this->form_validation->run() == FALSE) {
                    $d = $this->model_user->deactivate($this->session->userdata('userId'));
                }
            }

            $data['title'] = 'Deactivate account';

            $data['dr'] = $this->model_user->getDeactivateReason();
            $data['userInfo'] = getUserInfoByUserId($this->session->userdata('userId'));
            $data['connectionList'] = $this->model_user->getConnectionList($this->session->userdata('userId'));
            $data['followerList'] = $this->model_user->getFollowerList($this->session->userdata('userId'));

            $page['header'] = $this->load->view(SiteConfig::COMPONENT_USER_HEADER, $data, true);
            $page['leftConaitner'] = $this->load->view(SiteConfig::COMPONENT_DEACTIVATE, "", true);
            $page['rightConaitner'] = $this->load->view(SiteConfig::COMPONENT_USER_RIGHT_CONTAINER, "", true);
            $page['footer'] = $this->load->view(SiteConfig::COMPONENT_USER_FOOTER, '', true);

            $this->load->view(SiteConfig::COMPONENT_USER_MASTER, $page);
        } else {
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }

    public function disconnected() {
        if ($this->session->userdata('userLogin')) {
            if (isset($_POST['submit'])) {
                if ($this->session->userdata('userId') != $_POST['userId']) {
                    $r = $this->model_user->userDisconnected($this->session->userdata('userId'),$_POST['userId']);
                    echo $r;
                } else {
                    echo 'Access denied';
                }
            }
        } else {
            echo 'Access denied';
        }
    }

}
