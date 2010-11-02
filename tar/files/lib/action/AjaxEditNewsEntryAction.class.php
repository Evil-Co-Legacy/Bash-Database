<?php
// wcf imports
require_once(WCF_DIR.'lib/action/AbstractAction.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/news/NewsEntryEditor.class.php');

class AjaxEditNewsEntryAction extends AbstractAction {
	public $entryID = 0;
	public $value = '';
	public $type = 'TEXT';
	
	public function readParameters() {
		parent::readParameters();
		
		if (isset($_REQUEST['entryID'])) $this->entryID = intval($_REQUEST['entryID']);
		if (isset($_REQUEST['value'])) $this->value = StringUtil::trim($_REQUEST['value']);
		if (isset($_REQUEST['type'])) $this->type = strtoupper($_REQUEST['type']);
	}
	
	public function execute() {
		parent::execute();
		
		WCF::getUser()->checkPermission('mod.bash.canEditNewsEntries');
		
		$entry = new NewsEntryEditor($this->entryID);
		
		if (!$entry->entryID) {
			echo 'Nice try ;D';
		} else {
			switch ($this->type) {
				case 'TEXT': 
					if (empty($this->value)) {
						echo $entry->getFormatedText();
					} else {
						$entry->text = $this->value;
						$entry->update();
						echo $entry->getFormatedText();
					}
					break;
				case 'SUBJECT':
					if (empty($this->value)) {
						echo $entry->subject;
					} else {
						$entry->subject = $this->value;
						$entry->update();
						echo $entry->subject;
					}
					break;
			}
		}
		
		$this->executed();
	}
}
?>