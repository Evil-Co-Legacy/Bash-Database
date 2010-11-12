<?php
// wcf imports
require_once(WCF_DIR.'lib/form/MessageForm.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/news/NewsEntryEditor.class.php');

class NewsEditForm extends MessageForm {
	public $templateName = 'newsEdit';
	public $useCaptcha = true;
	public $showSmilies = true;
	public $showSettings = true;
	public $showAttachments = false;
	public $showPoll = false;
	public $showSignatureSetting = false;
	public $neededPermissions = 'mod.bash.canEditNewsEntries';
	
	public $username = '';
	public $entryID = 0;
	public $entry = null;
	
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['entryID'])) $this->entryID = intval($_REQUEST['entryID']);
		
		$this->entry = new NewsEntryEditor($this->entryID);
		
		if (!$this->entry->entryID) {
			throw new IllegalLinkException;
		}
		
		$this->subject = $this->entry->subject;
		$this->text = $this->entry->text;
		
		$this->enableSmilies = $this->entry->enableSmilies;
		$this->enableHtml = $this->entry->enableHtml;
		$this->enableBBCodes = $this->entry->enableBBCodes;
	}
	
	public function save() {
		parent::save();
		
		$this->entry->subject = $this->subject;
		$this->entry->text = $this->text;
		
		$this->entry->enableSmilies = $this->enableSmilies;
		$this->entry->enableHTML = $this->enableHtml;
		$this->entry->enableBBCodes = $this->enableBBCodes;
		
		$this->entry->update();
		
		HeaderUtil::redirect('index.php?page=Index'.SID_ARG_2ND_NOT_ENCODED.'#entry'.$this->entry->entryID);
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array('entry' => $this->entry));
	}
}
?>