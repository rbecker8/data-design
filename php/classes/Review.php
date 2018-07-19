<?php


/**
 * Small Cross Section of an IGN Game Review
 *this answer can be considered a small example of what services like IGN store when game reviews are added
 *to their website.  This can easily be extended to emulate more features of IGN's website.
 *
 * @author Ryan Becker <rbecker8@cnm.edu>
 * @version 1.0
 **/

class Review {
	/**
	 * id for this Review; this is the primary key
	 * @var Uuid $reviewId
	 **/
	private $reviewId;
	/**
	 * id of the Reviewer that wrote this Review; this is a foreign key
	 *@var Uuid  $reviewReviewerId
	 **/
	private $reviewReviewerId;
	/**
	 * id of console review written for
	 * @var string $reviewConsole
	 **/
	private $reviewConsole;
	/**
	 * date of review release
	 * @var DateTime $reviewReleaseDate*
	 **/
	private $reviewReleaseDate;
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
	 * accessor method for review id
	 *
	 * @return Uuid value for review id
	 **/
	public function getReviewId() : Uuid {
		return($this->reviewId);
	}


	/**
	 * mutator method for review id
	 *
	 * @param Uuid/string $newReviewId new value of review id
	 * @throws \RangeException if $newReviewId is n
	 * @throws \TypeError if $newTweetId is not a uuid.e
	 **/
	public function setReviewId( $newReviewId) : void {
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
	public function getReviewReviwerId() : Uuid{
		return($this->reviewReviewerId);
	}

	/**
	 * mutator method for review reviewer id
	 *
	 * @param string | Uuid $newReviewReviewerId new value of review reviewer id
	 * @throws \RangeException if $newReviewerId is not positive
	 * @throws \TypeError if $newReviewReviewerId is not a UUI
	 */
	public function setReviewReviewerId( $newReviewReviewerId) : void {
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
	 * accessor method for review
	 *
	 */




	}