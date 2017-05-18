<?php
namespace Edu\Cnm\PetRescueAbq\Test;

use Edu\Cnm\PetRescueAbq\{Profile, Organization, Post};

//grab the class under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Post Class
 *
 *This is a complete PHPUnit test of the Post class. It is complete because *ALL* my SQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Post
 * @author Jabari Farrar <tmafm1@gmail.com>
 *
 **/
class PostTest extends PetRescueAbqTest {
	/**
	 * Profile that created the Organization; this is the foreign key relations
	 * @var  Profile $profile
	 */
	protected $profile = null;

	/**
	 *Organization that created the Post; this is the foreign key relations
	 * @var  Organization $organization
	 **/
	protected $organization = null;

	/**
	 * valid profile hash to create the profile object to own the test
	 * @var $VALID_HASH ;
	 **/
	protected $VALID_HASH;

	/**
	 * valid salt to use to create the profile object to own the test
	 * @var string $VALID__SALT
	 */
	protected $VALID_SALT;

	/**
	 * valid postBreed to use to create the Post
	 * @var string $VALID_POSTBREED
	 */
	protected $VALID_POSTBREED = "brown dog";

	/**
	 * valid postDescription to use to create the Post
	 * @var string $VALID_POSTDESCRIPTION
	 */
	protected $VALID_POSTDESCRIPTION = "this is a brown dog";

	/**
	 * valid postSex to use toe create the Post
	 * @var string $VALID_ POSTSEX
	 */
	protected $VALID_POSTSEX = "M";

	/**
	 * valid postType to use to created the Post
	 * @var string $VALID_POSTTYPE
	 */
	protected $VALID_POSTTYPE = "D";

	/**
	 * create dependent objects before running each test
	 */
	public final function setUp(): void {
		parent::setUp();
		$password = "abc123";
		$profileActivationToken = bin2hex(random_bytes(16));
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);

		/**
		 * created and insert a Profile to own the test Organization
		 */
		$this->profile = new Profile(null, $profileActivationToken, "@handle", "test@phpunit.de", $this->VALID_HASH, "null", $this->VALID_SALT);
		$this->profile->insert($this->getPDO());

