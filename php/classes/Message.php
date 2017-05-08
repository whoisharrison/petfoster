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
	private $messsageId;

	/**
	 * id of the  organization that sent this message; this is a foreign key
	 * @var int $messageOrganizationId
	 */
	private $messageOrganizationId;


	/**
	 * id of the profile that sent this message, this is a foreign key
	 * @var int $messageProfileId        u
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


}