<?php

namespace Edu\Cnm\PetRescueAbq\Test;

//grab the encrypted property files

use Edu\Cnm\PetRescueAbq\ {
	Profile, Organization, Message
};


//do I need this??
//require_once("/etc/apache/capstone-mysql/encrypted-config.php");
require_once(dirname(__DIR__) . "/autoload.php");


//@author RoLopez <llopez165@cnm.edu>


class MessageTest extends PetRescueAbqTest {

	/**
	 * Profile that created the message, this is the foreign key
	 * @var Profile profile
	 */
	protected $profile = null;

	/**
	 * Organization that created the Message, this is for the foreign key
	 * @var $organization organization
	 */
	protected $organization = null;

	/**
	 * valid hash to create the organization and profile object for the test
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH;

	/**
	 * valid hash to create the organization and profile object for the test
	 * @var string $VALID_SALT
	 */
	protected $VALID_SALT;

	/**
	 * content of message
	 * @var string $VALID_MESSAGECONTENT
	 */
	protected $VALID_MESSAGECONTENT = "PHPUnit test passing for content";

	/**
	 * timestamp of the Message, this starts as null and is assigned later
	 * @var \DateTime $VALID_MESSAGEDATE
	 */
	protected $VALID_MESSAGEDATETIME = null;

	/**
	 *content of subject
	 * @var string $VALID_SUBJECTCONTENT
	 */
	protected $VALID_MESSAGESUBJECT = "PHPUnit test passing for subject";

	/**
	 * Valid timestamp to use as the sunriseMessageDate
	 */
	protected $VALID_SUNRISEDATE = null;

	/**
	 * Valid timestamp to use as the sunriseMessageDate
	 */
	protected $VALID_SUNSETDATE = null;


	/**
	 * create dependent objects before running each test
	 */
	public final function setUp(): void {

		// run the default setUp() method first
		parent::setUp();
		$password = "asdfasdf";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);

		//ASK ABOUT THIS
		// create and insert a Profile to own the test Message
		$this->profile = new Profile(null, "22222222222222222222222222222222", "@handle", "test@phpunit.com", $this->VALID_HASH, "null", $this->VALID_SALT);
		$this->profile->insert($this->getPDO());

		//var_dump($this->profile->getProfileId());

		// create and insert a Organization to own the test Message
		$this->organization = new Organization(null, $this->profile->getProfileId(), "22222222222222222222222222222222", "Address 1", "Address 2", "City Name", "test@phpunit.com", "License Num", "Org Name", "5055552525", "NM", 87555);
		$this->organization->insert($this->getPDO());

