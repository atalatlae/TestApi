<?php

use \Chicoco\Dao;

class PostDao extends Dao
{
	public function getPost($f = '', $t = '', $a = '') {
		try {
			$sql = 'SELECT id, content, date, author FROM Posts WHERE 1=1';

			if ($f != '') {
				$sql .= ' AND date >= :from';
			}
			if ($t != '') {
				$sql .= ' AND date <= :to';
			}
			if ($a != '') {
				$sql .= ' AND author = :author';
			}
			
			$this->setSql($sql);
			$this->clearParams();

			if ($f != '') {
				$this->addParam(':from', $f, PDO::PARAM_STR);
			}
			if ($t != '') {
				$this->addParam(':to', $t, PDO::PARAM_STR);
			}
			if ($a != '') {
				$this->addParam(':author', $a, PDO::PARAM_STR);
			}

			$result = $this->doSelect();

			if ($result === false) {
				throw new Exception('ERROR: '.$this->msgResult);
			}
			return $this->_result;
		}
		catch (Exception $e) {
			$this->msgResult = $e->getMessage();
			return false;
		}
	}

	public function getPostById($postId) {
		try {
			$postId = (int)$postId;

			if ($postId == 0) {
				throw new Exception("ERROR post id is not valid");
			}
			$this->setSql('SELECT id, content, date, author FROM Posts WHERE id = :postId');
			$this->clearParams();
			$this->addParam(':postId', $postId, PDO::PARAM_INT);

			$result = $this->doSelect();
			if ($result === false) {
				throw new Exception('ERROR: '.$this->msgResult);
			}
			return $this->_result;
		}
		catch (Exception $e) {
			$this->msgResult = $e->getMessage();
			return false;
		}
	}
}
