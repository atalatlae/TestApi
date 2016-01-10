<?php

include_once('core/Init.php');

use \Chicoco\Dao;

class PostDaoTest extends \PHPUnit_Framework_TestCase
{
	protected static $postDao;

	public static function setUpBeforeClass() {
		$_SERVER['REQUEST_URI'] = '';
		$init = new \Chicoco\Init();
		self::$postDao = new PostDao();
	}

	public function testGetPost_CountAll() {
		$posts = self::$postDao->getPost();

		$total = count($posts);
		$first = $posts[0];
		$last = $posts[207];

		$this->assertEquals('208', $total);
		$this->assertEquals(21513021, $first['id']);
		$this->assertEquals(21505128, $last['id']);
	}

	public function testGetByAuthor() {
		$posts = self::$postDao->getPost('', '', 'tiredofbullshit');

		$p = array(
			array(
				'id' => '21512737',
				'content' => 'Today, my dad took my car keys off my keychain and hid them fr'
					.'om me. His reasoning was, "I don\'t want you to be driving during the '
					.'winter." Guess who has to walk ten miles a day to work, through the Ne'
					.'w England snow. FML',
				'date' => '2016-01-08 01:06:00',
				'author' => 'tiredofbullshit ',
			)
		);
		$this->assertEquals($p, $posts);
	}

	public function testGetById() {
		$post = self::$postDao->getPostById(21512737);
		$this->assertEquals('tiredofbullshit ', $post[0]['author']);
	}

	public function testGetById_NoResult() {
		$post = self::$postDao->getPostById(-123);
		$p = array();
		$this->assertEquals($p, $post);
	}
}
