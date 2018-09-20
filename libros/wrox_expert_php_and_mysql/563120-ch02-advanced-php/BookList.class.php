<?php
class BookList implements  Iterator, Countable, SeekableIterator, ArrayAccess  {
  private $pages = array();
  private $currentPage = 1;
  private $database = null;
  public  $booksPerPage = 10;
  private $totalBooks = 0;
  private $deletions = array();

  public function __construct( $database ) {
    $this->database = $database;
    if ( $result = $database->query("SELECT count(*) FROM books") )
      if ( $row = $result->fetch_row() )
        $this->totalBooks = $row[0];
  }

  public function rewind() {
    $this->currentPage = 1;
    if ( array_key_exists(1,$this->pages) )
      reset( $this->pages[$i] );
  }


  private function &touchPage( $pageNo=false ) {
    if ( $pageNo === false ) $pageNo = $this->currentPage;

    if ( !array_key_exists($pageNo,$this->pages) ) {
      if ( $pageNo > ceil($this->count()/$this->booksPerPage) ) {
        $this->pages[$pageNo] = array();
        
      } else {
        $start = ($pageNo-1)*$this->booksPerPage +
                 $this->getAdjustmentForPage($pageNo);
        $query = <<<__QUERY
      SELECT `ISBN` , `title` , (
        SELECT GROUP_CONCAT( `name` )
        FROM `book_authors` AS t2
        JOIN `authors` AS t3 ON t2.authorid = t3.id
        WHERE t2.bookid = t1.id
        GROUP BY `bookid`
      ) AS `author` , `t4`.`name` AS publisher
      FROM `books` AS t1
      JOIN `publishers` AS t4 ON t1.publisher = t4.id
      LIMIT $start, {$this->booksPerPage}
__QUERY;

        $result = $this->database->query($query);
        $this->pages[$pageNo] = $result->fetch_all(MYSQLI_ASSOC);
      } 
    }
    $tmp = &$this->pages[$pageNo];
    return $tmp;
  }

  public function valid() {
    $page = &$this->touchPage();
    return ( key($page) !== null );
  }

  public function current() {
    return current( $this->touchPage() );
  }


  public function key() {
    return key( $this->touchPage() )+$this->booksPerPage*($this->currentPage-1);
  }
  
  public function next() {
    $page = &$this->touchPage();
    next($page);
    if ( key($page) === null && count($page) == $this->booksPerPage ) { 
      $this->currentPage++;
      $page = &$this->touchPage();
      reset($page);
    }
    return current($page);
  }
  
  /* Countable Interface */
  public function count() {
    return $this->totalBooks;
  }
  
  /* Seekable Interface */
  public function seek( $index ) {
    if ( $index < 0 || $index > $this->totalBooks )
      throw new OutOfBoundsException();

    $this->currentPage = (int)floor($index/$this->booksPerPage)+1;
    $page = &$this->touchPage();
    reset($page);
    for ( $i= $index % $this->booksPerPage; $i>0; $i-- ) next($page);
  }

  /* ArrayAccess Interface */
  public function offsetExists( $offset ) {
    return ( $offset > 0 && $offset < count($this) );
  }

  public function offsetGet( $offset ) {
    $pageOfOffset = (int)floor($offset/$this->booksPerPage)+1;
    $page = &$this->touchPage( $pageOfOffset );
    return $page[ $offset % $this->booksPerPage ];
  }

  public function offsetSet( $offset, $newValue ) {
    $pageOfOffset = (int)floor($offset/$this->booksPerPage)+1;
    $page = &$this->touchPage( $pageOfOffset );
    $page[ $offset % $this->booksPerPage ] = $newValue;
  }

  public function offsetUnset( $offset ) {
    $pageOfOffset = (int)floor($offset/$this->booksPerPage)+1;
    $page = &$this->touchPage( $pageOfOffset );

    $this->deletions[$pageOfOffset]++;
    ksort($this->deletions);
    unset( $page[ $offset % $this->booksPerPage ] );
    $page = array_values($page);
    while ( is_array($this->pages[$pageOfOffset+1]) ) {
      $this->pages[$pageOfOffset][] = array_shift($this->pages[++$pageOfOffset]);
    }
  
    $record = ($pageOfOffset-1)*$this->booksPerPage + count($this->pages[$pageOfOffset]) +
              $this->getAdjustmentForPage($pageOfOffset);
    if ( $result = $this->database->query("SELECT * FROM books LIMIT $record,1") )
      $this->pages[$pageOfOffset][] = $result->fetch_object();

    $this->totalBooks--;
  }

  private function getAdjustmentForPage( $pageNo ) {
    $adjust = 0;
    for ( reset($this->deletions); key($this->deletions) !== null && key($this->deletions) <= $pageNo; next($this->deletions) )
      $adjust += current($this->deletions);
    return $adjust;
  }

}
?>
