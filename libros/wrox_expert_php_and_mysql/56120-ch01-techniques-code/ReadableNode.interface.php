<?php

interface ReadableNode {
  public function isRead();
  public function markAsRead();
  public function markAsUnread();
};

?>