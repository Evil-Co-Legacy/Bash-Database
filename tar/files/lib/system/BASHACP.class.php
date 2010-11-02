<?php
require_once(WCF_DIR.'lib/system/WCFACP.class.php');

class BASHACP extends WCFACP {
	/**
	 * @see WCF::getOptionsFilename()
	 */
	protected function getOptionsFilename() {
		return BASH_DIR.'options.inc.php';
	}

	/**
	 * Initialises the template engine.
	 */
	protected function initTPL() {
		global $packageDirs;

		self::$tplObj = new ACPTemplate(self::getLanguage()->getLanguageID(), ArrayUtil::appendSuffix($packageDirs, 'acp/templates/'));
		$this->assignDefaultTemplateVariables();
	}

	/**
	 * Does the user authentication.
	 */
	protected function initAuth() {
		parent::initAuth();

		// user ban
		if (self::getUser()->banned) {
			require_once(WCF_DIR.'lib/system/exception/PermissionDeniedException.class.php');
			throw new PermissionDeniedException();
		}
	}

	/**
	 * @see WCF::assignDefaultTemplateVariables()
	 */
	protected function assignDefaultTemplateVariables() {
		parent::assignDefaultTemplateVariables();

		self::getTPL()->assign(array(
			// add jump to app link
			'additionalHeaderButtons' => '<li><a href="'.RELATIVE_BASH_DIR.'index.php?page=Index"><img src="'.RELATIVE_BASH_DIR.'icon/indexS.png" alt="" /> <span>'.WCF::getLanguage()->get('bash.acp.jumpToBASH').'</span></a></li>',
			// individual page title
			'pageTitle' => StringUtil::encodeHTML(PAGE_TITLE . ' - ' . PACKAGE_NAME . ' ' . PACKAGE_VERSION)
		));
	}

	/**
	 * @see WCF::loadDefaultCacheResources()
	 */
	protected function loadDefaultCacheResources() {
		parent::loadDefaultCacheResources();
		$this->loadDefaultBASHCacheResources();
	}

	/**
	 * Can be called statically from other applications or plugins.
	 */
	public static function loadDefaultBASHCacheResources() {
		
	}
}
?>
