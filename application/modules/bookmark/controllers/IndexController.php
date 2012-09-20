<?php
class Bookmark_IndexController extends Zend_Controller_Action {
	private $_user = false;
	private $_acl;
	private $_auth;
	public function init() {
		$this->_acl = User_Plugin_Acl::getInstance();
		$this->_auth = Zend_Auth::getInstance();
		$this->_user = $this->_auth->getStorage()->read();
	}
	public function fetchAction() {
		$bookmarkMapper = new Bookmark_Model_Mapper_Bookmark ();
		$returnData = array ();
		
		$limit = $this->getRequest ()->getParam ( "limit", 100 );
		$offset = $this->getRequest ()->getParam ( "offset", 0 );
		
		$bookmarkDbTable = $bookmarkMapper->getDbTable();
		$bookmarkAdapter = $bookmarkDbTable->getAdapter();
		
		if ($this->_acl->isAllowed($this->_user->role, "bookmark","manage")) {
			// Load bookmarks for registered users
			die("Saalu tu to manage kare che.. :(");
			$isDefautlQuote = $bookmarkAdapter->quoteInto("b.is_default = ?", "YES");
			$statusQuote = $bookmarkAdapter->quoteInto("b.status = ?", "ACTIVE");
			$select = $bookmarkDbTable
			->select()
			->setIntegrityCheck(false)
			->from(array("b"=>"bookmark"))
			->joinLeft(array("i"=>"icon"), " i.bookmark_id = b.bookmark_id AND i.status='ACTIVE'")
			->where($isDefautlQuote)
			->where($statusQuote);
			$bookmarks = $bookmarkDbTable->fetchAll ( $select, null, $limit, $offset );
		} else {
			// Load bookmarks for guest users
			$isDefautlQuote = $bookmarkAdapter->quoteInto("b.is_default = ?", "YES");
			$statusQuote = $bookmarkAdapter->quoteInto("b.status = ?", "ACTIVE");
			$select = $bookmarkDbTable
						->select()
						->setIntegrityCheck(false)
						->from(array("b"=>"bookmark"))
						->joinLeft(array("i"=>"icon"), " i.bookmark_id = b.bookmark_id AND i.status='ACTIVE'")
						->where($isDefautlQuote)
						->where($statusQuote);
			$bookmarks = $bookmarkDbTable->fetchAll ( $select, null, $limit, $offset );
		}
		
		$bookmarks = $bookmarks->toArray();
		
		foreach ( $bookmarks as $bookmark ) {
			$bookmark['src'] = $this->view->baseUrl($bookmark['path']);
			unset($bookmark['path']);
			$returnData ['bookmarks'][] = $bookmark;
		}
		
		$this->_helper->json ( $returnData, true );
	}
}

