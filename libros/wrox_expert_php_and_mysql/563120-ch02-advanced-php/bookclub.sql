CREATE TABLE books ( id INT AUTO_INCREMENT PRIMARY KEY,
                     ISBN VARCHAR(20) UNIQUE,
                     title VARCHAR(50), publisher INT );
CREATE TABLE book_authors ( bookid INT, authorid INT, PRIMARY KEY (bookid,authorid) );
CREATE TABLE authors ( id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20) );
CREATE TABLE publishers ( id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(20) );

 SELECT `ISBN` , `title` , (
  SELECT GROUP_CONCAT( `name` )
    FROM `book_authors` AS t2
    JOIN `authors` AS t3 ON t2.authorid = t3.id
    WHERE t2.bookid = t1.id
    GROUP BY `bookid`
  ) AS `author` , `t4`.`name` AS publisher
  FROM `books` AS t1
  JOIN `publishers` AS t4 ON t1.publisher = t4.id;
