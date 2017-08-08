<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_User extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function checkLogin() {
        $this->db->where(DBConfig::TABLE_USER_ATT_EMAIL, trim($_POST['email']));
        $this->db->where(DBConfig::TABLE_USER_ATT_PASSWORD, md5($_POST['password']));

        $result = $this->db->get(DBConfig::TABLE_USER)->row_array();

        if (!empty($result)) {

            if ($result[DBConfig::TABLE_USER_ATT_IS_DELETED] == '1') {
                $data0[DBConfig::TABLE_USER_ATT_IS_DELETED] = '0';
                $this->db->where(DBConfig::TABLE_USER_ATT_USER_ID, $result[DBConfig::TABLE_USER_ATT_USER_ID]);
                $this->db->set($data0);
                $this->db->update(DBConfig::TABLE_USER);

                $data[DBConfig::TABLE_DELETED_ACCOUNT_ATT_IS_RETURN] = '1';
                $data[DBConfig::TABLE_DELETED_ACCOUNT_ATT_RETURN_TIME] = time();

                $this->db->where(DBConfig::TABLE_DELETED_ACCOUNT_ATT_USER_ID, $result[DBConfig::TABLE_USER_ATT_USER_ID]);
                $this->db->set($data);
                $this->db->update(DBConfig::TABLE_DELETED_ACCOUNT);
            }

            return $result;
        } else {
            return '0';
        }
    }

    public function getEmailIsExists($email = '') {
        $this->db->where(DBConfig::TABLE_USER_ATT_EMAIL, $email);
        $query = $this->db->get(DBConfig::TABLE_USER);
        return $query->num_rows();
    }

    public function registration() {
        $data[DBConfig::TABLE_USER_ATT_NAME] = $_POST['name'];
        $data[DBConfig::TABLE_USER_ATT_EMAIL] = $_POST['email'];
        $data[DBConfig::TABLE_USER_ATT_PASSWORD] = md5($_POST['password']);
        $data[DBConfig::TABLE_USER_ATT_REGISTRATION_DATE] = strtotime(date("Y-m-d H:i:s"));
        $data[DBConfig::TABLE_USER_ATT_IS_ACTIVE] = '1';

        $this->db->insert(DBConfig::TABLE_USER, $data);
    }

    public function updateLoginInfo($userId = 0) {
        $data[DBConfig::TABLE_USER_ATT_LAST_LOGIN_DATE] = strtotime(date('Y-m-d H:i:s'));
        $data[DBConfig::TABLE_USER_ATT_LAST_LOGIN_IP] = $_SERVER['SERVER_ADDR'];

        $this->db->where(DBConfig::TABLE_USER_ATT_USER_ID, $userId);
        $this->db->set($data);
        $this->db->update(DBConfig::TABLE_USER);
    }

    public function getAllFeedList($userId = '') {
        $this->db->order_by(DBConfig::TABLE_FEED_ATT_FEED_ID, 'desc');
        $query = $this->db->get(DBConfig::TABLE_FEED, '10');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            foreach ($result as $row) {
                $feedUser = $row[DBConfig::TABLE_FEED_ATT_USER_ID];
                $isConnection = $this->isConnection($feedUser, $userId);
                $isMyFollowing = $this->isMyFollowing($feedUser, $userId);
                if (($userId == $feedUser) || ($isConnection == '1') || ($isMyFollowing == '1')) {
                    $row['userDetail'] = $this->userInfo($feedUser);
                    $row['allLikes'] = $this->getAllLikes($row[DBConfig::TABLE_FEED_ATT_FEED_ID]);
                    $row['allComments'] = $this->getAllComments($row[DBConfig::TABLE_FEED_ATT_FEED_ID]);
                    array_push($data, $row);
                }
            }
            $lastIndex = end($result);
            $s['loadKey'] = $lastIndex[DBConfig::TABLE_FEED_ATT_FEED_ID];
            $this->session->set_userdata($s);
            return $data;
        }
    }

    public function loadMoreFeed($userId, $loadFrom) {
        $sql = 'SELECT * FROM ' . DBConfig::TABLE_FEED . ' WHERE ' . DBConfig::TABLE_FEED_ATT_FEED_ID . ' < ' . $loadFrom . ' order by ' . DBConfig::TABLE_FEED_ATT_FEED_ID . ' DESC LIMIT 10';

        //echo $sql;

        $result = $this->db->query($sql)->result_array();

        if (!empty($result)) {
            $lastIndex = end($result);
            $data = array();
            foreach ($result as $row) {
                $feedUser = $row[DBConfig::TABLE_FEED_ATT_USER_ID];
                $isConnection = $this->isConnection($feedUser, $userId);
                $isMyFollowing = $this->isMyFollowing($feedUser, $userId);
                if (($userId == $feedUser) || ($isConnection == '1') || ($isMyFollowing == '1')) {
                    $row['userDetail'] = $this->userInfo($feedUser);
                    $row['allLikes'] = $this->getAllLikes2($row[DBConfig::TABLE_FEED_ATT_FEED_ID]);
                    $row['allComments'] = $this->getAllComments($row[DBConfig::TABLE_FEED_ATT_FEED_ID]);
                    $row['loadKey'] = $this->encrypt->encode($lastIndex[DBConfig::TABLE_FEED_ATT_FEED_ID]);
                    $row['feedOpt'] = $this->getFeedOptText($row[DBConfig::TABLE_FEED_ATT_FEED_ID], $row[DBConfig::TABLE_FEED_ATT_USER_ID]);
                    array_push($data, $row);
                }
            }
            return $data;
        }
    }

    public function getFeedOptText($feedID, $userID) {
        if ($this->session->userdata('userId') == $userID) {
            return "";
        } else {
            $html = '<span class="option">
                     <a onclick="userfeed.showOption(\'' . $feedID . '\')" href="javascript:;"><i class="icon-cog"></i></a>
                     <ul id="feedOption_' . $feedID . '">
                     <li><a onclick="userfeed.reportUser(\'' . $feedID . '\',\'' . $userID . '\')" href="javascript:;">Report</a></li>
                     </ul>
                     </span>';

            return $html;
        }
    }

    public function userInfo($user) {
        $sql = 'SELECT ' . DBConfig::TABLE_USER . '.' . DBConfig::TABLE_USER_ATT_USER_ID . ',
                       ' . DBConfig::TABLE_USER . '.' . DBConfig::TABLE_USER_ATT_NAME . ',
                       ' . DBConfig::TABLE_USER . '.' . DBConfig::TABLE_USER_ATT_EMAIL . ',
                       ' . DBConfig::TABLE_USER . '.' . DBConfig::TABLE_USER_ATT_IS_ACTIVE . ',
                       ' . DBConfig::TABLE_USER_INFO . '.' . DBConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE . '
                FROM ' . DBConfig::TABLE_USER . '
                LEFT JOIN ' . DBConfig::TABLE_USER_INFO . ' 
                ON ' . DBConfig::TABLE_USER . '.' . DBConfig::TABLE_USER_ATT_USER_ID . ' = ' . DBConfig::TABLE_USER_INFO . '.' . DBConfig::TABLE_USER_INFO_ATT_USER_ID . '
                WHERE ' . DBConfig::TABLE_USER . '.' . DBConfig::TABLE_USER_ATT_USER_ID . ' = "' . $user . '"    
               ';
        $result = $this->db->query($sql)->row_array();

        return $result;
    }

    private function isConnection($feedUser = '', $userId = '') {
        $sql = 'SELECT * FROM ' . DbConfig::TABLE_CONNECTION
                . ' WHERE ' . DbConfig::TABLE_CONNECTION_ATT_STATUS . ' = "1" AND ('
                . DbConfig::TABLE_CONNECTION_ATT_USER_ID1 . ' = "' . $feedUser . '" AND ' . DbConfig::TABLE_CONNECTION_ATT_USER_ID2 . ' = "' . $userId . '") OR ('
                . DbConfig::TABLE_CONNECTION_ATT_USER_ID1 . ' = "' . $userId . '" AND ' . DbConfig::TABLE_CONNECTION_ATT_USER_ID2 . ' = "' . $feedUser . '")';
        $query = $this->db->query($sql);
        if ($query->num_rows() == '1') {
            return '1';
        } else {
            return '0';
        }
    }

    private function isMyFollowing($userId = '', $followerId='') {
        $this->db->where(DbConfig::TABLE_FOLLOWER_ATT_USER_ID, $userId);
        $this->db->where(DbConfig::TABLE_FOLLOWER_ATT_FOLLOWER_ID, $followerId);
        $query = $this->db->get(DbConfig::TABLE_FOLLOWER);
        if ($query->num_rows() == '1') {
            return '1';
        } else {
            return '0';
        }
    }

    public function getConnectionList($userId = '') {
        $sql = 'SELECT * FROM ' . DbConfig::TABLE_CONNECTION
                . ' WHERE ' . DbConfig::TABLE_CONNECTION_ATT_STATUS . ' = "1" AND ('
                . DbConfig::TABLE_CONNECTION_ATT_USER_ID1 . ' = "' . $userId . '" AND ' . DbConfig::TABLE_CONNECTION_ATT_USER_ID2 . ' != "' . $userId . '") OR ('
                . DbConfig::TABLE_CONNECTION_ATT_USER_ID1 . ' != "' . $userId . '" AND ' . DbConfig::TABLE_CONNECTION_ATT_USER_ID2 . ' = "' . $userId . '")';
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            foreach ($result as $row) {
                if ($row[DbConfig::TABLE_CONNECTION_ATT_USER_ID1] == $userId && $row[DbConfig::TABLE_CONNECTION_ATT_USER_ID2] != $userId) {
                    $row['userDetail'] = getUserInfoByUserId($row[DbConfig::TABLE_CONNECTION_ATT_USER_ID2]);
                    array_push($data, $row);
                }
                if ($row[DbConfig::TABLE_CONNECTION_ATT_USER_ID1] != $userId && $row[DbConfig::TABLE_CONNECTION_ATT_USER_ID2] == $userId) {
                    $row['userDetail'] = getUserInfoByUserId($row[DbConfig::TABLE_CONNECTION_ATT_USER_ID1]);
                    array_push($data, $row);
                }
            }
            return $data;
        }
    }

    public function getFollowerList($userId = '') {
        $this->db->where(DbConfig::TABLE_FOLLOWER_ATT_USER_ID, $userId);
        $query = $this->db->get(DbConfig::TABLE_FOLLOWER);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            foreach ($result as $row) {
                $row['userDetail'] = getUserInfoByUserId($row[DbConfig::TABLE_FOLLOWER_ATT_FOLLOWER_ID]);
                array_push($data, $row);
            }
            return $data;
        }
    }

    public function getAllLikes($feedId = '') {
        $this->db->where(DbConfig::TABLE_LIKE_ATT_FEED_ID, $feedId);
        $this->db->where(DbConfig::TABLE_LIKE_ATT_LIKE_TYPE, '1');
        $query = $this->db->get(DbConfig::TABLE_LIKE);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            $connection = 0;
            $other = 0;
            foreach ($result as $row) {
                $likedUserId = $row[DbConfig::TABLE_LIKE_ATT_USER_ID];
                $userId = $this->session->userdata('userId');
                $isConnection = $this->isConnection($likedUserId, $userId);
                $isMyFollowing = $this->isMyFollowing($likedUserId, $userId);
                if ((($userId == $likedUserId) || ($isConnection == '1') || ($isMyFollowing == '1')) && $connection < 3) {
                    $connection++;
                    $row['likeUser'] = $this->userInfo($likedUserId);
                    array_push($data, $row);
                } else {
                    $other++;
                }
            }

            $others['others'] = $other;
            array_push($data, $others);

            return $data;
        }
    }

    public function getAllLikes2($feedId = '') {
        $this->db->where(DbConfig::TABLE_LIKE_ATT_FEED_ID, $feedId);
        $query = $this->db->get(DbConfig::TABLE_LIKE);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            $connection = 0;
            $other = 0;
            foreach ($result as $row) {
                $likedUserId = $row[DbConfig::TABLE_LIKE_ATT_USER_ID];
                $userId = $this->session->userdata('userId');
                $isConnection = $this->isConnection($likedUserId, $userId);
                $isMyFollowing = $this->isMyFollowing($likedUserId, $userId);
                if ((($userId == $likedUserId) || ($isConnection == '1') || ($isMyFollowing == '1')) && $connection < 3) {
                    $connection++;
                    $row['likeUser'] = $this->userInfo($likedUserId);
                    array_push($data, $row);
                } else {
                    $other++;
                }
            }

            $others['others'] = $other;
            array_push($data, $others);

            //debugPrint($data);

            $flag = '0';

            if (!empty($data)) {
                $str1 = "";
                $str2 = "";

                $i = 1;
                foreach ($data as $like) {
                    $i++;
                    if (!empty($like['likeUser'])) {

                        if ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] != $this->session->userdata('userId')) {
                            $str1.= $like['likeUser'][DbConfig::TABLE_USER_ATT_NAME] . ', ';
                        } elseif ($like['likeUser'][DbConfig::TABLE_USER_ATT_USER_ID] == $this->session->userdata('userId')) {
                            $str1.= 'You, ';
                        }
                    } else if ($like['others'] != '0') {
                        $str2.=' and ' . $like['others'] . ' others';
                    }
                }

                $str2.= ' like this';

                return substr($str1, 0, (strlen($str1) - 2)) . $str2;
            } else {
                return '0';
            }
            //return $data;
        } else {
            return '';
        }
    }

    public function getAllComments($feedId = '') {
        $this->db->where(DbConfig::TABLE_COMMENT_ATT_FEED_ID, $feedId);
        $query = $this->db->get(DbConfig::TABLE_COMMENT);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();

            foreach ($result as $row) {
                $row['commentUser'] = $this->userInfo($row[DbConfig::TABLE_COMMENT_ATT_USER_ID]);
                array_push($data, $row);
            }

            return $data;
        }
    }

    public function likeFeed($feedId = '', $userId = '') {
        $this->db->where(DbConfig::TABLE_LIKE_ATT_FEED_ID, $feedId);
        $this->db->where(DbConfig::TABLE_LIKE_ATT_USER_ID, $userId);
        $query = $this->db->get(DbConfig::TABLE_LIKE);
        if ($query->num_rows() == 0) {
            $data[DbConfig::TABLE_LIKE_ATT_FEED_ID] = $feedId;
            $data[DbConfig::TABLE_LIKE_ATT_USER_ID] = $userId;
            $data[DbConfig::TABLE_LIKE_ATT_LIKE_TYPE] = '1';

            $this->db->insert(DbConfig::TABLE_LIKE, $data);
            return '1';
        } else {
            return '0';
        }
    }

    public function dislikeFeed($feedId = '', $userId = '') {
        $this->db->where(DbConfig::TABLE_LIKE_ATT_FEED_ID, $feedId);
        $this->db->where(DbConfig::TABLE_LIKE_ATT_USER_ID, $userId);
        $query = $this->db->get(DbConfig::TABLE_LIKE);
        if ($query->num_rows() == 0) {
            $data[DbConfig::TABLE_LIKE_ATT_FEED_ID] = $feedId;
            $data[DbConfig::TABLE_LIKE_ATT_USER_ID] = $userId;
            $data[DbConfig::TABLE_LIKE_ATT_LIKE_TYPE] = '-1';

            $this->db->insert(DbConfig::TABLE_LIKE, $data);
            return '1';
        } else {
            return '0';
        }
    }

    public function commentOnFeed($feedId = '', $userId = '', $message = '') {
        $this->db->where(DbConfig::TABLE_FEED_ATT_FEED_ID, $feedId);
        $query = $this->db->get(DbConfig::TABLE_FEED);
        if ($query->num_rows() > 0) {
            $data[DbConfig::TABLE_COMMENT_ATT_FEED_ID] = $feedId;
            $data[DbConfig::TABLE_COMMENT_ATT_USER_ID] = $userId;
            $data[DbConfig::TABLE_COMMENT_ATT_COMMENT] = $message;

            $this->db->insert(DbConfig::TABLE_COMMENT, $data);
            return '1';
        }
    }

    public function getFollowingList($userId = '') {
        $this->db->where(DbConfig::TABLE_FOLLOWER_ATT_FOLLOWER_ID, $userId);
        $query = $this->db->get(DbConfig::TABLE_FOLLOWER);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            foreach ($result as $row) {
                $row['userDetail'] = getUserInfoByUserId($row[DbConfig::TABLE_FOLLOWER_ATT_USER_ID]);
                array_push($data, $row);
            }
            return $data;
        }
    }

    public function postFeed($userId = '') {
        if ($_POST[DbConfig::TABLE_FEED_ATT_FEED_TEXT] != '') {
            $feedText = $_POST[DbConfig::TABLE_FEED_ATT_FEED_TEXT];
            $data[DbConfig::TABLE_FEED_ATT_FEED_TEXT] = $feedText;
        }

        $config['upload_path'] = SiteConfig:: DIR_FEED_IMAGE;
        $config['allowed_types'] = "gif|jpg|png|bmp|jpeg";
        $config['max_size'] = '100000';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload');

        foreach ($_FILES as $key => $value) {
            if (!empty($key['name'])) {
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($key)) {
                    $errors[] = $this->upload->display_errors();
                    $session['fileError'] = $this->upload->display_errors();
                } else {
                    $temp = array('upload_data' => $this->upload->data());
                    $info = $this->upload->data();

                    $data[DbConfig::TABLE_FEED_ATT_IMAGE_NAME] = $info['file_name'];
                }
            }
        }

        if (!empty($data)) {
            $data[DbConfig::TABLE_FEED_ATT_USER_ID] = $userId;
            $data[DbConfig::TABLE_FEED_ATT_POST_DATE] = strtotime(date("Y-m-d H:i:s"));
            $this->db->insert(DbConfig::TABLE_FEED, $data);

            $session['insertPost'] = TRUE;
            $this->session->set_userdata($session);
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FEED));
        } else {
            $session['insertError'] = TRUE;
            $this->session->set_userdata($session);
            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_FEED));
        }
    }

    public function updateProfile($userId = 0) {
        $data[DbConfig::TABLE_USER_ATT_NAME] = $_POST['name'];

        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, $userId);
        $this->db->set($data);
        $update = $this->db->update(DbConfig::TABLE_USER);
        if ($update) {
            return '1';
        } else {
            return '0';
        }
    }

    public function getOldPasswordStatus($userId = '', $password = '') {
        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, $userId);
        $this->db->where(DbConfig::TABLE_USER_ATT_PASSWORD, md5($password));
        $query = $this->db->get(DBConfig::TABLE_USER);
        return $query->num_rows();
    }

    public function updatePassword($userId = 0) {
        $data[DbConfig::TABLE_USER_ATT_PASSWORD] = md5($_POST['password']);

        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, $userId);
        $this->db->set($data);
        $update = $this->db->update(DbConfig::TABLE_USER);
        if ($update) {
            return '1';
        } else {
            return '0';
        }
    }

    public function changeProfilePhoto($userId = '') {
        $userInfo = getUserInfoByUserId($userId);

        $userName = $userInfo[DbConfig::TABLE_USER_ATT_NAME];

        $name = strtolower(str_replace(' ', '_', $userName));

        $path_info = pathinfo($_FILES["userfile"]["name"]);
        $fileExtension = $path_info['extension'];
        $imageName = strtolower($name . '.' . $fileExtension);

        $config['upload_path'] = SiteConfig:: DIR_USER_PROFILE_IMAGE;
        $config['allowed_types'] = "gif|jpg|png|bmp|jpeg";
        $config['max_size'] = '100000';
        $config['file_name'] = $imageName;

        $this->load->library('upload');

        foreach ($_FILES as $key => $value) {
            if (!empty($key['name'])) {
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($key)) {
                    $errors[] = $this->upload->display_errors();
                    $session['fileError'] = $this->upload->display_errors();
                    $this->session->set_userdata($session);
                } else {
                    $temp = array('upload_data' => $this->upload->data());
                    $info = $this->upload->data();

                    if (file_exists(SiteConfig:: DIR_USER_PROFILE_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE])) {
                        unlink(SiteConfig:: DIR_USER_PROFILE_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE]);
                    }


                    $this->db->where(DbConfig::TABLE_USER_INFO_ATT_USER_ID, $userId);

                    $_result = $this->db->get(DbConfig::TABLE_USER_INFO)->row_array();

                    if (!empty($_result)) {


                        $data1[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] = $info['file_name'];
                        $this->db->where(DbConfig::TABLE_USER_INFO_ATT_USER_ID, $userId);
                        $this->db->set($data1);
                        $update = $this->db->update(DbConfig::TABLE_USER_INFO);
                    } else {
                        $data1[DbConfig::TABLE_USER_INFO_ATT_PROFILE_IMAGE] = $info['file_name'];
                        $data1[DbConfig::TABLE_USER_INFO_ATT_USER_ID] = $userId;
                        $update = $this->db->insert(DbConfig::TABLE_USER_INFO, $data1);
                    }


                    if ($update) {
                        $session['profilePhotoUpdate'] = TRUE;
                        $this->session->set_userdata($session);
                    }
                }
            }
        }

        redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CHANGE_PROFILE_PHOTO));
    }

    public function changeCoverImage($userId = '') {
        $userInfo = getUserInfoByUserId($userId);

        $userName = $userInfo[DbConfig::TABLE_USER_ATT_NAME];

        $name = strtolower(str_replace(' ', '_', $userName));

        $path_info = pathinfo($_FILES["userfile"]["name"]);
        $fileExtension = $path_info['extension'];
        $imageName = strtolower($name . '.' . $fileExtension);

        $config['upload_path'] = SiteConfig:: DIR_USER_COVER_IMAGE;
        $config['allowed_types'] = "gif|jpg|png|bmp|jpeg";
        $config['max_size'] = '100000';
        $config['file_name'] = $imageName;

        $this->load->library('upload');

        foreach ($_FILES as $key => $value) {
            if (!empty($key['name'])) {
                $this->upload->initialize($config);
                if (!$this->upload->do_upload($key)) {
                    $errors[] = $this->upload->display_errors();
                    $session['fileError'] = $this->upload->display_errors();
                    $this->session->set_userdata($session);
                } else {
                    $temp = array('upload_data' => $this->upload->data());
                    $info = $this->upload->data();



                    if ($userInfo[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE] != '' && file_exists(SiteConfig:: DIR_USER_COVER_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE])) {
                        unlink(SiteConfig:: DIR_USER_COVER_IMAGE . $userInfo[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE]);
                    }

                    $this->db->where(DbConfig::TABLE_USER_INFO_ATT_USER_ID, $userId);

                    $_result = $this->db->get(DbConfig::TABLE_USER_INFO)->row_array();

                    if (!empty($_result)) {
                        $data[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE] = $info['file_name'];
                        $this->db->where(DbConfig::TABLE_USER_INFO_ATT_USER_ID, $userId);
                        $this->db->set($data);
                        $update = $this->db->update(DbConfig::TABLE_USER_INFO);
                    } else {
                        $data[DbConfig::TABLE_USER_INFO_ATT_COVER_IMAGE] = $info['file_name'];
                        $data[DbConfig::TABLE_USER_INFO_ATT_USER_ID] = $userId;
                        $update = $this->db->insert(DbConfig::TABLE_USER_INFO, $data);
                    }

                    if ($update) {
                        $session['coverImageUpdate'] = TRUE;
                        $this->session->set_userdata($session);
                    }
                }
            }
        }

        redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_CHANGE_COVER_IMAGE));
    }

    public function searchUser($userId = '') {

        $sql = 'SELECT * FROM ' . DbConfig::TABLE_USER . ' WHERE ' . DbConfig::TABLE_USER_ATT_NAME . ' LIKE "%' . $_GET['u'] . '%"';
        //echo $sql;
        //$this->db->where(DbConfig::TABLE_USER_ATT_USER_ID . ' != ', $userId);
        //$this->db->like(DbConfig::TABLE_USER_ATT_NAME, $_GET['u']);
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            foreach ($result as $row) {
                $row['userDetail'] = getUserInfoByUserId($row[DbConfig::TABLE_USER_ATT_USER_ID]);
                $row['isConnnected'] = $this->isConnection($row[DbConfig::TABLE_USER_ATT_USER_ID], $userId);
                $row['isfollowed'] = $this->isMyFollowing($userId, $row[DbConfig::TABLE_USER_ATT_USER_ID]);
                array_push($data, $row);
            }
            return $data;
        }
    }

    public function getUsersAllFeed($userId = '') {
        $this->db->where(DBConfig::TABLE_FEED_ATT_USER_ID, $userId);
        $this->db->order_by(DBConfig::TABLE_FEED_ATT_FEED_ID, 'desc');
        $query = $this->db->get(DBConfig::TABLE_FEED);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $data = array();
            foreach ($result as $row) {
                $row['userDetail'] = getUserInfoByUserId($userId);
                $row['allLikes'] = $this->getAllLikes($row[DBConfig::TABLE_FEED_ATT_FEED_ID]);
                $row['allComments'] = $this->getAllComments($row[DBConfig::TABLE_FEED_ATT_FEED_ID]);
                array_push($data, $row);
            }
            return $data;
        }
    }

    public function userFollow($followerId = '', $userId = '') {
//        $isConnection = $this->isConnection($followerId, $userId);
        $isMyFollowing = $this->isMyFollowing($userId, $followerId);

        if ($isMyFollowing == '0') {
            $data[DbConfig::TABLE_FOLLOWER_ATT_FOLLOWER_ID] = $followerId;
            $data[DbConfig::TABLE_FOLLOWER_ATT_USER_ID] = $userId;

            $this->db->insert(DbConfig::TABLE_FOLLOWER, $data);
            return '1';
        } else {
            return '0';
        }
    }

    public function unfollow($followerId = '', $userId = '') {
        $isMyFollowing = $this->isMyFollowing($userId, $followerId);
        if ($isMyFollowing == '1') {
            $this->db->where(DbConfig::TABLE_FOLLOWER_ATT_FOLLOWER_ID, $followerId);
            $this->db->where(DbConfig::TABLE_FOLLOWER_ATT_USER_ID, $userId);

            $d = $this->db->delete(DbConfig::TABLE_FOLLOWER);

            if ($d)
                return '1';
        }
    }

    public function userConnection($userId1 = '', $userId2 = '') {
        $sql = 'SELECT * FROM ' . DbConfig::TABLE_CONNECTION
                . ' WHERE ('
                . DbConfig::TABLE_CONNECTION_ATT_USER_ID1 . ' = "' . $userId1 . '" AND ' . DbConfig::TABLE_CONNECTION_ATT_USER_ID2 . ' = "' . $userId2 . '") OR ('
                . DbConfig::TABLE_CONNECTION_ATT_USER_ID1 . ' = "' . $userId2 . '" AND ' . DbConfig::TABLE_CONNECTION_ATT_USER_ID2 . ' = "' . $userId1 . '")';
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $data[DbConfig::TABLE_CONNECTION_ATT_USER_ID1] = $userId1;
            $data[DbConfig::TABLE_CONNECTION_ATT_USER_ID2] = $userId2;
            $data[DbConfig::TABLE_CONNECTION_ATT_STATUS] = '0';

            $this->db->insert(DbConfig::TABLE_CONNECTION, $data);
            return '1';
        } else {
            return '0';
        }
    }

    public function sendBlockedReport($usrId) {
        $this->db->where(DbConfig::TABLE_FEED_ATT_FEED_ID, $_GET['id']);

        $result = $this->db->get(DbConfig::TABLE_FEED)->num_rows();

        //echo $result;

        if ($result > 0) {
            $this->db->where(DbConfig::TABLE_REPORTED_POSTS_ATT_FEED_ID, $_GET['id']);
            $this->db->where(DbConfig::TABLE_REPORTED_POSTS_ATT_REPORTED_BY, $usrId);

            $_result = $this->db->get(DbConfig::TABLE_REPORTED_POSTS)->num_rows();

            if ($_result == 0) {
                $data[DbConfig::TABLE_REPORTED_POSTS_ATT_FEED_ID] = $_GET['id'];
                $data[DbConfig::TABLE_REPORTED_POSTS_ATT_REPORT_REASON] = $_GET['report'];
                $data[DbConfig::TABLE_REPORTED_POSTS_ATT_REPORTED_BY] = $usrId;
                $data[DbConfig::TABLE_REPORTED_POSTS_ATT_TIME] = time();

                $i = $this->db->insert(DbConfig::TABLE_REPORTED_POSTS, $data);

                if ($i) {
                    return '1';
                }
            } else {
                return '2';
            }
        }
    }

    public function sendReportUser($usrId) {
        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, cxpdecode($_GET['id']));

        $result = $this->db->get(DbConfig::TABLE_USER)->num_rows();

        //echo $result;

        if ($result > 0) {
            $this->db->where(DbConfig::TABLE_REPORTED_USERS_ATT_USER_ID, cxpdecode($_GET['id']));
            $this->db->where(DbConfig::TABLE_REPORTED_USERS_ATT_REPORTED_BY, $usrId);

            $_result = $this->db->get(DbConfig::TABLE_REPORTED_USERS)->num_rows();

            if ($_result == 0) {
                $data[DbConfig::TABLE_REPORTED_USERS_ATT_USER_ID] = cxpdecode($_GET['id']);
                $data[DbConfig::TABLE_REPORTED_USERS_ATT_REPORT_REASON] = $_GET['report'];
                $data[DbConfig::TABLE_REPORTED_USERS_ATT_REPORTED_BY] = $usrId;
                $data[DbConfig::TABLE_REPORTED_USERS_ATT_TIME] = time();

                $i = $this->db->insert(DbConfig::TABLE_REPORTED_USERS, $data);

                if ($i) {
                    return '1';
                }
            } else {
                return '2';
            }
        }
    }

    public function peopleYouMayKnow($userId) {
        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID . " != ", $userId);
        $result = $this->db->get(DbConfig::TABLE_USER, 10)->result_array();

        $data = array();

        foreach ($result as $row) {
            $isConnected = $this->isConnection($row[DbConfig::TABLE_USER_ATT_USER_ID], $userId);
            $isfollowed = $this->isMyFollowing($userId, $row[DbConfig::TABLE_USER_ATT_USER_ID]);
            $row['isConnected'] = $isConnected;
            $row['isfollowed'] = $isfollowed;
            if ($isConnected == '0') {
                if ($isfollowed == '0') {
                    $row['userDetails'] = $this->userInfo($row[DbConfig::TABLE_USER_ATT_USER_ID]);
                    array_push($data, $row);
                }
            }
        }

        return $data;
    }

    public function getDeactivateReason() {
        return $this->db->get(DbConfig::TABLE_ACCOUNT_DEACTIVATE_REASON)->result_array();
    }

    public function deactivate($usrId) {
        //debugPrint($_POST);
        $data0[DbConfig::TABLE_USER_ATT_IS_DELETED] = '1';
        $this->db->set($data0);
        $this->db->where(DbConfig::TABLE_USER_ATT_USER_ID, $usrId);
        $this->db->update(DbConfig::TABLE_USER);

        $data[DbConfig::TABLE_DELETED_ACCOUNT_ATT_DELETE_REASON_ID] = $_POST['leaving-reason'];
        $data[DbConfig::TABLE_DELETED_ACCOUNT_ATT_EXPLANTION] = $_POST['explain'];
        $data[DbConfig::TABLE_DELETED_ACCOUNT_ATT_TIME] = time();
        $data[DbConfig::TABLE_DELETED_ACCOUNT_ATT_USER_ID] = $usrId;

        $i = $this->db->insert(DbConfig::TABLE_DELETED_ACCOUNT, $data);


        if ($i) {
            $session['userId'] = FALSE;
            $session['userLogin'] = FALSE;
            $this->session->unset_userdata($session);

            $se['deletedCompleted'] = true;
            $this->session->set_userdata($se);

            redirect(site_url(SiteConfig::CONTROLLER_USER . SiteConfig::METHOD_USER_LOGIN));
        }
    }
    
    public function userDisconnected($usrId,$disconnectId)
    {
        $this->db->where(DbConfig::TABLE_CONNECTION_ATT_USER_ID1,$usrId);
        $this->db->where(DbConfig::TABLE_CONNECTION_ATT_USER_ID2,$disconnectId);
        
        $d = $this->db->delete(DbConfig::TABLE_CONNECTION);
        
        if($d)
            return '1';
    }

}