<?php

namespace Edu\Cnm\petfoster;

require_once("autoload");

/**
 * section of a for a message for petrescueabq
 *
 * messages between users and admins to get information about the dog they chose
 *
 * @author LRL <rolopez.email@gmail.com>
 * version 1.0
 */


class Message implements \JsonSerializable {
	use ValidateDate;

	/**
	 * id for this message, this is the primary key
	 * @var int messageId
	 */
	private $messageId;

	/**
	 * id of the  organization that sent this message; this is a foreign key
	 * @var int $messageOrganizationId
	 */
	private $messageOrganizationId;


	/**
	 * id of the profile that sent this message, this is a foreign key
	 * @var int $messageProfileId
	 */
	private $messageProfileId;

	/**
	 * text content of the message
	 * @var string $messageContent;
	 */
	private $messageContent;

	/**
	 * date and time for this message, datetime object
	 * @var /Datetime $messageDateTime
	 */
	private $messageDateTime;

	/**
	 * text content of the subject
	 * @var string $messageSubject
	 */
	private $messageSubject;


	/** constrictor for this message
	 *
	 * @param int|null $newMessageId id of this message or null if a new message
	 * @param int $newOrganizationId id of the organization that sent this message
	 * @param int $newProfileId id of the profile that sent this message
	 * @param string $newMessageContent string containing the message data
	 * @param string $newMessageSubject string containing the subject data
	 * @param /Datetime|string|null $newMessageDateTime date and time Message was sent or a null if set to current date and time
	 *
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exceptions occur
	 *
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	//do these need to be in the order as in the conceptual model

	public function _construct(?int $newMessageId, ?int $newMessageOrganizationId, ?int $newMessageProfileId, string $newMessageContent, string $newMessageSubject, $newMessageDateTime = null) {
		try {
			$this->setMessageId($newMessageId);
			$this->setMessageOrganizationId($newMessageOrganizationId);
			$this->setMessageProfileId($newMessageProfileId);
			$this->setMessageContent($newMessageContent);
			$this->setMessageDateTime($newMessageDateTime);
			$this->setMessageSubject($newMessageSubject);

		}catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for messageId
	 * @return int|null value of messageId
	 */
	public function getMessageId(): int {
		return $this->messageId;
	}

	/**
	 * mutator method for messageId
	 * @param int|null $newMessageId new value of message id
	 * @throws \RangeException if $newMessageId is not positive
	 * @throws \TypeError if $newMessageId is not an integer
	 */
	public function setMessageId(?int $newMessageId) : void {
		//if message id is null immediately return it
		if($newMessageId === null) {
			$this->messageId = null;
			return;
		}

		//verify the message id is positive
		if($newMessageId <= 0) {
			throw(new \RangeException("message id is not positive"));
		}

		//convert abd store the message id
		$this->messageId = $newMessageId;
	}


	/**accessor method for message organization id
	 * @return int value of message organization id
	 **/
	public function getMessageOrganizationId() : int{
		return($this->messageOrganizationId);
	}

	/**mutator method fir message profile id
	 * @param int $newMessageOrganizationId is not positive
	 * @throws \RangeException if $newMessageId is not positive
	 * @throws \TypeError if $newMessageId is not an integer
	 **/
	public function setMessageOrganizationId(int $newMessageOrganizationId) : void {

		//verify the message id is positive
		if($newMessageOrganizationId <= 0) {
			throw(new \RangeException("Message organization id is not positive"));
		}

		//convert and store the organization id
		$this->messageOrganizationId = $newMessageOrganizationId;
	}


	/**
	 * accessor method for message profile id
	 * @return int value of the message profile id
	 **/
	public function getMessageProfileId(): int {
		return ($this->messageProfileId);
	}

	/**
	 * mutator method for message profile id
	 * @param int $newMessageProfileId new value of message profile id
	 * @throws \RangeException is $newProfileId is not positive
	 * @throws \TypeError if %newProfileId is not an integer
	 */
	public function setMessageProfileId(int $newMessageProfileId) : void {

		//verify the profile id is positive
		if($newMessageProfileId <= 0) {
			throw(new \RangeException("message profile id is not positive"));
		}

		//convert and store the profile id
		$this->messageProfileId = $newMessageProfileId;
	}


	/**
	 * accessor method for message content
	 * @return string value of message content
	 */
	public function getMessageContent(): string {
		return ($this->messageContent);
	}

	/**
	 * mutator method for message content
	 * @param string $newMessageContent new value of message content
	 * @throws \InvalidArgumentException if $newMessageContent is not a string ot insecure
	 * @throws \RangeException if $newMessageContent is > 505 characters
	 * @throws \TypeError if $newMessageContent is not a string
	 */
	public function setMessageContent(string $newMessageContent) : void {

		//verify the message content is secure
		$newMessageContent = trim($newMessageContent);
		$newMessageContent = filter_var($newMessageContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newMessageContent) === true) {
			throw(new \InvalidArgumentException("message content is empty or insecure"));
		}

		//verify the message content will fit in the database
		//changed char from 255 to 505 - BURQUE!
		if(strlen($newMessageContent) > 505) {
			throw(new \RangeException("message content too large"));
		}

		//store the message content
		$this->messageContent = $newMessageContent;
	}


	/**
	 * accessor method for message subject
	 * @return string value of message subject
	 */
	public function getMessageSubject(): string {
		return ($this->messageSubject);
	}

	/**
	 * mutator method for message subject
	 * @param string $newMessageSubject new value of message subject
	 * @throws \InvalidArgumentException if $newMessageSubject is not a string or insecure
	 * @throws \RangeException if $newMessageSubject is > 64
	 * we may want to make the string longer
	 * @throws \TypeError if $newMessageSubject is not a string
	 */
	public function setMessageSubject(string $newMessageSubject) : void{

		//verify the message subject is secure
		$newMessageSubject = trim($newMessageSubject);
		$newMessageSubject = filter_var($newMessageSubject, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newMessageSubject) === true) {
			throw(new \InvalidArgumentException("message subject is empty or insecure"));
		}

		//verify the message subject will fit in the database
		if(strlen($newMessageSubject) > 64) {
			throw(new \RangeException("message subject is too large"));
		}

		//store the message subject
		$this->messageSubject = $newMessageSubject;
	}




}