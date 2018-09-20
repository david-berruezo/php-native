<?php
require("recipient.phpm");
require("emailrecipient.phpm");

$objEmailRecipient = new EmailRecipient("fiona@example.com", "Fiona Chow");
if ($objEmailRecipient->isValid()) {
  print "Recipient is valid! ";
  print "The string representation of this recipient would be: " .
         htmlentities($objEmailRecipient->getStringRepresentation());
} else {
  print "Recipient is not valid!";
};
?>