<?php

class SiteConfig {
    
    CONST SITE_MASTER = 'siteMaster';

    CONST DIR_FEED_IMAGE = 'assets/public/feedImage/';
    CONST DIR_USER_PROFILE_IMAGE = 'assets/public/userProfileImage/';
    CONST DIR_USER_COVER_IMAGE = 'assets/public/userCoverImage/';
    
    //Define modules
    CONST MODULE_HEADER = 'mod/modHeader';
    CONST MODULE_FOOTER = 'mod/modFooter';
    
    //Define component
    CONST COMPONENT_USER_MASTER = 'comp/user/userMaster';
    CONST COMPONENT_USER_HEADER = 'comp/user/compUserHeader';
    CONST COMPONENT_USER_LEFT_CONTAINER = 'comp/user/compUserLeftContainer';
    CONST COMPONENT_USER_RIGHT_CONTAINER = 'comp/user/compUserRightContainer';
    CONST COMPONENT_USER_FOOTER = 'comp/user/compUserFooter';
    CONST COMPONENT_HOME = 'comp/home/compHome';    
    CONST COMPONENT_USER_LOGIN = 'comp/user/compLogin';
    CONST COMPONENT_USER_FEED = 'comp/user/compUserFeed';
    CONST COMPONENT_EDIT_PROFILE = 'comp/user/compEditProfile';
    CONST COMPONENT_CHANGE_PASSWORD = 'comp/user/compChangePassword';
    CONST COMPONENT_CHANGE_PROFILE_PHOTO = 'comp/user/compChangeProfilePhoto';
    CONST COMPONENT_CHANGE_COVER_IMAGE = 'comp/user/compChangeCoverImage';
    CONST COMPONENT_SEARCH = 'comp/user/compSearch';
    CONST COMPONENT_USERS_FEED = 'comp/user/compUsersFeed';
    CONST COMPONENT_DEACTIVATE = 'comp/user/compUsersDeactivate';
    
    CONST COMPONENT_CONNECTION_LIST = 'comp/connection/compConnectionList';
    
    CONST COMPONENT_FOLLOWER_LIST = 'comp/follower/compFollowerList';
    
    CONST COMPONENT_FOLLOWING_LIST = 'comp/following/compFollowingList';
    
    CONST COMPONENT_ABOUT_US = 'comp/about/compAboutUs';
    CONST COMPONENT_HELP = 'comp/help/compHelp';
    CONST COMPONENT_TERMS_OF_SERVICES = 'comp/terms/compTermsOfServices';
    CONST COMPONENT_PRIVACY_POLICY = 'comp/privacy/compPrivacyPolicy';
    
    CONST COMPONENT_MESSAGE_INBOX = 'comp/message/compMessageInbox';
    
    
    //define controllers
    CONST CONTROLLER_HOME = 'home';
    CONST CONTROLLER_USER = 'user';
    CONST CONTROLLER_CONNECTION = 'connection';
    CONST CONTROLLER_FOLLOWER = 'follower';
    CONST CONTROLLER_FOLLOWING = 'following';
    CONST CONTROLLER_ABOUT = 'about';
    CONST CONTROLLER_TERMS = 'terms';
    CONST CONTROLLER_PRIVACY = 'privacy';
    CONST CONTROLLER_HELP = 'help';
    CONST CONTROLLER_MESSAGE = 'message';

    //define all controller methods
    CONST METHOD_HOME_INDEX = '/index';
    
    CONST METHOD_USER_LOGIN = '/login';
    CONST METHOD_USER_LOGOUT = '/logout';
    CONST METHOD_USER_FEED = '/feed';
    CONST METHOD_USER_EDIT_PROFILE = '/editProfile';
    CONST METHOD_USER_CHANGE_PASSWORD = '/changePassword';
    CONST METHOD_USER_CHANGE_PROFILE_PHOTO = '/changeProfilePhoto';
    CONST METHOD_USER_CHANGE_COVER_IMAGE = '/changeCoverImage';
    CONST METHOD_USER_SEARCH = '/search';
    CONST METHOD_USER_USERS_FEED = '/usersFeed';
    CONST METHOD_USER_FOLLOW = '/follow';
    CONST METHOD_USER_CONNECTION = '/connection';
    CONST METHOD_USER_LOAD_MORE = '/loadMore';
    CONST METHOD_USER_UN_FOLLOW = '/unfollow';
    CONST METHOD_USER_LIKE_FEED = '/likeFeed';
    CONST METHOD_USER_DISLIKE_FEED = '/dislikeFeed';
    CONST METHOD_USER_COMMENT_ON_FEED = '/commentOnFeed';    
    CONST METHOD_USER_DEACTIVATE = '/deactivate';    
    CONST METHOD_USER_DISCONNECTED = '/disconnected';    
    
    CONST METHOD_MESSAGE_SEND_MSG_TO_USER = '/sendMsgToUser';
    CONST METHOD_MESSAGE_INBOX = '/inbox';
    
    
}