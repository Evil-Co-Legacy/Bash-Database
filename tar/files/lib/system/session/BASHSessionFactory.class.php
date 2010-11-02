<?php
require_once(BASH_DIR.'lib/system/session/BASHSession.class.php');
require_once(BASH_DIR.'lib/data/user/BASHUserSession.class.php');
require_once(BASH_DIR.'lib/data/user/BASHGuestSession.class.php');
require_once(WCF_DIR.'lib/system/session/CookieSessionFactory.class.php');

class BASHSessionFactory extends CookieSessionFactory {
	protected $guestClassName = 'BASHGuestSession';
	protected $userClassName = 'BASHUserSession';
	protected $sessionClassName = 'BASHSession';
}
?>
