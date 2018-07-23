<?php
namespace Rbecker8\DataDesign;

require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;


/**
 * Small Cross Section of an IGN like Game Review
 *this answer can be considered a small example of what services like IGN store when game reviews are added
 *to their website.  This can easily be extended to emulate more features of IGN's website.
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 **/

class Review {
	use ValidateUuid;
	use ValidateDate;
	/**
	 * id for this Review; this is the primary key
	 * @var Uuid $reviewId
	 **/
	private $reviewId;
	/**
	 * id of the Reviewer that wrote this Review; this is a foreign key
	 * @var Uuid $reviewReviewerId
	 **/
	private $reviewReviewerId;
	/**
	 * id of console review written for
	 * @var string $reviewConsole
	 **/
	private $reviewConsole;
	/**
	 * date of review release
	 * @var \DateTime $reviewReleaseDate
	 **/
	private $reviewDate;
	/**
	 * rating of review
	 * @var int $reviewRating
	 */
	private $reviewRating;
	/**
	 * content of review
	 * @var string $reviewContent
	 */
	private $reviewContent;


	/**
	 * Review constructor
	 * @param string|Uuid $newReviewId id of this review
	 * @param string|Uuid $newReviewReviewerId id of the reviewer that wrote this review
	 * @param string $newReviewConsole string containing review console data
	 * @param \DateTime|string|null $newReviewDate date and time Review was submitted or null if set to current date and time
	 * @param int $newReviewRating string containing review rating data
	 * @param string $newReviewContent string containing actual review data
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(Uuid $newReviewId, Uuid $newReviewReviewerId, string $newReviewConsole, $newReviewDate,int $newReviewRating,string $newReviewContent) {
	try{
		$this->setReviewId($newReviewId);
		$this->setReviewReviewerId($newReviewReviewerId);
		$this->setReviewConsole($newReviewConsole);
		$this->setReviewDate($newReviewDate);
		$this->setReviewRating($newReviewRating);
		$this->setReviewContent($newReviewContent);
	} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
		$exceptionType = get_class($exception);
		throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}


	/**
	 * accessor method for review id
	 *
	 * @return Uuid value for review id
	 **/
	public function getReviewId(): Uuid {
		return ($this->reviewId);
	}


