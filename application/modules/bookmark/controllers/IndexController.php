<?php
class Bookmark_IndexController extends Standard_Controller_Action {
	public function indexAction() {
		$frmAddBookmark = new Bookmark_Form_Bookmark ();
		$this->view->frmBookmark = $frmAddBookmark;
		$iconfinder = $this->getInvokeArg ( "bootstrap" )->getOption ( 'iconfinder' );
		$bitpixels = $this->getInvokeArg ( "bootstrap" )->getOption ( 'bitpixels' );
		$this->view->assign ( "iconfinder", array (
				$iconfinder 
		) );
		$this->view->assign ( "bitpixels", $bitpixels );
	}
	public function fetchAction() {
		$bookmarkMapper = new Bookmark_Model_Mapper_Bookmark ();
		$returnData = array ();
		$bookmarks = array ();
		$limit = $this->getRequest ()->getParam ( "limit", 100 );
		$offset = $this->getRequest ()->getParam ( "offset", 0 );
		if ($this->_acl->isAllowed ( $this->_user->role, "bookmark" )) {
			$select = $bookmarkMapper->getDbTable ()->select ()->setIntegrityCheck ( false )->from ( array (
					"b" => "bookmark" 
			) )->joinLeft ( array (
					"i" => "icon" 
			), " i.bookmark_id = b.bookmark_id AND i.status='ACTIVE'", array (
					"i.path" 
			) )->join ( array (
					"ub" => "user_bookmark" 
			), " b.bookmark_id = ub.bookmark_id", array () )->join ( array (
					"u" => "user" 
			), "u.user_id = ub.user_id AND u.user_id = " . $this->_user->user_id, array (
					"u.user_id" 
			) )->where ( " b.status = 'ACTIVE'" );
			$returnData ["addBookmark"] = array (
					'path' => $this->view->baseUrl ( "/resources/icons/default_add_bookmark.png" ),
					'title' => "Add Bookmark",
					'url' => "javascript:void(0);",
					'customClass' => "add_bookmark" 
			);
		} else {
			$select = $bookmarkMapper->getDbTable ()->select ()->setIntegrityCheck ( false )->from ( array (
					"b" => "bookmark" 
			) )->joinLeft ( array (
					"i" => "icon" 
			), " i.bookmark_id = b.bookmark_id AND i.status='ACTIVE'" )->where ( " b.status = 'ACTIVE' and b.is_default = 'YES'" );
		}
		$bookmarks = $bookmarkMapper->getDbTable ()->fetchAll ( $select, null, $limit, $offset );
		$bookmarks = $bookmarks->toArray ();
		foreach ( $bookmarks as $bookmark ) {
			$bookmark ['path'] = $this->view->baseUrl ( $bookmark ['path'] );
			$returnData ['bookmarks'] [] = $bookmark;
		}
		
		$this->_helper->json ( $returnData, true );
	}
	public function addAction() {
		$response = array ();
		if ($this->_request->isPost ()) {
			$frmBookmark = new Bookmark_Form_Bookmark ();
			$requestParams = $this->_request->getParams ();
			if ($frmBookmark->isValid ()) {
				$formData = $frmBookmark->getValues();
				
			} else {
				$errors = $frmBookmark->getMessages ();
				foreach ( $errors as $name => $error ) {
					$errors [$name] = $error [0];
				}
				$response = array (
						"errors" => $errors
				);
			}
		}
		$this->_helper->json ( $response );
	}
	
}

