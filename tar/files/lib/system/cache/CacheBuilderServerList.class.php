<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

// bash imports
require_once(BASH_DIR.'lib/data/server/Server.class.php');

class CacheBuilderServerList implements CacheBuilder {
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		$sql = "SELECT
					*
				FROM
					bash".BASH_N."_server";
		$result = WCF::getDB()->sendQuery($sql);
		
		while ($row = WCF::getDB()->fetchArray($result)) {
			$data[] = new Server(null, $row);
		}
		
		return $data;
	}
}
?>