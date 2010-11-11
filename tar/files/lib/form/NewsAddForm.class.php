<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/news/NewsEntryEditor.class.php');

/**
 * Implements a form that allows users to add new news entries
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.bash
 */
class NewsAddForm extends MessageForm {
	
	/**
	 * @see AbstractPage::$templateName
	 */
	public $templateName = 'newsAdd';
	
	/**
	 * @see	CaptchaForm::$useCaptcha
	 */
	public $useCaptcha = true;
	
	/**
	 * @see	MessageForm::$showSmilies
	 */
	public $showSmilies = true;
	
	/**
	 * @see	MessageForm::$showSettings
	 */
	public $showSettings = true;
	
	/**
	 * @see MessageForm::$showAttachments
	 */
	public $showAttachments = false;
	
	/**
	 * @see	MessageForm::$showPoll
	 */
	public $showPoll = false;
	
	/**
	 * @see	MessageForm::$showSignatureSetting
	 */
	public $showSignatureSetting = false;
	
	/**
	 * @see	AbstractPage::$neededPermissions
	 */
	public $neededPermissions = 'mod.bash.canAddNewsEntries';
	
	/**
	 * Contains the username of a guest
	 * @var	string
	 */
	public $username = '';
	
	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['username'])) 		$this->username 	= StringUtil::trim($_POST['username']);
	}
	
	/**
	 * @see	Form::validate()
	 */
	public function validate() {
		parent::validate();
		
		// only for guests
		if (WCF::getUser()->userID == 0) {
			// username
			if (empty($this->username)) {
				throw new UserInputException('username');
			}
			if (!UserUtil::isValidUsername($this->username)) {
				throw new UserInputException('username', 'notValid');
			}
			if (!UserUtil::isAvailableUsername($this->username)) {
				throw new UserInputException('username', 'notAvailable');
			}
			
			WCF::getSession()->setUsername($this->username);
		}
		else {
			$this->username = WCF::getUser()->username;
		}
	}
	
	/**
	 * @see	Form::save()
	 */
	public function save() {
		parent::save();
		
		$entry = NewsEntryEditor::create(WCF::getUser()->userID, $this->username, $this->subject, $this->text, TIME_NOW);
		
		HeaderUtil::redirect('index.php?page=Index'.SID_ARG_2ND_NOT_ENCODED.'#entry'.$entry->entryID);
		
		// call event
		$this->saved();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('username' => $this->username));
	}
}
?>