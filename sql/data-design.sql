ALTER DATABASE data_design CHARACTER SET utf8 COLLATE utf8_unicode_ci
;

DROP TABLE IF EXISTS reviewer;
DROP TABLE IF EXISTS review;

CREATE TABLE reviewer (
		reviewerId BINARY (16) NOT NUll,
		reviewerActivationToken CHAR (32),
		reviewerNickName VARCHAR (32) NOT NULL,
		reviewerEmail VARCHAR (128) NOT NUll,
		reviewerHash CHAR (97) NOT NUll,
		reviewDateId DATE,
		UNIQUE (reviewerNickName),
		UNIQUE (reviewerEmail),
		PRIMARY KEY(reviewerId)
);

CREATE TABLE review (
		reviewId BINARY (16) NOT NULL,
		reviewReviewerId BINARY (16) NOT NULL,
		reviewConsoleId VARCHAR (16) NOT NULL,
		reviewReleaseId DATE,
		reviewRatingId VARCHAR (14) NOT NULL,
		reviewContent VARCHAR (140) NOT NULL,
		-- this creates an index before making up foreign key
		INDEX(reviewReviewerId),
		-- this creates foreign key relation
		FOREIGN KEY(reviewReviewerId) REFERENCES review(reviewReviewerId),
		-- create primary key
		PRIMARY KEY(reviewId)
);