<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/BashEntryEditor.class.php');
require_once(BASH_DIR.'lib/data/server/Server.class.php');

class BashEntryAddForm extends MessageForm {
	public $templateName = 'bashEntryAdd';
	public $useCaptcha = true;
	public $showSmilies = true;
	public $showSettings = false;
	public $showAttachments = false;
	public $showPoll = false;
	public $showSignatureSetting = false;
	public $neededPermissions = 'user.bash.canAddBashEntry';
	
	public $serverList = array();
	
	public $subject = 'ThisIsAnEasteregg';
	public $username = '';
	public $serverID = 0;
	public $serverName = "";
	
	public function readData() {
		parent::readData();
		
		$this->serverList = Server::getServerList();
	}
	
	/**
	 * @see Form::readFormParameters()
	 */
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_POST['username'])) 		$this->username 	= StringUtil::trim($_POST['username']);
		if (isset($_POST['serverID']))		$this->serverID		= intval($_POST['serverID']);
		if (isset($_POST['serverName']))	$this->serverName	= StringUtil::trim($_POST['serverName']);
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
		} else {
			$this->username = WCF::getUser()->username;
		}
		
		if ($this->serverID == 0) {
			// server name
			if (empty($this->serverName)) {
				throw new UserInputException('serverName');
			}
		} else {
			// check server
			$server = new Server($this->serverID);
			
			if ($server->serverID == 0) {
				throw new UserInputException('serverID');
			} else {
				$this->serverName = $server->serverAddress;
			}
		}
	}
	
	public function save() {
		parent::save();
		
		
		$entry = BashEntryEditor::create(BASHCore::getUser()->userID, $this->username, $this->serverID, $this->serverName, $this->text, TIME_NOW);
		
		if (MODULE_USER_RANK and BASHCore::getUser()->userID > 0) {
			require_once(WCF_DIR.'lib/data/user/rank/UserRank.class.php');
			UserRank::updateActivityPoints(BASH_USER_ACTIVITY_POINTS);
		}
		
		HeaderUtil::redirect('index.php?page=BashEntry&entryID='.$entry->entryID.SID_ARG_2ND_NOT_ENCODED);
	}
	
	public function show() {
		require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
		if (PageMenu::getActiveMenuItem() == '') PageMenu::setActiveMenuItem('bash.header.menu.addBash');
		
		parent::show();
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('serverID' => $this->serverID, 'serverName' => $this->serverName, 'username' => $this->username, 'serverList' => $this->serverList));
	}
}
?>