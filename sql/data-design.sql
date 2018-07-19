ALTER DATABASE rbecker8 CHARACTER SET utf8 COLLATE utf8_unicode_ci
;

DROP TABLE IF EXISTS reviewer;
DROP TABLE IF EXISTS review;

CREATE TABLE reviewer (
		reviewerId BINARY (16) NOT NUll,
		reviewerActivationToken CHAR (32),
		reviewerNickName VARCHAR (32) NOT NULL,
		reviewerEmail VARCHAR (128) NOT NUll,
		reviewerHash CHAR (97) NOT NUll,
	-- unique index to avoid duplicate data
		UNIQUE (reviewerNickName),
		UNIQUE (reviewerEmail),
	-- officiates primary key for reviewer
		PRIMARY KEY(reviewerId)
);

CREATE TABLE review (
		reviewId BINARY (16) NOT NULL,
		reviewReviewerId BINARY (16) NOT NULL,
		reviewConsole VARCHAR (16) NOT NULL,
		reviewReleaseDate DATE,
		reviewRating CHAR (2) NOT NULL,
		reviewContent VARCHAR (40000) NOT NULL,
		-- this creates an index before making up foreign key
		INDEX(reviewReviewerId),
		-- this creates foreign key relation
		FOREIGN KEY(reviewReviewerId) REFERENCES reviewer(reviewerId),
		-- create primary key
		PRIMARY KEY(reviewId)
);