		//created and insert an Organization
		$this->organization = new Organization(null, $this->profile->getProfileId(),$profileActivationToken, "nsdhfbdfbiabfdfdjun", "fthwrthsrt", "Cityname", "whatever@handle.com", "asdfasdfsdcsdc", "Bogusstuff", "15552525566", "NM", "87555");
		$this->organization->insert($this->getPDO());
	}

	/**
	 * test inserting a valid post and verify that the actual mySQL data matches
	 */

	public function testInsertValidPost(): void {
		//count the number fo rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new Post and insert into mySQL
		$post = new Post(null, $this->organization->getOrganizationId(),$this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE );
		$post->insert($this->getPDO());
		var_dump($post);

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));

		$this->assertEquals($pdoPost->getPostOrganizationId(), $this->organization->getOrganizationId());
		$this->assertEquals($pdoPost->getPostBreed(), $this->VALID_POSTDESCRIPTION);
		$this->assertEquals($pdoPost->getPostDescription(), $this->VALID_POSTBREED);
		$this->assertEquals($pdoPost->getPostSex(), $this->VALID_POSTSEX);
		$this->assertEquals($pdoPost->getPostType(), $this->VALID_POSTTYPE);
	}


	/**
	 * test inserting a Post that already exists
	 * @expectedException \PDOException
	 */

	public function testInsertInvalidPost(): void {
		// create a post with a non null postId and it will fail
		$post = new Post(PetRescueAbqTest::INVALID_KEY,PetRescueAbqTest::INVALID_KEY, $this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
		$post->insert($this->getPDO());
	}


	/**
	 * test inserting a Post, editing it, and then updating it
	 */
	public function testUpdateValidPost(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new Post and insert it into mySQL
		$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
		$post->insert($this->getPDO());


		//edit the Post and update it in mySQL
		$post->setPostBreed($this->VALID_POSTBREED);
		$post->update($this->getPDO());


		//grab the data from mySQL and enforce the fields match our expectations
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));

		$this->assertEquals($pdoPost->getPostOrganizationId(), $this->organization->getOrganizationId());
		$this->assertEquals($pdoPost->getPostBreed(), $this->VALID_POSTBREED);
		$this->assertEquals($pdoPost->getPostDescription(), $this->VALID_POSTDESCRIPTION);
		$this->assertEquals($pdoPost->getPostSex(), $this->VALID_POSTSEX);
		$this->assertEquals($pdoPost->getPostType(), $this->VALID_POSTTYPE);
	}

	/**
	 * test updating a Post that does not exists
	 * @expectedException \PDOException
	 */
	public function testUpdateInvalidPost(): void {

		//create a Post with a non null post id and watch it fail
		$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
		$post->update($this->getPDO());
	}


	/**
	 * test creating a Post and then deleting it
	 */
	public function testDeleteValidPost(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new Post and insert it into mySQL
		$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
		$post->insert($this->getPDO());

		//delete the Post from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$post->delete($this->getPDO());

		//grab the data from mySQL and enforce the Post does not exist
		$pdoPost = Post::getPostByPostId($this->getPDO(), $post->getPostId());
		$this->assertNull($pdoPost);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("post"));
	}

	/**
	 * test deleting a Post that does not exist
	 * @expectedException \PDOException
	 */
	public function testDeleteInvalidPost(): void {
		//create a Post and try to delete it without actually inserting it
		$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
		$post->delete($this->getPDO());
	}

	/**
	 * test grabbing a post that does not exist
	 */
	public function testGetInvalidPostByPostId(): void {
		//grab a organization id that exceeds the maximum allowable profile id
		$post = Post::getPostByPostId($this->getPdo(), PetRescueAbqTest::INVALID_KEY);
		$this->assertNull($post);
	}

	/**
	 * test inserting a Post and regrabbing it from mySQL
	 */
	public function testGetValidPostByPostOrganizationId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new Post and insert into mySQL
		$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTDESCRIPTION, $this->VALID_POSTBREED, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
		$post->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations

		$results = Post::getPostsByPostOrganizationId($this->getPdO(), $post->getPostOrganizationId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetRescueAbq\\Post", $results);

		//grab the result from the array and validate it
		$pdoPost = $results[0];

		$this->assertEquals($pdoPost->getPostOrganizationId(), $this->organization->getOrganizationId());
		$this->assertEquals($pdoPost->getPostDescription(), $this->VALID_POSTDESCRIPTION);
		$this->assertEquals($pdoPost->getPostBreed(), $this->VALID_POSTBREED);
		$this->assertEquals($pdoPost->getPostSex(), $this->VALID_POSTSEX);
		$this->assertEquals($pdoPost->getPostType(), $this->VALID_POSTTYPE);
	}

		/**
		 * grabbing all the Posts
		 */
		public function testGetAllValidPosts(): void {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("post");

			//create a new Post and insert it into mySQL
			$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTDESCRIPTION, $this->VALID_POSTBREED, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
			$post->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$results = Post::getAllPosts($this->getPDO());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
			$this->assertCount(1, $results);
			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetRescueAbq\\Post", $results);

			/**
			 * grab the results from the array and validate it
			 */
			$pdoPost = $results[0];
			$this->assertEquals($pdoPost->getPostOrganizationId(), $this->organization->getOrganizationId());
			$this->assertEquals($pdoPost->getPostDescription(), $this->VALID_POSTDESCRIPTION);
			$this->assertEquals($pdoPost->getPostBreed(), $this->VALID_POSTBREED);
			$this->assertEquals($pdoPost->getPostSex(), $this->VALID_POSTSEX);
			$this->assertEquals($pdoPost->getPostType(), $this->VALID_POSTTYPE);
		}


		/**
		 * test grabbing the post by post sex
		 */

		public function testGetValidPostsByPostSex() : void {
			//count the number of rows and save it for later
			$numRows = $this->getConnection()->getRowCount("post");

			//create a new Post and insert into mySQL
			$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
			$post->insert($this->getPDO());

			//grab the data from mySQL and enforce the fields match our expectations
			$results = Post::getPostByPostSex($this->getPDO(), $post->getPostSex());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
			$this->assertCount(1, $results);

			//enforce no other objects are bleeding into the test
			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetRescueAbq\\Post", $results);

			//grab the results from the array and validate it

			$pdoPost = $results[0];
			$this->assertEquals($pdoPost->getPostOrganizationId(), $this->organization->getOrganizationId());
			$this->assertEquals($pdoPost->getPostDescription(), $this->VALID_POSTDESCRIPTION);
			$this->assertEquals($pdoPost->getPostBreed(), $this->VALID_POSTBREED);
			$this->assertEquals($pdoPost->getPostSex(), $this->VALID_POSTSEX);
			$this->assertEquals($pdoPost->getPostType(), $this->VALID_POSTTYPE);


		}
	/**
	 * test grabbing the post by post type
	 */

	public function testGetValidPostsByPostType() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("post");

		//create a new Post and insert into mySQL
		$post = new Post(null, $this->organization->getOrganizationId(), $this->VALID_POSTBREED, $this->VALID_POSTDESCRIPTION, $this->VALID_POSTSEX, $this->VALID_POSTTYPE);
		$post->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Post::getPostByPostType($this->getPDO(), $post->getPostType());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("post"));
		$this->assertCount(1, $results);

		//enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\PetRescueAbq\\Post", $results);

		//grab the results from the array and validate it

		$pdoPost = $results[0];
		$this->assertEquals($pdoPost->getPostOrganizationId(), $this->organization->getOrganizationId());
		$this->assertEquals($pdoPost->getPostDescription(), $this->VALID_POSTDESCRIPTION);
		$this->assertEquals($pdoPost->getPostBreed(), $this->VALID_POSTBREED);
		$this->assertEquals($pdoPost->getPostSex(), $this->VALID_POSTSEX);
		$this->assertEquals($pdoPost->getPostType(), $this->VALID_POSTTYPE);

	}
}



