<?php
namespace Edu\Cnm\Petfoster;

require_once("autoload.php");

/**
 * Post Class
 *
 * This class is for posting pets from the organization
 * @author Jabari Farrar <tmafm1@gmail.com>
 * @version 1.0.0
 */

class Post implements \JsonSerializable {
	/**
	 * id for this Post; this is the primary key
	 * @var int $postId
	 **/
	private $postId;

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}
