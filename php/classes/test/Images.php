<?php
namespace Edu\Cnm\Petfoster;;
require_once("autoload.php");
/**
 *
 * @author askidmore <askidmore1@cnm.edu>
 * @version 4.0.0
 **/
class Image implements \JsonSerializable; {
	use ValidateDate;
	/**
	 * id for this class; Image,  this is the primary key
	 * @var int $ImageId
	 * all variable will be private
	 **/
	private $ImageId;
	/**
	 * id of the post for this image; this is a foreign key
	 * @var int $ImagePostId
	 **/
	private $ImagePostId;
	/**
	 * Id of cloudinary account that placed this picture
	 * @var string $ImageCloudinaryId
	 **/
	private $ImageCloudinaryId;
	/**
	 * constructor for  Images
	 *
	 * @param int|null $newImageId id of this image or null if a new image
	 * @param int $newImagePostId id of the organization that placed image
	 * @param string $newImageCloudinaryId id of the cloudinary account of image
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newImageId, ?int $newImagePostId, ?string $newImageCloudinaryId) {
		try {
			$this->setImageId($newImageId);
			$this->setImagePostId($newImagePostId);
			$this->setImageCloudinaryId($newImageCloudinaryId);
		}
			//determine what exception type was thrown

		catch(\InvalidArgumentException |
				\RangeException | \Exception | \TypeError $exception) {
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
		}
		/**
		 * accessor method for image id
		 *
		 * @return int|null value of image id
		 **/
		public function getImageId() : int {
			return($this->ImageId);
		}
		/**
		 * mutator method for image id
		 *
		 * @param int|null $newImageId new value of image id
		 * @throws \RangeException if $newImageId is not positive
		 * @throws \TypeError if $newImageId is not an integer
		 **/
		public function setImageId(?int $newImageId) : void {
			//if image id is null immediately return it
			if($newImageId === null) {
				$this->imageId = null;
				return;
			}
			// verify the image id is positive
			if($newImageId <= 0) {
				throw(new \RangeException("image id is not positive"));
			}
			// convert and store the image id
			$this->imageId = $newImageId;
		}
		/**
		 * accessor method for image post id
		 *
		 * @return int value of image post id
		 **/
		public function getImagePostId() : int{
			return($this->ImagePostId);
		}
		/**
		 * mutator method for image post id
		 *
		 * @param int $newImagePostId new value of image post id
		 * @throws \RangeException if $newImagePostId is not positive
		 * @throws \TypeError if $newImagePostId is not an integer
		 **/
		public function setImagePostId(int $newImagePostId) : void {
			// verify the profile or post id is positive
			if($newImagePostId <= 0) {
				throw(new \RangeException("Image post id is not positive"));
			// convert and store the image post id
			$this->imagePostId = $newImagePostId;
		}
		/**
		 * accessor method for image cloudinary id
		 *
		 * @return string value of image cloudinary id
		 **/
		public function getImageCloudinaryId() :string {
			return($this->imageCloudinaryId);
		}
		/**
		 * mutator method for cloudinary id
		 *
		 * @param string $newImageCloudinaryId new value of imageCloudinaryId
		 * @throws \InvalidArgumentException if $newImageCloudinaryId is not a string or insecure
		 * @throws \RangeException if $newImageCloudinaryId is > 140 characters
		 * @throws \TypeError if $newTweetContent is not a string
		 **/
		public function setImageCloudinaryId(string $newImageCloudinaryId) : void {
			// verify the cloudinary image id secure
			$newImageCloudinaryId = trim($newImageCloudinaryId);
			$newImageCloudinaryId = filter_var($newImageCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newImageCloudinaryId) === true) {
				throw(new \InvalidArgumentException("image cloudinary content id insecure"));
			}
			// verify the image cloudinary id will fit in the database, need to check on what size it needs to be, only storing the sting value of the link
			//With class we only care bout storing the info, we will insert the link in the API's.
				//if(strlen($newImageCloudinaryId) > 32) {
				throw(new \RangeException("cloudinary image too large"));
			}