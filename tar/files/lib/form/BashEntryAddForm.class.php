<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/bash/BashEntryEditor.class.php');
require_once(BASH_DIR.'lib/data/server/Server.class.php');

/**
 * Implements a form that allows users to add bash entries
 * @author		Johannes Donath
 * @copyright	2010 DEVel Fusion
 * @package		de.evil-co.bash
 */
class BashEntryAddForm extends MessageForm {
	
	/**
	 * @see AbstractPage::$templateName
	 */
	public $templateName = 'bashEntryAdd';
	
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
	public $neededPermissions = 'user.bash.canAddBashEntry';
	
	/**
	 * Contains a list of all default servers
	 * @var	string
	 */
	public $serverList = array();
	
	/**
	 * A little variable to pass validate method
	 * @var	string
	 */
	public $subject = 'ThisIsAnEasteregg';
	
	/**
	 * Contains the username of a guest
	 * @var	string
	 */
	public $username = '';
	
	/**
	 * Contains the ID of the server
	 * @var	string
	 */
	public $serverID = 0;
	
	/**
	 * Contains the server name
	 * @var	string
	 */
	public $serverName = "";
	
	/**
	 * @see	Page::readData()
	 */
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
	
	/**
	 * @see	Form:.save()
	 */
	public function save() {
		parent::save();
		
		$entry = BashEntryEditor::create(BASHCore::getUser()->userID, $this->username, $this->serverID, $this->serverName, $this->text, TIME_NOW, $this->enableSmilies, $this->enableHtml, $this->enableBBCodes);
		
		if (MODULE_USER_RANK and BASHCore::getUser()->userID > 0) {
			require_once(WCF_DIR.'lib/data/user/rank/UserRank.class.php');
			UserRank::updateActivityPoints(BASH_USER_ACTIVITY_POINTS);
		}
		
		if (WCF::getUser()->userID > 0)
			HeaderUtil::redirect('index.php?page=BashEntry&entryID='.$entry->entryID.SID_ARG_2ND_NOT_ENCODED);
		else {
			// redirect to index
			WCF::getTPL()->assign(array(
				'url' => 'index.php'.SID_ARG_1ST,
				'message' => WCF::getLanguage()->get('bash.page.bashEntryAdd.guestRedirect'),
				'wait' => 10
			));
			WCF::getTPL()->display('redirect');
			exit;
		}
		
		// call event
		$this->saved();
	}
	
	/**
	 * @see	Page::show()
	 */
	public function show() {
		require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
		if (PageMenu::getActiveMenuItem() == '') PageMenu::setActiveMenuItem('bash.header.menu.addBash');
		
		parent::show();
	}
	
	/**
	 * @see	Page::assignVariables()
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('serverID' => $this->serverID, 'serverName' => $this->serverName, 'username' => $this->username, 'serverList' => $this->serverList));
	}
}
?>