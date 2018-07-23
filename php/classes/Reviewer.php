<?php

namespace Rbecker8\DataDesign;
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;





/**
 * Small Cross Section of an IGN Reviewer
 * This is a cross section of what is probably stored about an IGN reviewer.  This entity is a top level entity that
 * holds the keys to the other entities in this example (Review)
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 **/

class Reviewer {
	/**
	 * id for Reviewer; this is the primary key
	 * @var Uuid $reviewerId
	 **/
	private $reviewerId;
	/**
	 * token handed out to verify that the profile is valid and not malicious
	 * @var reviewerActivationToken
	 **/
	private $reviewerActivationToken;
	/**
	 * nick name for this Reviewer; this is a unique index
	 * @var string $reviewerNickName
	 **/
	private $reviewerNickName;
	/**
	 * email for this Reviewer; this a unique index
	 * @var string $reviewerEmail
	 **/
	private $reviewerEmail;
	/**
	 * hash for profile password
	 * @var $reviewerHash
	 **/
	private $reviewerHash;


	/**
	 * Reviewer constructor
	 * @param string|Uuid $newReviewerId id of this reviewer
	 * @param string $newReviewerActivationToken activation token to safe guard against malicious accounts
	 * @param string $newReviewerNickName string containing newNickName
	 * @param string $newReviewerEmail string containing email
	 * @param string $newReviewerHash string containing password hash
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings to long, negative integers)
	 * @throws \TypeError is data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct($newReviewerId, ?string $newReviewerActivationToken, string $newReviewerNickName, string $newReviewerEmail, string $newReviewerHash) {
			try {
					$this->setReviewerId($newReviewerId);
					$this->setReviewerActivationToken($newReviewerActivationToken);
					$this->setReviewerNickName($newReviewerNickName);
					$this->setReviewerEmail($newReviewerEmail);
					$this->setReviewerHash($newReviewerHash);
			} catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
				// determine what exception was thrown
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}
	}

	/**
	 * accessor method for reviewer id
	 *
	 * @return Uuid value for reviewer id
	 */
	public function getReviewerId(): Uuid {
		return ($this->reviewerId);
	}

	/**
	 * mutator method for reviewer id
	 *
	 * @param Uuid/string $newReviewerId new value of review id
	 * @throws \RangeException if $newReviewerId is n
	 * @throws \TypeError if $newReviewerId is not a uuid.e
	 */
	public function setReviewerId($newReviewerId): void {
		try {
			$uuid = self::validateUuid($newReviewerId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));

		}

