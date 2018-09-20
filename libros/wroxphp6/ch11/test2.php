<?php
require("collection.phpm");
require("communication.phpm");
require("emailcommunication.phpm");
require("recipient.phpm");
require("emailrecipient.phpm");
require("emailrecipientcollection.phpm");
$objEmail = new EmailCommunication;
$objEmailRecipient = new EmailRecipient("ed@example.com", 
     "Ed Lecky-Thompson");
$objEmailCCRecipient = new EmailRecipient("ted@example.com", 
     "Ted Lecky-Thompson");
$objEmailBCCRecipient = new EmailRecipient("zed@example.com",
                           "Zed Lecky-Thompson");
$objEmail->setPrimaryRecipient($objEmailRecipient);
$objEmail->addCarbonRecipient($objEmailCCRecipient);
$objEmail->addBlindRecipient($objEmailBCCRecipient);
$objEmail->send(); ?>