<?php

namespace Edu\Cnm\PetRescueAbq;



require("autoload.php");

/**
 * message section for PetRescueAbq
 *
 * messages between users and admins to get information about the dog they chose
 *
 *
 * @author LRL <rolopez.email@gmail.com> thanks! @deepdivedylan
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
	 * id of the profile that sent this message, this is a foreign key
	 * @var int $messageProfileId
	 */
	private $messageProfileId;

	/**
	 * id of the  organization that sent this message; this is a foreign key
	 * @var int $messageOrganizationId
	 */
	private $messageOrganizationId;

	/**
	 * text content of the message
	 * @var string $messageContent;
	 */
	private $messageContent;

	/**
	 * date and time for this message, datetime object
	 * @var \Datetime $messageDateTime
	 */
	private $messageDateTime;


	/**
	 * text content of the subject
	 * @var string $messageSubject
	 */
	private $messageSubject;


	/** constructor for this message
	 *
	 * @param int|null $newMessageId id of this message or null if a new Message
	 * @param int $newMessageProfileId id of the profile that sent this message
	 * @param int $newMessageOrganizationId id of the organization that sent this Message
	 * @param string $newMessageContent string containing the Message data
	 *	@param \DateTime|string|null $newMessageDateTime date and time Message was sent or a null if set to current date and time
	 * @param string $newMessageSubject string containing the subject data
	 *
	 *
	 *
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exceptions occur
	 *
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	//do these need to be in the order as in the conceptual model

	public function _construct(?int $newMessageId, int $newMessageProfileId, int $newMessageOrganizationId, string $newMessageContent, $newMessageDateTime =
			null, string $newMessageSubject) {
		try {
			$this->setMessageId($newMessageId);
			$this->setMessageProfileId($newMessageProfileId);
			$this->setMessageOrganizationId($newMessageOrganizationId);
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
		return ($this->messageId);
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

		//convert and store the message id
		$this->messageId = $newMessageId;
	}

	/**
	 * accessor method for message profile id
	 * @return int value of the message profile id
	 **/
	public function getMessageProfileId() : int {
		return($this->messageProfileId);
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

	/**accessor method for message organization id
	 * @return int value of message organization id
	 **/
	public function getMessageOrganizationId() : int{
		return($this->messageOrganizationId);
	}

	/**mutator method for message organization id
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
	 * accessor method for message content
	 * @return string value of message content
	 */
	public function getMessageContent() :string {
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
		if(strlen($newMessageContent) > 1024) {
			throw(new \RangeException("message content too large"));
		}

		//store the message content
		$this->messageContent = $newMessageContent;
	}


	/**
	 * accessor method for message date
	 * @return \DateTime value for message datetime
	 */
	public function getMessageDateTime() : \DateTime {
		return ($this->messageDateTime);
	}

	/**
	 * mutator method for message date time
	 * @param \Datetime|string|null $newMessageDateTime date as a DateTime object or string (or null to load the current time
	 * @throws \InvalidArgumentException if $newMessageDateTime is not valid object or string
	 * @throws \RangeException if $newMessageDateTime is a date that does not exist
	 */
	public function setMessageDateTime($newMessageDateTime = null) : void {

		//base case: if the date is null, use the current date and time
		if($newMessageDateTime === null) {
			$this->messageDateTime = new \DateTime();
			return;
		}

		//store the message date using the ValidateDate trait
		try {
			$newMessageDateTime = self::ValidateDateTime($newMessageDateTime);

		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		$this->messageDateTime = $newMessageDateTime;
	}


	/**
	 * accessor method for message subject
	 * @return string value of message subject
	 */
	public function getMessageSubject() :string {
		return($this->messageSubject);
	}

	/**
	 * mutator method for message subject
	 * @param string $newMessageSubject new value of message subject
	 * @throws \InvalidArgumentException if $newMessageSubject is not a string or insecure
	 * @throws \RangeException if $newMessageSubject is > 64
	 * we may want to make the string longer
	 * @throws \TypeError if $newMessageSubject is not a string
	 */
	public function setMessageSubject(string $newMessageSubject) : void {

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


	/**
	 * inserts this message into mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		//enforce the messageId is null
		if($this->messageId !== null) {
			throw(new \PDOException("not a new message"));
		}

		//create query template
		$query = "INSERT INTO message(messageProfileId, messageOrganizationId, messageContent, messageDateTime, messageSubject) VALUES(:messageProfileId,:messageOrganizationId,  :messageContent, :messageDateTime, :messageSubject)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->messageDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["messageProfileId" => $this->messageProfileId, "messageOrganizationId" => $this->messageOrganizationId, "messageContent" =>
			$this->messageContent, "messageDateTime" => $formattedDate, "messageSubject" => $this->messageSubject];
		$statement->execute($parameters);

		//update the null messageId with what mySQL just gave us
		$this->messageId = intval($pdo->lastInsertId());
	}


	/**
	 * deletes this Message from mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo) : void {

		//enforce the messageId is not null, do not delete a message that has not been inserted
		if($this->messageId === null) {
			throw(new \PDOException("unable to delete a message that does not exist"));
		}

		//create query template
		$query = "DELETE FROM message WHERE messageId = :messageId";
		$statement = $pdo->prepare($query);

		//bind the member variable to the place holder in the template
		$parameters = ["messageId" => $this->messageId];
		$statement->execute($parameters);
	}


	/**
	 * updates this Message in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) : void {

		//enforce the messageId is not null, do not update a message that has not been insertedd
		if($this->messageId === null) {
			throw(new \PDOException("unable to update a message that does not exist"));
		}

		//create query template
		$query = "UPDATE message SET messageProfileId = :messageProfileId, messageOrganizationId = :messageOrganizationId, messageContent = :messageContent, 
			messageDateTime = :messageDateTime, messageSubject = :messageSubject WHERE messageId = :messageId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$formattedDate = $this->messageDateTime->format("Y-m-d H:i:s.u");
 		$parameters = ["messageProfileId" => $this->messageProfileId, "messageOrganizationId" => $this->messageOrganizationId, "messageContent" =>
			$this->messageContent, "messageDateTime" => $formattedDate, "messageSubject" => $this->messageSubject, "messageId" => $this->messageId];
		$statement->execute($parameters);
	}


	/**
	 * gets the Message by content
	 * @param \PDO $pdo PDO connection object
	 * @param string $messageContent message content to search for
	 * @return \SplFixedArray SplFixedArray of Messages found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 * PROBABLY WILL NOT NEED THIS

	public static function getMessageByMessageContent(\PDO $pdo, string $messageContent) : \SplFixedArray {

		//sanitize the description before searching
		$messageContent = trim($messageContent);
		$messageContent = filter_var($messageContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($messageContent) === true) {
			throw(new \PDOException("message content is invalid"));
		}

		//create query template
		//WHAT DO I USE INSTEAD OF MESSAGE?
		$query = "SELECT messageId, messageOrganizationId, messageProfileId, messageContent, messageDateTime, messageSubject FROM message WHERE messageContent LIKE :messageContent";
		$statement = $pdo->prepare($query);

		//bind the message content to the place holder in the template
		$messageContent = "%messageContent%";
		$parameters = ["messageContent" => $messageContent];
		$statement->execute($parameters);

		//build an array of messages
		$messages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {

			try {
				$message = new message($row["messageId"], $row["messageOrganizationId"], $row["messageProfileId"], $row["messageContent"], $row["messageDateTime"], $row["messageSubject"]);
				$messages[$messages->key()] = $message;
				$messages->next();

			} catch(\Exception $exception) {

				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		}
		return($messages);
	}
*/

	/**
	 * gets the Message by subject
	 * @param \PDO $pdo PDO connection object
	 * @param string $messageSubject message content to search for
	 * @return \SplFixedArray SplFixedArray of Messages found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 * * PROBABLY WILL NOT NEED THIS

	public static function getMessageByMessageSubject(\PDO $pdo, string $messageSubject) : \SplFixedArray {

		//sanitize the description before searching
		$messageSubject = trim($messageSubject);
		$messageSubject = filter_var($messageSubject, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($messageSubject) === true) {
			throw(new \PDOException("message subject is invalid"));
		}

		//create query template
		//WHAT DO I USE INSTEAD OF MESSAGE?
		$query = "SELECT messageId, messageOrganizationId, messageProfileId, messageContent, messageDateTime, messageSubject FROM message WHERE messageSubject LIKE :messageSubject";
		$statement = $pdo->prepare($query);

		//bind the message subject to the place holder in the template
		$messageSubject = "%messageSubject%";
		$parameters = ["messageSubject" => $messageSubject];
		$statement->execute($parameters);

		//build an array of messages
		$messages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {

			try {
				$message = new message($row["messageId"], $row["messageOrganizationId"], $row["messageProfileId"], $row["messageContent"], $row["messageDateTime"], $row["messageSubject"]);
				$messages[$messages->key()] = $message;
				$messages->next();

			} catch(\Exception $exception) {

				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		}
		return($messages);
	}
	 */


	/**gets the Message by messageId
	 * @param \PDO $pdo PDO connection object
	 * @param int $messageId message id to search for
	 * @return Message|null Message found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */

	public static function getMessageByMessageId(\PDO $pdo, int $messageId) : ?Message {

		//sanitize the messageId before searching
		if($messageId <= 0) {
			throw(new \PDOException("message id is not positive"));
		}

		//create query template
		$query = "SELECT messageId, messageProfileId, messageOrganizationId, messageContent, messageDateTime, messageSubject FROM message WHERE messageId = 
			:messageId";
		$statement = $pdo->prepare($query);

		//bind the message id to the place holder in the template
		$parameters = ["messageId" => $messageId];
		$statement->execute($parameters);

		//grab the message from mySQL
		try {
			$message = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$message = new Message($row["messageId"],$row["messageProfileId"], $row["messageOrganizationId"], $row["messageContent"], $row["messageDateTime"], $row["messageSubject"]);
			}

		} catch(\Exception $exception) {
			//if the row could not be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($message);
	}


	/**
	 *gets the Message by profile id
	 *@param \PDO $pdo PDO connection object
	 *@param int $messageProfileId profile id to search by
	 *@return \SplFixedArray SplFixedArray of Messages found
	 *@throws \PDOException with mySQL related errors occur
	 *@throws \TypeError when variables are not the correct data type
	 */

	public static function getMessageByMessageProfileId(\PDO $pdo, int $messageProfileId) : \SplFixedArray {
		//sanitize the profile id before searching
		if($messageProfileId <= 0) {
			throw(new \RangeException("message profile id must be positive"));
		}

		//create query template
		$query = "SELECT messageId, messageProfileId, messageOrganizationId, messageContent, messageDateTime, messageSubject FROM message WHERE messageProfileId = :messageProfileId";
		$statement = $pdo->prepare($query);

		//bind the message profile id to the place holder in the template
		$parameters = ["$messageProfileId => $messageProfileId"];
		$statement->execute($parameters);

		//build an array of messages
		$messages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$message = new Message($row["messageId"], $row["messageProfileId"], $row["messageOrganizationId"], $row["messageContent"], $row["messageDateTime"], $row["messageSubject"]);
				$messages[$messages->key()] = $message;
				$messages->next();

			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		}
		return($messages);
	}

	/**
	 *gets the Message by organization id
	 *@param \PDO $pdo PDO connection object
	 *@param int $messageOrganizationId organization id to search by
	 *@return \SplFixedArray SplFixedArray of Messages found
	 *@throws \PDOException with mySQL related errors occur
	 *@throws \TypeError when variables are not the correct data type
	 */

	public static function getsMessageByMessageOrganizationId(\PDO $pdo, int $messageOrganizationId) : \SplFixedArray {
		//sanitize the organization id before searching
		if($messageOrganizationId <= 0) {
			throw(new \RangeException("message organization id must be positive"));
		}

		//create query template
		$query = "SELECT messageId, messageProfileId, messageOrganizationId, messageContent, messageDateTime, messageSubject FROM message WHERE messageOrganizationId = :messageOrganizationId";
		$statement = $pdo->prepare($query);

		//bind the message organization id to the place holder in the template
		$parameters = ["$messageOrganizationId" => $messageOrganizationId];
		$statement->execute($parameters);

		//build an array of messages
		$messages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$message = new Message($row["messageId"], $row["messageProfileId"], $row["messageOrganizationId"], $row["messageContent"], $row["messageDateTime"], $row["messageSubject"]);
				$messages[$messages->key()] = $message;
				$messages->next();

			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		}
		return($messages);
	}




	/**
	 * gets an array of messages based on its date
	 * @param \PDO $pdo connection object
	 * @param \Datetime $sunriseMessageDateTime beginning date to search for
	 * @param \DateTime $sunsetMessageDateTime ending date to search for
	 * @return \SplFixedArray of messages found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException is either sun dates are in the wrong format
	 * PROBABLY WILL NOT NEED THIS
	 * **/


	public static function getMessageByMessageDateTime (\PDO $pdo, \DateTime $sunriseMessageDateTime, \DateTime $sunsetMessageDateTime) : \SplFixedArray {
		//enforce both dates are present
		if((empty ($sunriseMessageDateTime) === true) || (empty($sunsetMessageDateTime) === true)) {
			throw (new \InvalidArgumentException("dates are empty if insecure"));
		}

		//ensure both dates are in the correct format and are secure
		try {
			$sunriseMessageDateTime = self::validateDateTime($sunriseMessageDateTime);
			$sunsetMessageDateTime = self::validateDateTime($sunsetMessageDateTime);

		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT messageId, messageProfileId, messageOrganizationId, messageContent, messageDateTime, messageSubject FROM message WHERE messageDateTime 
			>= :sunriseMessageDateTime AND messageDateTime <= :sunsetMessageDateTime";
		$statement = $pdo->prepare($query);

		//format the dates so that mySQL can use them
		$formattedSunriseDate = $sunriseMessageDateTime->format("Y-m-d H:i:s");
		$formattedSunsetDate = $sunsetMessageDateTime->format("Y-m-d H:i:s");

		$parameters = ["sunriseMessageDateTime" => $formattedSunriseDate, "sunsetMessageDateTime" => $formattedSunsetDate];
		$statement->execute($parameters);

		//build an array of messages
		$messages = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while(($row = $statement->fetch()) !== false) {
			try {
				$message = new Message($row["messageId"], $row["messageOrganizationId"], $row["messageProfileId"], $row["messageContent"], $row["messageDateTime"], $row["messageSubject"]);
				$messages[$messages->key()] = $message;
				$messages->next();

			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($messages);
	}


		/**
		 * get all the messages
		 * @param \PDO $pdo PDO connection object
		 * @return \SplFixedArray SplFixedArray of Messages found or null if not found
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError when variables are not the correct data type
		 */

		public static function getAllMessages(\PDO $pdo) : \SplFixedArray {
			//create query template
			$query = "SELECT messageId, messageProfileId, messageOrganizationId, messageContent, messageDateTime, messageSubject FROM message";
			$statement = $pdo->prepare($query);
			$statement->execute();

			//build an array of messages
			$messages = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {

				try{
					$message = new Message($row["messageId"], $row["messageProfileId"], $row["messageOrganizationId"], $row["messageContent"],
						$row["messageDateTime"], $row["messageSubject"]);
					$messages[$messages->key()] = $message;
					$messages->next();

				} catch(\Exception $exception) {
					//if the row could not be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));

				}
			}
			return($messages);
		}

		/**
		 * formats the state variables for JSON serialization
		 * @return array resulting state variables to serialize
		 */

		public function jsonSerialize() {
			$fields = get_object_vars($this);
			//format the date sp that the front end can consume it
			$fields["messageDateTime"] = round(floatval($this->messageDateTime->format("U.u")) * 1000);
			return($fields);
		}
}