<?php
require_once(BASH_DIR.'lib/data/user/AbstractBASHUserSession.class.php');

/**
 * Represents a bash guest session
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.bash
 */
class BASHGuestSession extends AbstractBASHUserSession {
	
	/**
	 * @see	BASHUserSession::isModerator()
	 */
	public function isModerator() {
		return false;
	}
}
?>
