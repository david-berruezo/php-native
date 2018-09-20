<?php
class ForumTopic extends Node implements ReadableNode {
  private $debugMessages;
  private $read;

  public function __construct() {
    parent::__construct();
    $this->debug(__CLASS__."constructor called.");
    $this->read = false;
  }

  public function __destruct() {
    $this->debug(__CLASS__."destructor called.");
    parent::__destruct();
  }

  public function getView() {
    return "This is a view into ".__CLASS__;
  }

  public function isRead() { return $this->read; }
  public function markAsRead() { $this->read = true; }
  public function markAsUnread() { $this->read = false; }
}
?>
