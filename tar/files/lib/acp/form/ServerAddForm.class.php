<?php
// wcf imports
require_once(WCF_DIR.'lib/acp/form/ACPForm.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/ServerEditor.class.php');

class ServerAddForm extends ACPForm {
	public $templateName = 'serverAdd';
	
	public $serverName = '';
	public $serverPort = 6667;
	public $serverDescription = '';
	
	public $neededPermissions = 'admin.bash.canAddServers';
	
	public function readFormParameters() {
		parent::readFormParameters();
		
		if (isset($_REQUEST['serverName'])) $this->serverName = StringUtil::trim($_REQUEST['serverName']);
		if (isset($_REQUEST['serverPort'])) $this->serverPort = intval($_REQUEST['serverPort']);
		if (isset($_REQUEST['serverDescription'])) $this->serverDescription = StringUtil::trim($_REQUEST['serverDescription']);
	}
	
	public function validate() {
		parent::validate();
		
		if (empty($this->serverName)) {
			throw new UserInputException('serverName');
		}
		
		if (empty($this->serverPort)) {
			throw new UserInputException('serverPort');
		}
	}
	
	public function save() {
		parent::save();
		
		ServerEditor::create($this->serverName, $this->serverPort, $this->serverDescription);
		ServerEditor::clearCache();
		
		WCF::getTPL()->assign('success', true);
		$this->serverName = $this->serverDescription = '';
		$this->serverPort = 6667;
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('serverName' => $this->serverName, 'serverPort' => $this->serverPort, 'serverDescription' => $this->serverDescription));
	}
}
?>