		//calculate the date, just use the time the unit test was setup
		$this->VALID_MESSAGEDATETIME = new \DateTime();

		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new\DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));

		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
	}


	/**
	 * test inserting a valid Message and verify that the actual mySQL data matches
	 */
	public function testInsertValidMessage(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert into mySQL
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));

		$this->assertEquals($pdoMessage->getMessageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageOrganizationId(), $this->organization->getOrganizationId());


		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);

		//date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoMessage->getMessageDateTime()->getTimestamp(), $this->VALID_MESSAGEDATETIME->getTimestamp());

		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);


	}


	/**
	 * test inserting a Message that already exists
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidMessage(): void {
		//create a Message with a non null message id and watch it fail

		$message = new Message(PetRescueAbqTest::INVALID_KEY, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());
	}


	/**
	 * test inserting a Message, editing it, and then updating it
	 */
	public function testUpdateValidMessage(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert it into mySQL
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//DO I NEED THIS?
		//edit the Message and update it in mySQL
		$message->setMessageContent($this->VALID_MESSAGECONTENT);
		$message->update($this->getPDO());

		//DO I NEED THIS???
		$message->setMessageSubject($this->VALID_MESSAGESUBJECT);
		$message->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));

		$this->assertEquals($pdoMessage->getMessageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageOrganizationId(), $this->organization->getOrganizationId());

		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);

		//date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoMessage->getMessageDateTime()->getTimestamp(), $this->VALID_MESSAGEDATETIME->getTimestamp());

		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
	}


	/**
	 * test updating a Message that does not exists
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidMessage(): void {

		//create a Message with a non null message id and watch it fail
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->update($this->getPDO());
	}


	/**
	 * test creating a Message and then deleting it
	 */
	public function testDeleteValidMessage(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert it into mySQL
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//delete the Message from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$message->delete($this->getPDO());

		//grab the data from mySQL and enforce the Message does not exist
		$pdoMessage = Message::getMessageByMessageId($this->getPDO(), $message->getMessageId());
		$this->assertNull($pdoMessage);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("message"));
	}


	/**
	 * test deleting a Message that does not exist
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidMessage(): void {
		//create a Message and try to delete it without actually inserting it
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->delete($this->getPDO());
	}


	/**
	 * test grabbing a message that does not exist
	 */
	public function testGetInvalidMessageByMessageId(): void {
		//grab a organization id that exceeds the maximum allowable profile id
		$message = Message::getMessageByMessageId($this->getPdo(), PetRescueAbqTest::INVALID_KEY);
		$this->assertNull($message);
	}

	/**
	 * test inserting a Message and regrabbing it from mySQL
	 */
	public function testGetValidMessageByMessageProfileId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert into mySQL
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Message::getsMessageByMessageProfileId($this->getPDO(), $message->getMessageProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetRescueAbq\\Message", $results);

		//grab the result from the array and validate it
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageOrganizationId(), $this->organization->getOrganizationId());

		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);

		//date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoMessage->getMessageDateTime()->getTimestamp(), $this->VALID_MESSAGEDATETIME->getTimestamp());

		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
	}


	/**
	 * test grabbing a valid Message by sunset and sunrise date
	 */
	public function testGetValidMessageBySunDate(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("message");

		//create a new Message and insert it into the database
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT, $this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		// grab the message from the database and see if it matches expectations
		$results = Message::getMessageByMessageDateTime($this->getPDO(), $this->VALID_SUNRISEDATE, $this->VALID_SUNSETDATE);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertCount(1, $results);

		//enforce that no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetFosterAbq\\Message", $results);

//use the first result to make sure that the inserted message meets expectations
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageId(), $message->getMessageId());
		$this->assertEquals($pdoMessage->getMessageProfileId(), $message->getMessageProfileId());
		$this->assertEquals($pdoMessage->getMessageOrganizationId(), $message->getMessageOrganizationId());

		$this->assertEquals($pdoMessage->getMessageContent(), $message->getMessageContent());

		$this->assertEquals($pdoMessage->getMessageDateTime()->getTimestamp(), $this->VALID_MESSAGEDATETIME->getTimestamp());

		$this->assertEquals($pdoMessage->getMessageSubject(), $message->getMessageSubject());
	}


	/**
	 * grabbing all the Message
	 */
	public function testGetAllValidMessages(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection->getRowCount("message");

		//create a new Message and insert it into mySQL
		$message = new Message(null, $this->profile->getProfileId(), $this->organization->getOrganizationId(), $this->VALID_MESSAGECONTENT,$this->VALID_MESSAGEDATETIME, $this->VALID_MESSAGESUBJECT);
		$message->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Message::getAllMessages($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("message"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetFosterAbq\\Message", $results);

		/**
		 * grab the results from the array and validate it
		 */
		$pdoMessage = $results[0];
		$this->assertEquals($pdoMessage->getMessageProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoMessage->getMessageOrganizationId(), $this->organization->getOrganizationId());

		$this->assertEquals($pdoMessage->getMessageContent(), $this->VALID_MESSAGECONTENT);

		$this->assertEquals($pdoMessage->getMessageDate()->getTimestamp(), $this->VALID_MESSAGEDATETIME->getTimestamp());

		$this->assertEquals($pdoMessage->getMessageSubject(), $this->VALID_MESSAGESUBJECT);
	}
}

