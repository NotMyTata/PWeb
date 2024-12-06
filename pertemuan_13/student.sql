CREATE TABLE student(
    sid int AUTO_INCREMENT primary key,
    fname varchar(100) not null,
    gender char(1) not null,
    dob date not null,
    smail varchar(100) not null,
    pnum varchar(13) not null
);

INSERT INTO student VALUES
(NULL, "Alexa Sabrina", "F", "2008-01-01", "alexa@fuzzy.edu", "000111222333"),
(NULL, "Birch Tree", "M", "2008-06-20", "birch@fuzzy.edu", "444555666777"),
(NULL, "Cache Memoi", "F", "2008-04-13", "cache@fuzzy.edu", "888999000111"),
(NULL, "Dirks Nowitzki", "M", "2009-02-26", "dirks@fuzzy.edu", "222333444555"),
(NULL, "Emily Stonewood", "F", "2008-09-13", "emily@fuzzy.edu", "666777888999");