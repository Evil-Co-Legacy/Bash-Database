<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/Server.class.php');

class ServerListPage extends AbstractPage {
	public $templateName = 'serverList';
	
	public function readParameters() {
		parent::readParameters();
		
		WCF::getCache()->addResource('bbcodes', WCF_DIR.'cache/cache.bbcodes.php', WCF_DIR.'lib/system/cache/CacheBuilderBBCodes.class.php');
		WCF::getCache()->addResource('smileys', WCF_DIR.'cache/cache.smileys.php', WCF_DIR.'lib/system/cache/CacheBuilderSmileys.class.php');
	}
	
	public function show() {
		// enable menu item
		WCFACP::getMenu()->setActiveMenuItem('bash.acp.menu.link.content.servers.list');
		
		parent::show();
	}
	
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign('serverList', Server::getServerList());
	}
}
?>