		// convert and store reviewer id
		$this->reviewerId = $uuid;
 	}

	/**
	 * accessor method for reviewer activation token
	 *
	 * @return string value of the activation token
	 */
	public function getReviewerActivationToken() : string {
		return ($this->reviewerActivationToken);
	}

	/**
	 * mutator method for reviewer activation token
	 *
	 * @param string $newReviewerActivationToken
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 **/

	public function setReviewerActivationToken(?string $newReviewerActivationToken): void {
		if($newReviewerActivationToken === null) {
			$this->reviewerActivationToken = null;
			return;
		}

		$newReviewerActivationToken = strtolower(trim($newReviewerActivationToken));
		if(ctype_xdigit($newReviewerActivationToken) === false) {
			throw(new\RangeException("reviewer activation token has to be 32"));

		}
		$this->reviewerActivationToken = $newReviewerActivationToken;
	}

	/**
	 * accessor method for nick name
	 *
	 * @return string value of nick name
	 **/
	public function getReviewerNickName(): string {
		return ($this->reviewerNickName);
	}

	/**
	 * mutator method for nick name
	 *
	 * @param string $newReviewerNickName new value of nick name
	 * @throws \InvalidArgumentException if $newNickName is not a string or insecure
	 * @throws \RangeException if $newNickName is > 32 characters
	 * @throws \TypeError if $newNickName is not a string
	 **/
	public function setReviewerNickName(string $newReviewerNickName): void {
		// verify the nick name is secure
		$newReviewerNickName = trim($newReviewerNickName);
		$newReviewerNickName = filter_var($newReviewerNickName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newReviewerNickName) === true) {
			throw(new\InvalidArgumentException("reviewer nick name is empty or insecure"));

		}
		// verify the nick name will fit in the database
		if(strlen($newReviewerNickName) > 32) {
			throw(new \RangeException("reviewer nick name is too large" ));

		}
		$this->reviewerNickName = $newReviewerNickName;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 **/
	public function getReviewerEmail(): string {
		return $this->reviewerEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newReviewerEmail new value of email
	 * @throws \InvalidArgumentException if $newReviewerEmail is not a valid email or insecure
	 * @throws \RangeException if $newReviewerEmail is > 128 characters
	 * @throws \TypeError if $newReviewerEmail is not a string
	 **/
	public function setReviewerEmail(string $newReviewerEmail): void {
		$newReviewerEmail = trim($newReviewerEmail);
		$newReviewerEmail = filter_var($newReviewerEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newReviewerEmail) === true) {
			throw(new\InvalidArgumentException("reviewer email is empty or insecure"));

		}
		// verify the email will fit in the database
		if(strlen($newReviewerEmail) > 128) {
			throw(new\RangeException("reviewer email is too large"));

		}
		// store the email
		$this->reviewerEmail = $newReviewerEmail;
	}

	/**
	 * accessor method for reviewerHash
	 *
	 * @return string value of hash
	 **/
	/**
	 * @return mixed
	 */
	public function getReviewerHash() {
		return $this->reviewerHash;
	}

	/**
	 * mutator method for reviewer hash password
	 *
	 * @param string $newReviewerHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if reviewer hash is not a string
	 */
	public function setReviewerHash(string $newReviewerHash): void {
		// enforce that the hash is properly formatted
		$newReviewerHash = trim($newReviewerHash);
		if(empty($newReviewerHash) === true) {
			throw (new \InvalidArgumentException("reviewer password hash empty or insecure"));

		}

		//enforce the hash is really an Argon Hash
		$reviewerHashInfo = password_get_info($newReviewerHash);
		if($reviewerHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("reviewer hash is not a valid hash"));

		}

		// enforce the hash is exactly 97 characters.
		if(strlen($newReviewerHash) !== 97) {
			throw(new \RangeException("reviewer hash must be 97 characters"));

		}

		// store the hash
		$this->reviewerHash = $newReviewerHash;
	}



	/**
	 * inserts this Reviewer into mySQL
	 *
	 * @param \PDO $pdo connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {



				// create query template
				$query = "INSERT INTO reviewer(reviewerId, reviewerActivationToken, reviewerNickName, reviewerEmail, reviewerHash) VALUES (:reviewerId, :reviewerActivationToken, :reviewerNickName, :reviewerEmail, :reviewerHash)";
				$statement = $pdo->prepare($query);

				$parameters = ["reviewerId" => $this->reviewerId->getBytes(), "reviewerActivationToken" => $this->reviewerActivationToken, "reviewerNickName" => $this->reviewerNickName, "reviewerEmail" => $this->reviewerEmail, "reviewerHash" => $this->reviewerHash];
				$statement->execute($parameters);


	}

	/**
	 * deletes this Reviewer from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {

			// create query template
			$query = "DELETE FROM reviewer WHERE reviewerId = :reviewerId";
			$statement = $pdo->prepare($query);

			// bind the reviewer variables to the place holders in the template
			$parameters = ["reviewerId" => $this->reviewerId->getBytes()];
			$statement->execute($parameters);
	}

	/**
	 * updates this Reviewer from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 **/
	public function update(\PDO $pdo): void {


				// create query template
				$query = "UPDATE reviewer SET reviewerActivationToken, reviewerNickName = :reviewerNickName, reviewerEmail = :reviewerEmail, reviewerHash = :reviewerHash";
				$statement = $pdo->prepare($query);

				// bind the reviewer variables to the place holders in the template

				$parameters = ["reviewerId" => $this->reviewerId->getBytes(), "reviewerActivationToken" => $this->reviewerActivationToken, "reviewerNickName" => $this->reviewerNickName, "reviewerEmail" => $this->reviewerEmail, "reviewerHash" => $this->reviewerHash];
				$statement->execute($parameters);
	}

	/**
	 * gets the Reviewer by reviewer id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $reviewerId reviewer Id to search for
	 * @return Review|null Reviewer or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 **/
	public static function getReviewerByReviewerId(\PDO $pdo, string $reviewerId):?Reviewer {
				// sanitize the reviewer id before searching
				try {
							$reviewerId = self::validateUuid($reviewerId);
				} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}



				// create query template
				$query = "SELECT reviewerId, reviewerActivationToken, reviewerNickName, reviewerEmail, reviewerHash";
				$statement = $pdo->prepare($query);

				// bind the reviewer id to the place holder in the template
				$parameters = ["reviewerId" => $reviewerId->getBytes()];
				$statement->execute($parameters);

				// grab the Reviewer from mySQL
				try {
							$reviewer = null;
							$statement->setFetchMode(\PDO::FETCH_ASSOC);
							$row = $statement->fetch();
							if($row !== false) {

										$reviewer = new Reviewer($row["reviewerId"], $row["reviewerActivationToken"], $row["reviewerNickName"], $row["reviewerEmail"], $row["reviewerHash"]);
							}
				} catch(\Exception $exception) {
							// if the row couldn't be converted, rethrow it
							throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
				return ($reviewer);
	}


	/**
	 * gets the Reviewer by email
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $reviewerEmail email to search for
	 * @return Reviewer|null Reviewer or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getReviewerByReviewerEmail(\PDO $pdo, string $reviewerEmail): ?Reviewer {
				// sanitize the email before searching
		$reviewerEmail = trim($reviewerEmail);
		$reviewerEmail = filter_var($reviewerEmail, FILTER_VALIDATE_EMAIL);

		if(empty($reviewerEmail) === true) {
					throw(new \PDOException("not a valid email"));
		}

		// create query template
		$query = "SELECT reviewerId, reviewerActivationToken, reviewerNickName, reviewerEmail, reviewerHash";
		$statement = $pdo->prepare($query);

		// bind the reviewer id to the place holder in the template
		$parameters = ["reviewerEmail" => $reviewerEmail];
		$statement->execute($parameters);

		// grab the Reviewer from mySQL
		try {
					$reviewer = null;
					$statement->setFetchMode(\PDO::FETCH_ASSOC);
					$row = $statement->fetch();
					if($row !== false) {
								$reviewer = new Reviewer($row["reviewerId"], $row["reviewerActivationToken"], $row["reviewerNickName"], $row["reviewerEmail"], $row["reviewerHash"]);
					}
		} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($reviewer);
	}




	/**
	 * gets the Reviewer by nick name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $reviewerNickName nick name to search for
	 * @return \SplFixedArray of all profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getReviewerByReviewerNickName(\PDO $pdo, string $reviewerNickName) : \SplFixedArray {
			// sanitize the nick name before searching
			$reviewerNickName = trim($reviewerNickName);
			$reviewerNickName = filter_var($reviewerNickName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			if(empty($reviewerNickName) === true) {
						throw(new\PDOException("not a valid nick name"));
			}

			// create a query template
			$query = "SELECT reviewerId, reviewerActivationToken, reviewerNickName, reviewerEmail, reviewerHash";
			$statement = $pdo->prepare($query);

			// bind the reviewer nick name to the place holder in the template
			$parameters = ["reviewerNickName" => $reviewerNickName];
			$statement->execute($parameters);


			$reviewers = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);

			while (($row = $statement->fetch()) !== false) {
					try {
								$reviewer = new Reviewer($row["reviewerId"], $row["reviewerActivationToken"], $row["reviewerNickName"], $row["reviewerEmail"], $row["reviewerHash"]);
								$reviewers[$reviewers->key()] = $reviewer;
								$reviewers->next();
					} catch(\Exception $exception) {
							// if the row couldn't be converted, rethrow it
							throw(new \PDOException($exception->getMessage(), 0, $exception));
					}
			}
			return ($reviewers);

	}



	/**
	 * get the reviewer by reviewer activation token
	 *
	 * @param string $reviewerActivationToken
	 * @param \PDO $pdo PDO connection object
	 * @return Reviewer|null reviewer or no null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getReviewerByReviewerActivationToken(\PDO $pdo, string $reviewerActivationToken) : ?Reviewer {
		// make sure activation token is the right format and that it a string representation of a hexadecimal
		$reviewerActivationToken = trim($reviewerActivationToken);
		if(ctype_xdigit($reviewerActivationToken) === false) {
			throw(new\InvalidArgumentException("reviewer activation token is empty or in the wrong format"));
		}

		// create the query template
		$query = "SELECT reviewerId, reviewerActivationToken, reviewerNickName, reviewerEmail, reviewerHash";
		$statement = $pdo->prepare($query);

		// bind the profile activation token to the place holder in the template
		$parameters = ["reviewerActivationToken" => $reviewerActivationToken];
		$statement->execute($parameters);

		//grab the Reviewer from mySQL
		try {

			$reviewer = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$reviewer = new Reviewer($row["reviewerId"], $row["reviewerActivationToken"], $row["reviewerNickName"], $row["reviewerEmail"], $row["reviewerHash"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new\PDOException($exception->getMessage(), 0, $exception));
		}
		return ($reviewer);
	}
}