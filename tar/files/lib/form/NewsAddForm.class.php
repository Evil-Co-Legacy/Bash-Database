<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/news/NewsEntryEditor.class.php');

class NewsAddForm extends MessageForm {
	public $templateName = 'newsAdd';
	public $useCaptcha = true;
	public $showSmilies = true;
	public $showSettings = false;
	public $showAttachments = false;
	public $showPoll = false;
	public $showSignatureSetting = false;
	public $neededPermissions = 'mod.bash.canAddNewsEntries';
	
	public $username = '';
	
	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['username'])) 		$this->username 	= StringUtil::trim($_POST['username']);
	}
	
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
	
	public function save() {
		parent::save();
		
		$entry = NewsEntryEditor::create(WCF::getUser()->userID, $this->username, $this->subject, $this->text, TIME_NOW);
		
		HeaderUtil::redirect('index.php?page=Index'.SID_ARG_2ND_NOT_ENCODED.'#entry'.$entry->entryID);
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('username' => $this->username));
	}
}
?>