<?php
namespace Edu\Cnm\PetRescueAbq;;
require_once("autoload.php");
/**
 *
 * @author askidmore <askidmore1@cnm.edu>
 * @version 4.0.0
 **/
class Image implements \JsonSerializable {
		use ValidateDate;

		/**
		 * id for this class; Image,  this is the primary key
		 * @var int $ImageId
		 * all variables will be private
		 **/
		private
		$imageId;
		/**
		 * id of the post for this image; this is a foreign key
		 * @var int $ImagePostId
		 **/
		private
		$ImagePostId;
		/**
		 * Id of cloudinary account that placed this picture
		 * @var string $ImageCloudinaryId
		 **/
		private
		$ImageCloudinaryId;
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
		public
		function __construct(?int $newImageId, ?int $newImagePostId, ?string $newImageCloudinaryId) {
			try {
				$this->setImageId($newImageId);
				$this->setImagePostId($newImagePostId);
				$this->setImageCloudinaryId($newImageCloudinaryId);
			} //determine what exception type was thrown

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
		public
		function getImageId(): int {
			return ($this->ImageId);
		}

		/**
		 * mutator method for image id
		 *
		 * @param int|null $newImageId new value of image id
		 * @throws \RangeException if $newImageId is not positive
		 * @throws \TypeError if $newImageId is not an integer
		 **/
		public
		function setImageId(?int $newImageId): void {
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
		public
		function getImagePostId(): int {
			return ($this->ImagePostId);
		}

		/**
		 * mutator method for image post id
		 *
		 * @param int $newImagePostId new value of image post id
		 * @throws \RangeException if $newImagePostId is not positive
		 * @throws \TypeError if $newImagePostId is not an integer
		 **/
		public
		function setImagePostId(int $newImagePostId): void {
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
			public
			function getImageCloudinaryId(): string {
				return ($this->imageCloudinaryId);
			}

			/**
			 * mutator method for image cloudinary id
			 *
			 * @param string $newImageCloudinaryId new value of imageCloudinaryId
			 * @throws \InvalidArgumentException if $newImageCloudinaryId is not a string or insecure
			 * @throws \RangeException if $newImageCloudinaryId is >32 characters
			 * @throws \TypeError if $newImageCloudinaryId is not a string
			 **/
			public
			function setImageCloudinaryId(string $newImageCloudinaryId): void {
				// verify the cloudinary image id secure
				$newImageCloudinaryId = trim($newImageCloudinaryId);
				$newImageCloudinaryId = filter_var($newImageCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
				if(empty($newImageCloudinaryId) === true) {
					throw(new \InvalidArgumentException("image cloudinary content id insecure"));
				}
				// verify the image cloudinary id will fit in the database, need to check on what size it needs to be, only storing the sting value of the link
				//With class we only care bout storing the info, we will insert the link in the API's.
				//if(strlen($newImageCloudinaryId) > 32) {
				throw(new \RangeException("cloudinary image id too large"));
			}

			// store the cloudinary id for image
			$this->imageCloudinaryId = $newImageCloudinaryId;
		}

		/**
		 * inserts this image id into mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection object
		 **/
		public
		function insert(\PDO $pdo): void {
			// enforce the imageid is null (i.e., don't insert a image id that already exists)
			if($this->imageId !== null) {
				throw(new \PDOException("not a new image id"));
			}
			// create query template
			$query = "INSERT INTO image(imageId, imagePostId) VALUES(imageId, :imagePostId)";

		}

// update the null imagaeId with what mySQL just gave us
		$this->imageId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this image from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
	// enforce the imageId is not null (i.e., don't delete a image that hasn't been inserted)
	if($this->imageId === null) {
		throw(new \PDOException("unable to delete a image that does not exist"));
	}
	// create query template
	$query = "DELETE FROM image WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);
	// bind the member variables to the place holder in the template
	$parameters = ["imageId" => $this->imageId];
	$statement->execute($parameters);
}
/**
 * updates this Image in mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
	public function update(\PDO $pdo) : void {
	// enforce the imageId is not null (i.e., don't update a image that hasn't been inserted)
	if($this->imageId === null) {
		throw(new \PDOException("unable to update a image that does not exist"));
	}
// create query template
	$query = "UPDATE image SET imagePostId = :imagePostId, imageCloudinaryId = :imageCloudinaryId WHERE imageId = :imageId";
	$statement = $pdo->prepare($query);
	{

		// build an array of images
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$image = new Image($row["ImageId"], $row["ImagePostId"], $row["imageCloudinaryId"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($images);

	}

	/**
	 * gets the Image by imageId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imageId image id to search for
	 * @return image|null Tweet found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageByImageId(\PDO $pdo, int $imageId) : ?image {
		// sanitize the tweetId before searching
		if($imageId <= 0) {
			throw(new \PDOException("image id is not positive"));
		}
		// create query template
		$query = "SELECT imageId, imagePostId, imageCloudinaryId FROM image WHERE imageId = :imageId";
		$statement = $pdo->prepare($query);
		// bind the image id to the place holder in the template
		$parameters = ["imageId" => $imageId];
		$statement->execute($parameters);

// grab the image from mySQL
		try {
			$image = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$image = new Image($row["imageId"], $row["imagePostId"], $row["imageCloudinaryId"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($image);
	}
	/**
	 * gets the Image by post id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $imagePostId post id to search by
	 * @return \SplFixedArray SplFixedArray of Images found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getImageByImagePostId(\PDO $pdo, int $imagePostId) : \SPLFixedArray {
		// sanitize the post id before searching
		if($imagePostId <= 0) {
			throw(new \RangeException("image post id must be positive"));
		}
		// create query template
		$query = "SELECT imageId, imagePostId, imageCloudinary FROM image WHERE imagePostId = :imagePostId";
		$statement = $pdo->prepare($query);
		// bind the image post id to the place holder in the template
		$parameters = ["imagePostId" => $imagePostId];
		$statement->execute($parameters);
		// build an array of images
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$image = new image($row["imageId"], $row["imagePostId"], $row["imageCloudinary"]);
				$images[$images->key()] = $image;
				$images->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($images);
	}
	/**
	 * gets all Images
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Images found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllImages(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT imageId, imagePostId, imagePostId FROM image";
		$statement = $pdo->prepare($query);
		$statement->execute();
		// build an array of images
		$images = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$images = new Image($row["imageId"], $row["imagePostId"], $row["imageCloudinaryId"]);
				$images[$images->key()] = $images;
				$images->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($images);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//format the date so that the front end can consume it
		$fields["Date"] = round(floatval($this->Date->format("U.u")) * 1000);
		return($fields);
	}
}