<?php

use \Chicoco\Controller;

class apiController extends Controller
{
	public function init() {
		header('Content-Type: application/json');
	}

	public function IndexAction() {
	}

	public function PostsAction() {
		try {
			$from   = $this->getUrlVar('from', 'string');
			$to     = $this->getUrlVar('to', 'string');
			$author = $this->getUrlVar('author', 'string');

			if (is_array($this->_pathParams) && isset($this->_pathParams[0])) {
				$postId = (int)$this->_pathParams[0];
				if ($postId === 0) {
					throw new Exception('ERROR: post id is not valid');
				}
			}
			$postDao = new PostDao($from, $to);
			$posts = array();

			if ($from != '' || $to != '' || $author != '') {
				$posts = $postDao->getPost($from, $to, $author);
				$count = count($posts);

				$result = array(
					'posts' => $posts,
					'count' => $count
				);
			}
			elseif (isset($postId) && $postId > 0) {
				$result = $postDao->getPostById($postId);
			}
			else {
				$result = $postDao->getPost();
			}

			echo json_encode($result);
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
}
