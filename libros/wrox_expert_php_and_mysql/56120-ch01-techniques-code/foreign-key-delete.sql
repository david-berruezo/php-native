DELETE FROM colors WHERE color='Yellow';
SELECT * FROM flags WHERE color='Yellow';

SELECT * FROM flags WHERE country IN (SELECT country from flags WHERE color='Yellow');

SELECT * FROM flags WHERE country = 'Sweden';                                         

