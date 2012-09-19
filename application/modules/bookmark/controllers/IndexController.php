<?php
class Bookmark_IndexController extends Zend_Controller_Action {
	private $user = false;
	private $_acl;
	private $_auth;
	public function init() {
		$this->user = false;
		$this->_acl = User_Plugin_Acl::getInstance();
		$this->_auth = Zend_Auth::getInstance();
	}
	public function fetchAction() {
		$bookmarkMapper = new Bookmark_Model_Mapper_Bookmark ();
		$returnData = array ();
		
		$limit = $this->getRequest ()->getParam ( "limit", 100 );
		$offset = $this->getRequest ()->getParam ( "offset", 0 );
		if ($this->_acl->isAllowed($this->_auth->getStorage()->read()->role, "bookmark","add,edit,delete")) {
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