	/**
	 * mutator method for review id
	 *
	 * @param Uuid/string $newReviewId new value of review id
	 * @throws \RangeException if $newReviewId is n
	 * @throws \TypeError if $newReviewId is not a uuid.e
	 **/
	public function setReviewId($newReviewId): void {
		try {
			$uuid = self::validateUuid($newReviewId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store review id
		$this->reviewId = $uuid;
	}


	/**
	 * accessor method for review reviewer id
	 *
	 * @return Uuid value of review reviewer id
	 */
	public function getReviewReviewerId(): Uuid {
		return ($this->reviewReviewerId);
	}

	/**
	 * mutator method for review reviewer id
	 *
	 * @param string | Uuid $newReviewReviewerId new value of review reviewer id
	 * @throws \RangeException if $newReviewerId is not positive
	 * @throws \TypeError if $newReviewReviewerId is not a UUI
	 */
	public function setReviewReviewerId($newReviewReviewerId): void {
		try {
			$uuid = self::validateUuid($newReviewReviewerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store reviewer id
		$this->reviewReviewerId = $uuid;
	}

	/**
	 * accessor method for review console
	 *
	 * @return string value of review console
	 */
	public function getReviewConsole(): string {
		return ($this->reviewConsole);
	}

	/**
	 * mutator method for review console
	 *
	 * @param string $newReviewConsole new value of review console
	 * @throws \InvalidArgumentException if $newReviewConsole is not a string or insecure
	 * @throws \RangeException if $newReviewConsole is > 16 characters
	 * @throws \TypeError if $newReviewConsole is not a string
	 **/
	public function setReviewConsole(string $newReviewConsole): void {
		// verify the review console is secure
		$newReviewConsole = trim($newReviewConsole);
		$newReviewConsole = filter_var($newReviewConsole, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newReviewConsole) === true) {
			throw(new \InvalidArgumentException("review console is empty or insecure"));
		}

		//verify the review console will fit in the database
		if(strlen($newReviewConsole) > 16) {
			throw(new \RangeException("review console too large"));
		}

		//store the review console
		$this->reviewConsole = $newReviewConsole;
	}

	/**
	 * accessor method for review date
	 *
	 * @return \DateTime value of review date
	 **/
	public function getReviewDate(): \DateTime {
		return ($this->reviewDate);
	}

	/**
	 * mutator method for review date
	 *
	 * @param \DateTime|string|null $newReviewDate review date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newReviewDate is not a valid object or string
	 * @throws \RangeException if $newReviewDate is a date that does not exist
	 **/
	public function setReviewDate($newReviewDate = null): void {
		//base case: if the date is null, use current date and time
		if($newReviewDate === null) {
			$this->reviewDate = new \DateTime();
			return;
		}

		// store the review date using ValidateDate trait
		try {
			$newReviewDate = self::validateDateTime($newReviewDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the review date
		$this->reviewDate = $newReviewDate;
	}

	/**
	 * accessor method for review rating
	 *
	 * @return int value of review rating
	 **/
	public function getReviewRating(): int {
		return ($this->reviewRating);
	}

	/**
	 * mutator method for review rating
	 *
	 * @param int|null $newReviewRating new value of review rating
	 * @throws \InvalidArgumentException if $newReviewRating is not an int or insecure
	 * @throws \RangeException if $newReviewRating is > 2 int
	 * @throws \TypeError if $newReviewRating is not an int
	 **/
	public function setReviewRating(int $newReviewRating): void {
		// verify the review rating is secure
		if($newReviewRating < 0 || $newReviewRating < 10) {
			throw new \RangeException("rating is empty or insecure");
		}
		// store review rating
		$this->reviewRating = $newReviewRating;
	}

	/**
	 * accessor method for review content
	 *
	 * @return string value of review content
	 **/
	public function getReviewContent() : string {
		return($this->reviewContent);
	}

	/**
	 * mutator method for review content
	 *
	 * @param string $newReviewContent new value of review content
	 * @throws \InvalidArgumentException if $newReviewContent is not a string or insecure
	 * @throws \RangeException if $newTweetContent is > 40000 characters
	 * @throws \TypeError if $newReviewContent is not a string
	 */
	public function setReviewContent(string $newReviewContent) : void {
		// verify the review content is secure
		$newReviewContent = trim($newReviewContent);
		$newReviewContent = filter_var($newReviewContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newReviewContent) === true) {
			throw(new \InvalidArgumentException("review content is empty or insecure"));
		}

		// verify the review content will fit in the database
		if(strlen($newReviewContent) > 10000) {
			throw(new \RangeException("review content too large"));
		}
		// store the review content
		$this->reviewContent = $newReviewContent;
	}


	/**
	 * inserts this Review into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throw \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {


				// create query template
				$query = "INSERT INTO review(reviewId, reviewReviewerId, reviewConsole, reviewDate, reviewRating, ReviewContent) VALUES(:reviewId, :reviewReviewerId, :reviewConsole, :reviewDate, :reviewRating, :reviewContent)";
				$statement = $pdo->prepare($query);

				// bind the member variables to the place holders in the template
				$formattedDate = $this->reviewDate->format("Y-m-d H:i:s.u");
				$parameters = ["reviewId" => $this->reviewId->getBytes(), "reviewReviewerId" => $this->reviewReviewerId->getBytes(), "reviewConsole" => $this->reviewConsole, "reviewDate" => $formattedDate, "reviewRating" => $this->reviewRating, "reviewContent" => $this->reviewContent];
				$statement->execute($parameters);
	}


	/**
	 * deletes this Review from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {


				// create query template
				$query = "DELETE FROM review WHERE reviewId = :reviewId";
				$statement = $pdo->prepare($query);


				// bind the member variables to the place holder in the template
				$parameters = ["reviewId" => $this->reviewId->getBytes()];
				$statement->execute($parameters);
	}

	/**
	 * updates this Review in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {


				// create query template
				$query = "UPDATE review SET reviewReviewerId = :reviewReviewerId, reviewConsole = :reviewConsole, reviewRating = :reviewRating, reviewContent = :reviewContent, reviewDate = reviewDate WHERE reviewId = :reviewId";
				$statement = $pdo->prepare($query);


				$formattedDate = $this->reviewDate->format("Y-m-d H:i:s.u");
				$parameters = ["reviewID" => $this->reviewId->getBytes(), "reviewReviewerId" => $this->reviewReviewerId->getBytes(), "reviewConsole" => $this->reviewConsole, "reviewDate" => $formattedDate, "reviewRating" => $this->reviewRating, "reviewContent" => $this->reviewContent];
				$statement->execute($parameters);
	}


	/**
	 * get the review by review id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string|Uuid $reviewId review id to search for
	 * @return Review|null Review found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not correct data type
	 **/
	public static function getReviewByReviewId(\PDO $pdo, $reviewId) : ?Review {
		// sanitize the reviewId before searching
		try {
				$reviewId = self::validateUuid($reviewId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		// create query template
		$query = "SELECT reviewId, reviewReviewerId, reviewConsole, reviewRating, reviewContent, reviewDate FROM review WHERE reviewId = :reviewId";
		$statement = $pdo->prepare($query);


		// bind the review id to the place holder in the template
		$parameters = ["reviewId" => $reviewId->getBytes()];


		// grab the review from mySQL
		try {
			$review = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$review = new Review($row["reviewId"], $row["reviewReviewerId"], $row["reviewConsole"], $row["reviewDate"], $row["reviewRating"], $row["reviewContent"]);
			}
		} catch (\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new\PDOException($exception->getMessage(), 0, $exception));
		}
		return($review);
	}

	/**
	 * get the Review by reviewer id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $reviewReviewerId reviewer id to search by
	 * @return \SplFixedArray SplFixedArray of Reviews found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public function getReviewByReviewerId(\PDO $pdo, string $reviewReviewerId) : \SplFixedArray {

				try {
						$reviewReviewerId= self::validateUuid($reviewReviewerId);
				} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}


				// create query template
				$query = "SELECT reviewId, reviewReviewerId, reviewConsole, reviewRating, reviewContent, reviewDate FROM review WHERE reviewReviewerId = :reviewReviewerId";
				$statement = $pdo->prepare($query);
				// bind the review reviewer id to the place holder in the template
				$parameters = ["reviewReviewerId" => $reviewReviewerId->getBytes()];
				$statement->execute($parameters);
				// build an array of reviews
				$reviews = new \SplFixedArray($statement->rowCount());
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				while(($row = $statement->fetch()) !== false) {
						try {
									$review = new Review($row["reviewId"], $row["reviewReviewerId"], $row["reviewConsole"], $row["reviewDate"], $row["reviewRating"], $row["reviewContent"]);
									$reviews[$reviews->key()] = $review;
									$reviews->next();
						} catch(\Exception $exception) {
								// if the row couldn't be converted, rethrow it
								throw(new \PDOException($exception->getMessage(), 0, $exception));
						}
				}
				return($reviews);
	}


	/**
	 * get the Review by console
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $reviewConsole review console to search for
	 * @return \SplFixedArray SplFixedArray of Reviews found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public function getReviewByReviewConsole(\PDO $pdo, string $reviewConsole) : \SplFixedArray {
		// sanitize the description before searching
		$reviewConsole = trim($reviewConsole);
		$reviewConsole = filter_var($reviewConsole, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($reviewConsole) === true) {
				throw(new \PDOException("review console is invalid"));
		}

		// escape any mySQL wild cards
		$reviewConsole = str_replace("_". "\\_", str_replace("%", "\\%", $reviewConsole));

		// create query template
		$query = "SELECT reviewId, reviewReviewerId, reviewConsole, reviewRating, reviewContent, reviewDate FROM review WHERE reviewConsole LIKE :reviewConsole";
		$statement = $pdo->prepare($query);

		// bind the review console to the place holder in the template
		$reviewConsole = "%$reviewConsole%";
		$parameters = ["reviewConsole" => $reviewConsole];
		$statement->execute($parameters);

		// build an array of reviews
		$reviews = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
				try {
							$review = new Review($row["reviewId"], $row["reviewReviewerId"], $row["reviewConsole"], $row["reviewDate"], $row["reviewRating"], $row["reviewContent"]);
							$reviews[$reviews->key()] = $review;
							$reviews->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}

		}
		return($reviews);
	}


	/**
	 * get the Review by content
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $reviewContent review content to search for
	 * @return \SplFixedArray SplFixedArray of Reviews found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public function getReviewByReviewContent(\PDO $pdo, string $reviewContent) : \SplFixedArray {
		// sanitize the description before searching
		$reviewContent = trim($reviewContent);
		$reviewContent = filter_var($reviewContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($reviewContent) === true) {
			throw(new \PDOException("review content is invalid"));
		}

		// escape any mySQL wild cards
		$reviewContent = str_replace("_". "\\_", str_replace("%", "\\%", $reviewContent));

		// create query template
		$query = "SELECT reviewId, reviewReviewerId, reviewConsole, reviewRating, reviewContent, reviewDate FROM review WHERE reviewConsole LIKE :reviewConsole";
		$statement = $pdo->prepare($query);

		// bind the review content to the place holder in the template
		$reviewContent = "%$reviewContent%";
		$parameters = ["reviewContent" => $reviewContent];
		$statement->execute($parameters);

		// build an array of reviews
		$reviews = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$review = new Review($row["reviewId"], $row["reviewReviewerId"], $row["reviewConsole"], $row["reviewDate"], $row["reviewRating"], $row["reviewContent"]);
				$reviews[$reviews->key()] = $review;
				$reviews->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		}
		return($reviews);
	}


	/**
	 * get the Review by rating
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $reviewRating review rating to search for
	 * @return \SplFixedArray SplFixedArray of Reviews found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public function getReviewByReviewRating(\PDO $pdo, string $reviewRating) : \SplFixedArray {
		// sanitize the description before searching
		$reviewRating = trim($reviewRating);
		$reviewRating = filter_var($reviewRating, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($reviewRating) === true) {
			throw(new \PDOException("review rating is invalid"));
		}

		// escape any mySQL wild cards
		$reviewRating = str_replace("_". "\\_", str_replace("%", "\\%", $reviewRating));

		// create query template
		$query = "SELECT reviewId, reviewReviewerId, reviewConsole, reviewRating, reviewContent, reviewDate FROM review WHERE reviewConsole LIKE :reviewConsole";
		$statement = $pdo->prepare($query);

		// bind the review rating to the place holder in the template
		$reviewRating = "%$reviewRating%";
		$parameters = ["reviewRating" => $reviewRating];
		$statement->execute($parameters);

		// build an array of reviews
		$reviews = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$review = new Review($row["reviewId"], $row["reviewReviewerId"], $row["reviewConsole"], $row["reviewDate"], $row["reviewRating"], $row["reviewContent"]);
				$reviews[$reviews->key()] = $review;
				$reviews->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}

		}
		return($reviews);
	}


	/**
	 * gets all Reviews
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray of Reviews found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllReviews(\PDO $pdo) : \SplFixedArray {
				// create query template
				$query = "SELECT reviewId, reviewReviewerId, reviewConsole, reviewRating, reviewContent, reviewDate FROM review";
				$statement = $pdo->prepare($query);
				$statement->execute();


				// build an array of reviews
				$reviews = new \SplFixedArray($statement->rowCount());
				$statement->setFetchMode(\PDO::FETCH_ASSOC);
				while(($row = $statement->fetch()) !== false) {
						try {
									$review = new Review($row["reviewId"], $row["reviewReviewerId"], $row["reviewConsole"], $row["reviewDate"], $row["reviewRating"], $row["reviewContent"]);
									$reviews[$reviews->key()] = $review;
									$reviews->next();
						} catch(\Exception $exception) {
								//if the row couldn't be converted, rethrow it
								throw(new \PDOException($exception->getMessage(), 0, $exception));
						}
				}
				return ($reviews);
	}
}