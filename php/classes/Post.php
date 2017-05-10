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
	 * id for the post organization; this is the foreign key
	 * @var int $postOrganizationId
	 **/
	private $postOrganizationId;

	/**Breed of the animal
	 * @var string $postBreed
	 **/
	private $postBreed;

	/**Description of post
	 * @var string $postDescription
	 * */
	private $postDescription;

	/**Sex of the animal
	 * @var string $postSex
	 * */
	private $postSex;

	/**Type of post
	 * @var string $postType
	 * */
	private $postType;

	/**
	 * Constructor for this post
	 * @param int| null $newPostId id of this post
	 * @param int| null $newPostOrganizationId
	 * @param string $newPostBreed breed of the animal
	 * @param string $newPostDescription description of the animal
	 * @param string $newPostSex Sex of the animal
	 * @param string $newPostType Type of post
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings are too long, negative integers)
	 * @throws \TypeError if the data types violate the hints
	 * @throws \Exception if some other exception occurs
	 * */

	public function __construct(int $newPostId, ?int $newPostOrganizationId, string $newPostBreed, string $newPostDescription, string $newPostSex, string $newPostType) {
		try {
			$this->setPostId($newPostId);
			$this->setPostOrganizationId($newPostOrganizationId);
			$this->setPostBreed($newPostBreed);
			$this->setPostDescription($newPostDescription);
			$this->setPostSex($newPostSex);
			$this->setPostType($newPostType);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException| \RangeException | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

	}

	/**
	 * accessor method for post id
	 * @return int value of post id
	**/

	public function getPostId(): ?int {
		return ($this->postId);
	}

	/**mutator method for post id
	 *
	 * @param int $newPostId new value for post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/

		public function setPostId(int $newPostId) : void {
			if($newPostId === null) {
				$this->postId = null;
				return;
			}

		//verify that the post id is positive
		if($newPostId <= 0) {
			throw(new \RangeException("please enter a positive value"));
		}
		// convert and store post id
		$this->postId = $newPostId;
			}
	/**
	 * accessor method for post organization id
	 * @return int value of post organization id
	 **/

	public function getPostOrganizationId(): ?int {
		return ($this->postOrganizationId);
	}
	/**mutator method for post organization id
	 *
	 * @param int $newPostOrganizationId new value for post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not an integer
	 **/

	public function setPostOrganizationId(int $newPostOrganizationId) : void {
		if($newPostOrganizationId === null) {
			$this->postOrganizationId = null;
			return;
		}

		//verify that the post id is positive
		if($newPostOrganizationId <= 0) {
			throw(new \RangeException("please enter a positive value"));
		}
		// convert and store post id
		$this->postOrganizationId = $newPostOrganizationId;
	}


		/** accessor method for postBreed
		 *
		 * @return string value of post Breed
		 **/

		public function getPostBreed(): ?string {
		return ($this->postBreed);
	}
	/**
	 * mutator method for post breed
	 * @param string $newPostBreed
	 * @throws \InvalidArgumentException if $newPostBreed is not a string or insecure
	 * @throws \RangeException if $newPostBreed in > 32 characters
	 * @throws \TypeError if $newPostBreed is not a string
	 **/

			public function setPostBreed(string $newPostBreed) : void {
			//verify teh post content is secure
			$newPostBreed = trim ($newPostBreed);
			$newPostBreed = filter_var($newPostBreed, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($newPostBreed) === true) {
				throw(new \InvalidArgumentException("Please enter breed type"));
			}
			//verify the post breed will fit into the database
			if(strlen($newPostBreed) > 32) {
				throw(new \RangeException("The breed type is too long"));
			}
			//store this post content
			$this->postBreed = $newPostBreed;
			}

	/** accessor method for post Description
	 *
	 * @return string value of post Description
	 **/
	public function getPostDescription(): ?string {
		return $this->postDescription;
	}
	/**
	 * mutator method for post Description
	 * @param string $newPostDescription the new value of the post description
	 * @throws \InvalidArgumentException if $newPostDescription is not a string or insecure
	 * @throws \RangeException if $newPostDescription is > 255 characters
	 * @throws \TypeError if $newPostDescription is not a string
	 **/

	public function setPostDescription($newPostDescription) : void {
		$this->postDescription = $newPostDescription;
		//verify that the post description is secure
		$newPostDescription = trim($newPostDescription);
		$newPostDescription = filter_var($newPostDescription, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostDescription) === true) {
			throw(new \InvalidArgumentException("post description is empty or insecure"));
	}

		//verify the post description will fit in the database
		if(strlen($newPostDescription) > 255)  {
			throw(new \RangeException("Description is too large"));
		}
		// store this description
		$this->postDescription = $newPostDescription;
	}

	/**
	 * accessor method for Post Sex
	 * @return string value of post sex
	 */

	public function getPostSex() {
		return ($this->postSex);
	}
	/**
	 * mutator method for post sex
	 * @param string $newPostSex new value for post sex
	 * @throws \InvalidArgumentException if $newPostSex is insecure
	 * @throws \RangeException if $newPostSex is > 1 character
	 * @throws \TypeError if $newPostSex is not a string
	 **/

	public function setPostSex(string $newPostSex) : void {
		$newPostSex = trim ($newPostSex);
		$newPostSex = filter_var($newPostSex, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostSex)=== true) {
			throw(new \InvalidArgumentException("The sex is empty or insecure."));
		} if(strlen($newPostSex) > 1) {
			throw(new \RangeException("You can only use one letter"));
		}
		$this->postSex = $newPostSex;
	}
	/** accessor method for post type
	 *
	 * @return string $postType value of post type
	**/

	public function getPostType() : ?string {
		return ($this->postType);
	}
	/**
	 * mutator method for post type
	 * @param string $newPostType new value of post type
	 * @throws \InvalidArgumentException if $newPostType is insecure
	 * @throws \RangeException if $newPostType is > 1 character
	 * @throws \TypeError if $newPostType is not a string
	 **/

	public function setPostType(string $newPostType) : void {
		$newPostType = trim($newPostType);
		$newPostType = filter_var($newPostType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostType) === true) {
			throw(new \InvalidArgumentException("The post type is empty or insecure."));
		}
		if(strlen($newPostType) > 1) {
			throw(new \RangeException("You can only use one letter"));
		}
		$this->postType = $newPostType;
	}

	/**
	 * inserts this post in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/

		public function insert(\PDO $pdo): void {
			// enforce the profileId is null (ie. don't insert a post ID that already exists)
			if($this->postId !== null) {
			throw (new \PDOException("not a new post"));
			}
			//create query template
			$query = "INSERT INTO post(postOrganizationId, postBreed, postDescription, postSex, postType) VALUES( :postOrganizationId, :postDescription, :postBreed, :postSex, :postType)";
			$statement = $pdo->prepare($query);

			// bind the member variables to the place holders in the template
			$parameters =  ["postOrganizationId"=> $this->postOrganizationId, "postBreed" => $this->postBreed, "postDescription" => $this->postDescription, "postSex" => $this->postSex, "postType" => $this->postType];
			$statement->execute($parameters);
			// update the null postId with what mySQL just gave us
			$this->postId = intval($pdo->lastInsertId());
		}

		/**
		 * deletes this post in mySQL
		 *
		 * @param \PDO $pdo PDO connection object
		 * @throws \PDOException when mySQL related errors occur
		 * @throws \TypeError if $pdo is not a PDO connection
		 **/
			public function delete(\PDO $pdo) {
				//enforce the postID is not null (i.e., don't delete a post that hasn't been inserted)
				if($this->postId ===null) {
					throw(new \PDOException("can't delete a post that is not there"));
				}
				//create query template
				$query = "DELETE FROM post WHERE postId = :postId";
				$statement =  $pdo->prepare($query);

				//bind the member variables to the place holder in the template
				$parameters = ["postId" => $this->postId];
				$statement->execute($parameters);
			}

			/** updates the post in my SQl
			 *
			 * @param \PDO $pdo PDO connection object
			 * @throws \PDOException when mySQL related errors occur
			 * @throws \TypeError if $pdo is not a PDO connection
			 **/
				public function update(\PDO $pdo): void {
					//enforce the postId is not null (i.e., don't update a post that does not exist)
					if($this->postId === null) {
						throw(new \PDOException("Can't update a profile that does not exist"));
					}
						//create query template
						$query = "UPDATE post SET postId = :postId, postOrganizationId = :postOrganizationId, postBreed = :postBreed, postDescription = :postDescription, postSex = :postSex, postType = :postType";
						$statement = $pdo->prepare($query);

						//bind the member variables to the place holders in the template
						$parameters = ["postOrganizationId" => $this->postOrganizationId, "postBreed" => $this->postBreed, "postDescription" => $this->postDescription, "postSex" => $this->postSex, "postType" => $this->postType];

						$statement->execute($parameters);
					}

					/**
					 * gets the Post by Post Id
					 *
					 * @param \PDO $pdo PDO connection object
					 * @param int $postId post id to search for
					 * @return Post|null Post found or null if not found
					 * @throws \PDOException when my SQL related error occurs
					 * @throws \TypeError when variables are not the correct data type
					 *
					 **/
					public static function getPostByPostId(\PDO $pdo, int $postId) {
						//sanitize the postId before searching
						if($postId <= 0) {
							throw(new\PDOException("post id is not positive"));
						}
						// create query template
						$query = "SELECT postId, postOrganizationId, postBreed, postDescription, postSex, postType";
						$statement = $pdo->prepare($query);

						//bind the post id to the place holder in the template
						$parameters = ["postId" => $postId];
						$statement->execute($parameters);

						// grab the post from mySQL
						try {
							$post = null;
							$statement->setFetchMode(\PDO::FETCH_ASSOC);
							$row = $statement->Fetch();

							if($row !== false) {
								$post = new Post($row["postId"], $row["postOrganizationId"], $row["postBreed"], $row["postDescription"], $row["postSex"], $row["postType"]);
							}

						} catch(\Exception $exception) {
							// if the row couldn't be converted, rethrow it
							throw(new \PDOException($exception->getMessage(), 0, $exception));
						}
						return ($post);
					}

					/**
					 * gets the Post by Post Organization Id
					 *
					 * @param \PDO $pdo PDO connection object
					 * @param int $postOrganizationId post id to search for
					 * @return Post|null Post found or null if not found
					 * @throws \PDOException when my SQL related error occurs
					 * @throws \TypeError when variables are not the correct data type
					 *
					 * might be wrong @RoLopez
					 **/
					public static function getPostByPostOrganizationId(\PDO $pdo, int $postOrganizationId) {
						//sanitize the postId before searching
						if($postOrganizationId <= 0) {
							throw(new\PDOException("post organization id is not positive"));
						}
						// create query template
						$query = "SELECT postId, postOrganizationId, postBreed, postDescription, postSex, postType";
						$statement = $pdo->prepare($query);

						//bind the post id to the place holder in the template
						$parameters = ["postOrganizationId" => $postOrganizationId];
						$statement->execute($parameters);

						// grab the post from mySQL
						try {
							$post = null;
							$statement->setFetchMode(\PDO::FETCH_ASSOC);
							$row = $statement->Fetch();
							if($row !== false) {
								$post = new Post($row["postId"], $row["postOrganizationId"], $row["postBreed"], $row["postDescription"], $row["postSex"], $row["postType"]);
							}

						} catch(\Exception $exception) {
							// if the row couldn't be converted, rethrow it
							throw(new \PDOException($exception->getMessage(), 0, $exception));
						}
						return ($post);
					}

					/**
					 *gets the Post by post breed
					 *
					 * @param \PDO $pdo PDO connection Object
					 * @param string $postBreed to search for
					 * @return \SplFixedArray SplFixedArray of Posts found
					 * @throws \ PDOException when mySQL related errors occur
					 * @throws \TypeError when variables are not correct data type
					 **/
					public static function getPostByPostBreed(\PDO $pdo, string $postBreed) {
						// sanitize the description before searching
						$postBreed = trim($postBreed);
						$postBreed = filter_var($postBreed, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
						if(empty($postBreed) === true) {
							throw(new \PDOException("post breed is invalid"));
						}
						// create query template
						$query = "SELECT postId, postOrganizationId, postBreed, postDescription, postSex, postType FROM post WHERE postBreed = :postBreed";
						$statement = $pdo->prepare($query);

						// bind the Post Breed to the place holder in the template
						$postBreed = "%$postBreed%";
						$parameters = ["postBreed" => $postBreed];
						$statement->execute($parameters);

						// build an array of Posts
						$posts = new \SplFixedArray($statement->rowCount());
						$statement->setFetchMode(\PDO::FETCH_ASSOC);
						while(($row = $statement->fetch()) !== false) {
							try {
								$post = new Post($row["postId"], $row["postOrganizationId"], $row["postBreed"], $row["postDescription"], $row["postSex"], $row["postType"]);
								$posts [$post->key()] = $post;
								$posts->next();
							} catch(\Exception $exception) {
								//if the row couldn't be converted, rethrow it
								throw(new \PDOException($exception->getMessage(), 0, $exception));
							}
						}
						return ($posts);
					}

					/**
					 *gets the Post by post description
					 *
					 * @param \PDO $pdo PDO connection Object
					 * @param string $postDescription to search for
					 * @return \SplFixedArray SplFixedArray of Posts found
					 * @throws \PDOException when mySQL related errors occur
					 * @throws \TypeError when variables are not correct data type
					 **/
					public static function getPostByPostDescription(\PDO $pdo, string $postDescription) {
						// sanitize the description before searching
						$postDescription = trim($postDescription);
						$postDescription = filter_var($postDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
						if(empty($postDescription) === true) {
							throw(new \PDOException("post description is invalid"));
						}
						// create query template
						$query = "SELECT postId, postOrganizationId, postBreed, postDescription, postSex, postType FROM post WHERE postDescription  = :postDescription";
						$statement = $pdo->prepare($query);

						// bind the Post Description to the place holder in the template
						$postDescription = "%$postDescription%";
						$parameters = ["postDescription" => $postDescription];
						$statement->execute($parameters);

						// build an array of Posts
						$posts = new \SplFixedArray($statement->rowCount());
						$statement->setFetchMode(\PDO::FETCH_ASSOC);
						while(($row = $statement->fetch()) !== false) {
							try {
								$post = new Post($row["postId"], $row["postOrganizationId"], $row["postBreed"], $row["postDescription"], $row["postSex"], $row["postType"]);
								$posts [$post->key()] = $post;
								$posts->next();
							} catch(\Exception $exception) {
								//if the row couldn't be converted, rethrow it
								throw(new \PDOException($exception->getMessage(), 0, $exception));
							}
						}
						return ($posts);
					}

					/**
					 *gets the Post by post sex
					 *
					 * @param \PDO $pdo PDO connection Object
					 * @param string $postSex to search for
					 * @return \SplFixedArray SplFixedArray of Posts found
					 * @throws \ PDOException when mySQL related errors occur
					 * @throws \TypeError when variables are not correct data type
					 **/
					public static function getPostByPostSex(\PDO $pdo, string $postSex) {
						// sanitize the description before searching
						$postSex = trim($postSex);
						$postSex = filter_var($postSex, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
						if(empty($postSex) === true) {
							throw(new \PDOException("post description is invalid"));
						}
						// create query template
						$query = "SELECT postId, postOrganizationId, postBreed, postDescription, postSex, postType FROM post WHERE postSex  = :postSex";
						$statement = $pdo->prepare($query);

						// bind the Post Sex to the place holder in the template
						$postSex = "%$postSex%";
						$parameters = ["postSex" => $postSex];
						$statement->execute($parameters);

						// build an array of Posts
						$posts = new \SplFixedArray($statement->rowCount());
						$statement->setFetchMode(\PDO::FETCH_ASSOC);
						while(($row = $statement->fetch()) !== false) {
							try {
								$post = new Post($row["postId"], $row["postOrganizationId"], $row["postBreed"], $row["postDescription"], $row["postSex"], $row["postType"]);
								$posts [$post->key()] = $post;
								$posts->next();

							} catch(\Exception $exception) {
								//if the row couldn't be converted, rethrow it
								throw(new \PDOException($exception->getMessage(), 0, $exception));
							}
						}
						return ($posts);
					}

					/**
					 *gets the Post by post type
					 *
					 * @param \PDO $pdo PDO connection Object
					 * @param string $postType to search for
					 * @return \SplFixedArray SplFixedArray of Posts found
					 * @throws \ PDOException when mySQL related errors occur
					 * @throws \TypeError when variables are not correct data type
					 **/
					public static function getPostByPostType(\PDO $pdo, string $postType) {
						// sanitize the description before searching
						$postType = trim($postType);
						$postType = filter_var($postType, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
						if(empty($postType) === true) {
							throw(new \PDOException("post description is invalid"));
						}
						// create query template
						$query = "SELECT postId, postOrganizationId, postBreed, postDescription, postSex, postType FROM post WHERE postType  = :postType";
						$statement = $pdo->prepare($query);

						// bind the Post Type to the place holder in the template
						$postType = "%$postType%";
						$parameters = ["postSex" => $postType];
						$statement->execute($parameters);

						// build an array of Posts
						$posts = new \SplFixedArray($statement->rowCount());
						$statement->setFetchMode(\PDO::FETCH_ASSOC);
						while(($row = $statement->fetch()) !== false) {
							try {
								$post = new Post($row["postId"], $row["postOrganizationId"], $row["postBreed"], $row["postDescription"], $row["postSex"], $row["postType"]);
								$posts [$post->key()] = $post;
								$posts->next();
							} catch(\Exception $exception) {
								//if the row couldn't be converted, rethrow it
								throw(new \PDOException($exception->getMessage(), 0, $exception));
							}
						}
						return ($posts);
					}

					/**
					 * get all the posts
					 * @param \PDO $pdo PDO connection object
					 * @return \SplFixedArray SplFixedArray of Posts found or null if not found
					 * @throws \PDOException when mySQL related errors occur
					 * @throws \TypeError when variables are not the correct data type
					 */

					public static function getAllPosts(\PDO $pdo): \SplFixedArray {
						//create query template
						$query = "SELECT postId, postrganizationId, postBreed, postDescription, postSex, postType FROM post";
						$statement = $pdo->prepare($query);
						$statement->execute();

						//build an array of Posts
						$posts = new \SplFixedArray($statement->rowCount());
						$statement->setFetchMode(\PDO::FETCH_ASSOC);
						while(($row = $statement->fetch()) !== false) {

							try {
								$post = new Post($row["postId"], $row["postOrganizationId"], $row["postDescription"], $row["postSex"], $row["postBreed"], $row["postType"]);
								$posts[$posts->key()] = $post;
								$posts->next();

							} catch(\Exception $exception) {
								//if the row could not be converted, rethrow it
								throw(new \PDOException($exception->getMessage(), 0, $exception));

							}
						}
						return ($posts);
					}

					/**
					 * formats the state variables for JSON serialization
					 *
					 * @return array resulting state variables to serialize
					 **/
					public
					function jsonSerialize() {
						$fields = get_object_vars($this);
						return ($fields);
					}


				}