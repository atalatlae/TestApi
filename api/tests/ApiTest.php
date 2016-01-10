<?php

include_once('core/Init.php');

class ApiTest extends \PHPUnit_Framework_TestCase
{
	protected static $api;

	public static function setUpBeforeClass() {
		$init = new \Chicoco\Init();
		$_SERVER['REQUEST_URI'] = '';
		self::$api = new apiController();
	}

	public function testWithoutParams() {
		self::$api->postAction();
		$this->expectOutputString('');
	}

	public function testWithDate() {
		$_GET['from'] = '2016-01-08 03:06:00';
		$_GET['to'] = '2016-01-08 10:54:00';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[{"id":"21512817",'
			.'"content":"Today, I tried really hard for once on an assignment. I was told'
			.' it was my worst work yet and that I may as well have turned nothing in at '
			.'all. FML","date":"2016-01-08 10:54:00","author":"i tried so hard "},{"id":"'
			.'21512797","content":"Today, I got my wisdom teeth out. Afterwards, my paren'
			.'ts thought it would be a great idea to have my favourite meal. I got to wat'
			.'ch them enjoy it. FML","date":"2016-01-08 09:34:00","author":"First World P'
			.'roblems "},{"id":"21512779","content":"Today, I went to the doctor\'s becau'
			.'se I could feel something solid in my breasts, and I wanted to get it check'
			.'ed, just to be safe. Turns out it was my ribs. Oops. FML","date":"2016-01-0'
			.'8 06:28:00","author":"Lara (woman)"},{"id":"21512761","content":"Today, I w'
			.'as messing around and tried to catch a piece of cereal in my mouth. I accid'
			.'entally slammed my head on the counter behind my couch. FML","date":"2016-0'
			.'1-08 03:06:00","author":"cannxoc "}],"count":4}');
	}

	public function testWithDate_From() {
		$_GET['from'] = '2016-01-08 16:57:00';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[{"id":"21513021","content":"Today, I overheard '
			.'my parents talking about our family pet. Or at least I thought they were, unti'
			.'l my mother exclaimed, \"Honestly, I don\'t know why we keep her.\" Our dog is'
			.' male. FML","date":"2016-01-08 22:09:00","author":"familypet (woman)"},{"id":"'
			.'21512916","content":"Today, I woke up early to bake cinnamon rolls for a party'
			.'. I came home later to find the whole tray spilled onto the floor, most of the'
			.' rolls eaten, and my dog sitting happily nearby. FML","date":"2016-01-08 16:57'
			.':00","author":"Anonymous (woman)"}],"count":2}');
	}

	public function testWithDate_WithoutTime() {
		$_GET['from'] = '2015-12-17';
		$_GET['to'] = '2015-12-19';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[{"id":"21505195","content":"Today, I was l'
			.'istening to music on my phone and reading posts on here. I laughed hysteric'
			.'ally at one, then noticed my parents shooting me outraged looks. Turned out'
			.' I laughed while a news reporter was talking about a brutal rape that just '
			.'happened in our city. FML","date":"2015-12-18 15:46:00","author":"for the w'
			.'hored (man)"},{"id":"21505182","content":"Today, I was giving my friend a c'
			.'rash course in Star Wars over coffee. As I was telling him about the primit'
			.'ive and savage Sand People, some attention-seeking tit came out of nowhere '
			.'and called me racist. Apparently she thought I was talking about people fro'
			.'m the Middle East. FML","date":"2015-12-18 14:58:00","author":"Anonymous (m'
			.'an)"},{"id":"21505162","content":"Today, my doctor told me I needed to eat '
			.'more salt to keep my blood pressure from dropping dangerously low. He only '
			.'shrugged when I pointed out that he had previously told me to eat a low-sal'
			.'t diet to control my vertigo. FML","date":"2015-12-18 13:33:00","author":"b'
			.'apbap "},{"id":"21505155","content":"Today, I found out why my history grad'
			.'e is so low: the kid in front of me takes my homework, writes his name on i'
			.'t, and passes it off as his own. FML","date":"2015-12-18 13:16:00","author"'
			.':"Tejanoswhy "},{"id":"21505151","content":"Today, my husband finally revea'
			.'led that he\'s been secretly buying a particular brand of spicy chicken, ea'
			.'ting it on his way home from work. He does it because it makes his farts sm'
			.'ell just the way he likes it under the duvet when we go to bed. FML","date"'
			.':"2015-12-18 12:49:00","author":"tara (woman)"},{"id":"21505128","content":'
			.'"Today, I complained about period cramps. My boyfriend said periods can\'t '
			.'be that bad since \"girls must orgasm every time they put a tampon in.\" FM'
			.'L","date":"2015-12-18 11:37:00","author":"periods (woman)"}],"count":6}');
	}

	public function testWithDate_To() {
		$_GET['to'] = '2015-12-18 12:49:00';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[{"id":"21505151","content":"Today, my husband f'
			.'inally revealed that he\'s been secretly buying a particular brand of spicy ch'
			.'icken, eating it on his way home from work. He does it because it makes his fa'
			.'rts smell just the way he likes it under the duvet when we go to bed. FML","da'
			.'te":"2015-12-18 12:49:00","author":"tara (woman)"},{"id":"21505128","content":'
			.'"Today, I complained about period cramps. My boyfriend said periods can\'t be '
			.'that bad since \"girls must orgasm every time they put a tampon in.\" FML","da'
			.'te":"2015-12-18 11:37:00","author":"periods (woman)"}],"count":2}');
	}

	public function testWithDate_NoResult() {
		$_GET['from'] = '1970-01-01 00:00:00';
		$_GET['to'] = '1970-01-02 23:59:59';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[],"count":0}');
	}

	public function testWithBadDate_Letters() {
		$_GET['from'] = 'foo';
		$_GET['to'] = 'var';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[],"count":0}');
	}

	public function testWithBadDate_Timestamp() {
		$_GET['to'] = '1450442940'; // 2015/12/18 12:49:00

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[],"count":0}');
	}

	/* Test with author */
	public function testWithAuthor() {
		$_GET['author'] = 'tryingtostealmyheart';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[{"id":"21505390","content":"Today, a tot'
			.'al stranger asked me to marry him while we were waiting for the bus. I turn'
			.'ed him down. He then pulled a knife on me, grabbed my purse and ran. FML","'
			.'date":"2015-12-19 02:12:00","author":"tryingtostealmyheart "}],"count":1}');
	}

	public function testWithAuthor_NoResult() {
		$_GET['author'] = 'Not exist';

		self::$api->postsAction();
		$this->expectOutputString('{"posts":[],"count":0}');
	}

	/* Tests with ID */

	public function testWithId() {
		self::$api->setPathParams(array(21512817));
		self::$api->postsAction();
		$this->expectOutputString('[{"id":"21512817","content":"Today, I tried really '
		.'hard for once on an assignment. I was told it was my worst work yet and that'
		.' I may as well have turned nothing in at all. FML","date":"2016-01-08 10:54:'
		.'00","author":"i tried so hard "}]');
	}

	public function testWithId_NoResult() {
		self::$api->setPathParams(array('1'));
		self::$api->postsAction();
		$this->expectOutputString('[]');
	}

	public function testWithBadId_Char() {
		self::$api->setPathParams(array('*'));
		self::$api->postsAction();
		$this->expectOutputString('ERROR: post id is not valid');
	}

	public function testWithBadId_Letter() {
		self::$api->setPathParams(array('a'));
		self::$api->postsAction();
		$this->expectOutputString('ERROR: post id is not valid');
	}

	public function testWithBadId_PseudoNumber() {
		self::$api->setPathParams(array('123-456'));
		self::$api->postsAction();
		$this->expectOutputString('[]');
	}



}
