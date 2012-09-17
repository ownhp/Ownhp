<?php
class Bookmark_IndexController extends Zend_Controller_Action {
	private $user = false;
	public function init() {
		$this->user = false;
	}
	public function fetchAction() {
		$bookmarkMapper = new Bookmark_Model_Mapper_Bookmark ();
		$returnData = array ();
		
		$limit = $this->getRequest ()->getParam ( "limit", 100 );
		$offset = $this->getRequest ()->getParam ( "offset", 0 );
		if ($this->user) {
		} else {
			$select = $bookmarkMapper->getDbTable()
						->select()
						->setIntegrityCheck(false)
						->from(array("b"=>"bookmark"))
						->joinLeft(array("i"=>"icon"), " i.bookmark_id = b.bookmark_id AND i.status='ACTIVE'")
						//->where(" b.status = 'ACTIVE' and b.is_default = 'YES'");
						->where(" b.status = 'ACTIVE' and b.is_default = 'YES'");
			$quote = $bookmarkMapper->getDbTable()->getAdapter()->quoteInto("is_default", "YES");
			$bookmarks = $bookmarkMapper->getDbTable()->fetchAll ( $select, null, $limit, $offset );
		}
		
		$bookmarks = $bookmarks->toArray();
		
		foreach ( $bookmarks as $bookmark ) {
			$bookmark['src'] = $this->view->baseUrl($bookmark['path']);
			unset($bookmark['path']);
			$returnData ['bookmarks'][] = $bookmark;
			$returnData ['bookmarks'][] = $bookmark;
			$returnData ['bookmarks'][] = $bookmark;
			$returnData ['bookmarks'][] = $bookmark;
			$returnData ['bookmarks'][] = $bookmark;
			$returnData ['bookmarks'][] = $bookmark;
		}
		
		$this->_helper->json ( $returnData, true );
	}
}

