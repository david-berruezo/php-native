<?php

  require_once('class.SweepstakesCustomer.php');
  //since this file already includes class.Customer.php, there's
  //no need to pull that file in, as well.

  function greetCustomer(Customer $objCust) {
    print "Welcome back to the store $objCust->name!<br>";
  }

  //Change this value to change the class used to create this customer object
  $promotionCurrentlyRunning = false;
  if ($promotionCurrentlyRunning) {
    $objCust = new SweepstakesCustomer(10);
  } else {
    $objCust = new Customer(10);
  }

  greetCustomer($objCust);

?>