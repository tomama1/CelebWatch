# Write an SQL statement to create 'Users' table.

CREATE TABLE Users (
	ID INT NOT NULL auto_increment,
  	UserName VARCHAR(50) NOT NULL,
  	Password VARCHAR(20) NOT NULL,
  	Email VARCHAR(50) NOT NULL,
  	PRIMARY KEY(ID)
);

-- Write an SQL statement to create 'Celebrities' table.
CREATE TABLE Celebrities (
	ID INT NOT NULL auto_increment,
	CelebName VARCHAR(100) NOT NULL,
	Occupation ENUM('Music', 'Film/TV', 'Sports', 'Comedy', 'Modeling', 'Other'),
	Birthday DATE NOT NULL,
	Wikipedia VARCHAR(500) NOT NULL,
	WikiID VARCHAR(100) NOT NULL,
	Twitter VARCHAR(500) NOT NULL,
	TwitterID VARCHAR(100) NOT NULL,
	Instagram VARCHAR(500) NOT NULL,
	PRIMARY KEY(ID)
);

-- Write an SQL state to create 'Requests' table.
CREATE TABLE Requests (
	Celeb VARCHAR(100) NOT NULL,
	UserID INT NOT NULL,
	RequestTime DATETIME NOT NULL,
	Descrp VARCHAR(500) NOT NULL,
	FOREIGN KEY (UserID) REFERENCES Users(ID)
) engine=InnoDB;
-- didn't requre engine=InnoDB on phpmyadmin

-- Write an SQL statement to create 'MyCelebs' table.
CREATE TABLE MyCelebs (
	CelebID INT NOT NULL,
	UserID INT NOT NULL,
	FOREIGN KEY (CelebID) REFERENCES Celebrities(ID),
	FOREIGN KEY (UserID) REFERENCES Users(ID)
) engine=InnoDB;


