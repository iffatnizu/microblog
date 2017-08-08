<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Model_Administrator extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $this->email->initialize($config);
    }

    public function dologin() {
        $this->db->where(DBConfig::TABLE_ADMIN_ATT_ADMIN_USERNAME, $_POST['adminUsername']);
        $this->db->where(DBConfig::TABLE_ADMIN_ATT_ADMIN_PASSWORD, md5($_POST['adminPassword']));

        $result = $this->db->get(DBConfig::TABLE_ADMIN)->row_array();

        if (empty($result)) {
            return '0';
        } else {
            $data[DBConfig::TABLE_ADMIN_ATT_ADMIN_LAST_LOGIN_TIME] = time();
            $this->db->where(DBConfig::TABLE_ADMIN_ATT_ADMIN_ID, $result[DBConfig::TABLE_ADMIN_ATT_ADMIN_ID]);
            $this->db->set($data);
            $this->db->update(DBConfig::TABLE_ADMIN);
            return $result;
        }
    }

    public function getSiteContent($contentname="") {
        $this->db->where(DBConfig::TABLE_CONTENT_ATT_CONTENT_NAME, $contentname);

        return $this->db->get(DBConfig::TABLE_CONTENT)->row_array();
    }

    public function updateSiteContent() {
        $data[DBConfig::TABLE_CONTENT_ATT_CONTENT_TITLE] = $_POST['title'];
        $data[DBConfig::TABLE_CONTENT_ATT_CONTENT_DETAILS] = $_POST['editor1'];
        $this->db->where(DBConfig::TABLE_CONTENT_ATT_CONTENT_NAME, $_POST['contentName']);

        $this->db->set($data);

        $u = $this->db->update(DBConfig::TABLE_CONTENT);


        return $u;
    }

    public function updateSiteParameter() {
        if ($_FILES['userfile']['name'] == true) {
            $path = "assets/public/site/";

            $imagefilename = uniqid() . basename($_FILES['userfile']['name']);

            $target = $path . $imagefilename;

            $allowedType = array("image/jpg", "image/jpeg", "image/gif", "image/png");
            $extension = $_FILES["userfile"]["type"];

            if (in_array($extension, $allowedType)) {
                if (move_uploaded_file($_FILES['userfile']['tmp_name'], $target)) {
                    $imagename = $imagefilename;
                    $data[DBConfig::TABLE_SETTINGS_ATT_SITE_LOGO] = $imagename;
                }
            }
        }

        // exit();


        $data[DBConfig::TABLE_SETTINGS_ATT_SITE_TITLE] = trim($_POST['siteTitle']);
        $data[DBConfig::TABLE_SETTINGS_ATT_SITE_META_KEYWORD] = trim($_POST['siteMetaKeyword']);
        $data[DBConfig::TABLE_SETTINGS_ATT_SITE_META_DESCRIPTION] = trim($_POST['siteMetaDescription']);

        $data[DBConfig::TABLE_SETTINGS_ATT_SITE_EMAIL] = trim($_POST['siteEmail']);
        $data[DBConfig::TABLE_SETTINGS_ATT_SITE_PHONE] = trim($_POST['sitePhone']);


        $this->db->where(DBConfig::TABLE_SETTINGS_ATT_ID, '1');
        $this->db->set($data);
        $u = $this->db->update(DBConfig::TABLE_SETTINGS);

        if ($u) {
            return '1';
        }
    }

    public function changepassword() {
        $this->db->where(DBConfig::TABLE_ADMIN_ATT_ADMIN_PASSWORD, md5($_POST['old_password']));
        $result = $this->db->get(DBConfig::TABLE_ADMIN)->row_array();
        if (!empty($result)) {

            $data[DBConfig::TABLE_ADMIN_ATT_ADMIN_PASSWORD] = md5($_POST['new_password']);
            $this->db->where(DBConfig::TABLE_ADMIN_ATT_ADMIN_PASSWORD, md5($_POST['old_password']));

            $this->db->set($data);

            $u = $this->db->update(DBConfig::TABLE_ADMIN);

            if ($u) {
                return '1';
            }
        }
    }

    public function getUserList() {
        /* Array of database columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array('name', 'email', 'isActive');

        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = DBConfig::TABLE_USER_ATT_USER_ID;

        /* DB table to use */
        $sTable = DBConfig::TABLE_USER;

        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                    intval($_GET['iDisplayLength']);
        }


        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= "`" . $aColumns[intval($_GET['iSortCol_' . $i])] . "` " .
                            ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }


        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWhere = "";
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch']) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= "`" . $aColumns[$i] . "` LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }


        /*
         * SQL queries
         * Get data to display
         */
        $sQuery = "
		SELECT SQL_CALC_FOUND_ROWS `" . str_replace(" , ", " ", implode("`, `", $aColumns)) . "`
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
		";
        //echo $sQuery;

        $rResult = mysql_query($sQuery);


        /* Data set length after filtering */
        $sQuery = "
		SELECT FOUND_ROWS()
	";
        $rResultFilterTotal = mysql_query($sQuery) or die(mysql_error());
        $aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
        $iFilteredTotal = $aResultFilterTotal[0];

        /* Total data set length */
        $sQuery = "
		SELECT COUNT(`" . $sIndexColumn . "`)
		FROM   $sTable
	";
        $rResultTotal = mysql_query($sQuery) or die(mysql_error());
        $aResultTotal = mysql_fetch_array($rResultTotal);
        $iTotal = $aResultTotal[0];


        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        while ($aRow = mysql_fetch_array($rResult)) {
            $row = array();
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == "version") {
                    /* Special output formatting for 'version' column */
                    $row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
                } else if ($aColumns[$i] != ' ') {
                    /* General output */
                    $row[] = $aRow[$aColumns[$i]];
                }
            }
            //echo $row[2];

            if ($row[2] == "1") {
                $row[2] = '<a onclick="microblog.blockedUser(\'' . $row[1] . '\')" href="javascript:;" class="btn btn-small btn-danger">Block</a>';
            } else {
                $row[2] = '<a onclick="microblog.unblockedUser(\'' . $row[1] . '\')" href="javascript:;" class="btn btn-small btn-success">UnBlock</a>';
            }
            $output['aaData'][] = $row;
        }

        //debugPrint($output);

        return json_encode($output);
    }

    public function blockedUser($email) {
        $this->db->where(DBConfig::TABLE_USER_ATT_EMAIL, $email);
        $this->db->where(DBConfig::TABLE_USER_ATT_IS_ACTIVE, '1');

        $r = $this->db->get(DBConfig::TABLE_USER)->row_array();

        //echo $this->db->last_query();

        if (!empty($r)) {
            $data[DBConfig::TABLE_USER_ATT_IS_ACTIVE] = "0";
            $this->db->where(DBConfig::TABLE_USER_ATT_EMAIL, $email);
            $this->db->where(DBConfig::TABLE_USER_ATT_IS_ACTIVE, '1');

            $this->db->set($data);

            $u = $this->db->update(DBConfig::TABLE_USER);

            if ($u) {
                return '1';
            }
        }
    }

    public function unblockedUser($email) {
        $this->db->where(DBConfig::TABLE_USER_ATT_EMAIL, $email);
        $this->db->where(DBConfig::TABLE_USER_ATT_IS_ACTIVE, '0');

        $r = $this->db->get(DBConfig::TABLE_USER)->row_array();

        //echo $this->db->last_query();

        if (!empty($r)) {
            $data[DBConfig::TABLE_USER_ATT_IS_ACTIVE] = "1";
            $this->db->where(DBConfig::TABLE_USER_ATT_EMAIL, $email);
            $this->db->where(DBConfig::TABLE_USER_ATT_IS_ACTIVE, '0');

            $this->db->set($data);

            $u = $this->db->update(DBConfig::TABLE_USER);

            if ($u) {
                return '1';
            }
        }
    }

    public function updateNumOfAdsDisplay() {
        $data[DbConfig::TABLE_SETTINGS_ATT_SITE_DISPLAY_ADS_NO] = $_GET['id'];
        $this->db->set($data);
        $this->db->where(DbConfig::TABLE_SETTINGS_ATT_ID, "1");
        $this->db->update(DbConfig::TABLE_SETTINGS);

        return '1';
    }

    public function insertNewAdd() {
        if ($_POST['adType'] == '2') {
            if ($_FILES['userfile']['name'] == true) {
                $path = "assets/public/ads/";

                $imagefilename = uniqid() . basename($_FILES['userfile']['name']);

                $target = $path . $imagefilename;

                $allowedType = array("image/jpg", "image/jpeg", "image/gif", "image/png");
                $extension = $_FILES["userfile"]["type"];

                if (in_array($extension, $allowedType)) {
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $target)) {
                        $imagename = $imagefilename;
                        $data[DBConfig::TABLE_ADS_ATT_AD_FILE_NAME] = $imagename;
                        $link = $_POST['adLink'];
                        $link = str_replace("http://", "", $link);
                        $data[DBConfig::TABLE_ADS_ATT_AD_LINK] = $link;
                    }
                }
            }
        } elseif ($_POST['adType'] == '1') {
            $data[DBConfig::TABLE_ADS_ATT_AD_SCRIPT] = $_POST['adScript'];
        }

        $data[DBConfig::TABLE_ADS_ATT_AD_IS_ACTIVE] = '1';
        $data[DBConfig::TABLE_ADS_ATT_AD_TYPE] = $_POST['adType'];
        $data[DBConfig::TABLE_ADS_ATT_ADDED_DATE] = time();

        $i = $this->db->insert(DBConfig::TABLE_ADS, $data);
        if ($i)
            return '1';
    }

    public function getAllAds() {
        $result = $this->db->get(DBConfig::TABLE_ADS)->result_array();

        return $result;
    }

    public function deleteAdvertisement() {
        $this->db->where(DbConfig::TABLE_ADS_ATT_AD_ID, $_POST['id']);
        $result = $this->db->get(DbConfig::TABLE_ADS)->row_array();

        if ($result[DbConfig::TABLE_ADS_ATT_AD_FILE_NAME] == true) {

            $oldfile_name = $result[DbConfig::TABLE_ADS_ATT_AD_FILE_NAME];

            $path = "assets/public/ads/";

            if (file_exists($path . $oldfile_name)) {
                unlink($path . $oldfile_name);
            }
        }

        $this->db->where(DbConfig::TABLE_ADS_ATT_AD_ID, $_POST['id']);
        $this->db->delete(DbConfig::TABLE_ADS);

        return '1';
    }

    public function checkOldPassword($oldPassword = '') {
        $this->db->where(DbConfig::TABLE_ADMIN_ATT_ADMIN_ID, $this->session->userdata('_microblogAdminID'));
        $this->db->where(DbConfig::TABLE_ADMIN_ATT_ADMIN_PASSWORD, md5($oldPassword));
        $query = $this->db->get(DbConfig::TABLE_ADMIN);
        if ($query->num_rows() > 0) {
            return '1';
        } else {
            return '0';
        }
    }

    public function reportedUser() {
        $result = $this->db->get(DbConfig::TABLE_REPORTED_USERS)->result_array();

        $data = array();

        foreach ($result as $row) {
            $row['reportedBy'] = userInfo($row[DbConfig::TABLE_REPORTED_USERS_ATT_REPORTED_BY]);
            $row['reportTo'] = userInfo($row[DbConfig::TABLE_REPORTED_USERS_ATT_USER_ID]);
            array_push($data, $row);
        }

        return $data;
    }

    public function reportedPosts() {
        $result = $this->db->get(DbConfig::TABLE_REPORTED_POSTS)->result_array();

        $data = array();

        foreach ($result as $row) {
            $row['feedDetails'] = $this->getFeedById($row[DbConfig::TABLE_REPORTED_POSTS_ATT_FEED_ID]);
            $row['reportedBy'] = userInfo($row[DbConfig::TABLE_REPORTED_POSTS_ATT_REPORTED_BY]);
            array_push($data, $row);
        }

        return $data;
    }

    public function getFeedById($fid) {
        $this->db->where(DbConfig::TABLE_FEED_ATT_FEED_ID, $fid);
        $result = $this->db->get(DbConfig::TABLE_FEED)->row_array();

        return $result;
    }

    public function deleteReport($reportId) {
        $this->db->where(DbConfig::TABLE_REPORTED_USERS_ATT_ID, $reportId);

        $d = $this->db->delete(DbConfig::TABLE_REPORTED_USERS);

        if ($d) {
            return '1';
        }
    }

    public function deleteReportePost($reportId) {
        $this->db->where(DbConfig::TABLE_REPORTED_POSTS_ATT_ID, $reportId);

        $d = $this->db->delete(DbConfig::TABLE_REPORTED_POSTS);

        if ($d) {
            return '1';
        }
    }

    public function deleteFeed($feedId) {


        $this->db->where(DbConfig::TABLE_FEED_ATT_FEED_ID, $feedId);

        $r = $this->db->get(DbConfig::TABLE_FEED)->row_array();

        if (!empty($r)) {
            $this->db->where(DbConfig::TABLE_LIKE_ATT_FEED_ID, $feedId);

            $this->db->delete(DbConfig::TABLE_LIKE);

            $this->db->where(DbConfig::TABLE_COMMENT_ATT_FEED_ID, $feedId);

            $this->db->delete(DbConfig::TABLE_COMMENT);

            if ($r[DbConfig::TABLE_FEED_ATT_IMAGE_NAME] != "") {
                unlink('assets/public/feedImage/' . $r[DbConfig::TABLE_FEED_ATT_IMAGE_NAME]);
            }

            $this->db->where(DbConfig::TABLE_FEED_ATT_FEED_ID, $feedId);

            $d = $this->db->delete(DbConfig::TABLE_FEED);

            if ($d) {
                return '1';
            }
        }
    }

}

?>
