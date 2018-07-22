<?php
/**
 * Small Cross Section of an IGN Game Review
 *this answer can be considered a small example of what services like IGN store when game reviews are added
 *to their website.  This can easily be extended to emulate more features of IGN's website.
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
	 */
	private $reviewerActivationToken;

	/**
	 * nick name for this Reviewer; this is a unique index
	 * @var string $reviewerNickName
	 */
	private $reviewerNickName;

	/**
	 * email for this Reviewer; this a unique index
	 * @var string $reviewerEmail
	 */
	private $reviewerEmail;

	/**
	 * hash for profile password
	 * @var $reviewerHash
	 */
	private $reviewerHash;

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
	 * @throws \InvalidArgumentException if $newReviewerNickName is not a string or insecure
	 * @throws \RangeException if $newReviewerNickName is > 32 characters
	 * @throws \TypeError if $newReviewerNickName is not a string
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

}