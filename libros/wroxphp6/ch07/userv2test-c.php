<?php

        require("userv2.phpm");
        require("pdofactory.phpm");

        print "Running...<br />";

        $strDSN = "pgsql:dbname=chapterseven;host=localhost;port=5432";
        $objPDO = PDOFactory::GetPDO($strDSN, "chapterseven", "chapterseven",
                  array());
        $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $objUser = new User($objPDO);

        $objUser->setFirstName("Steve");
        $objUser->setLastName("Nowicki");
        $objUser->setDateAccountCreated(date("Y-m-d"));

        print "First name is " . $objUser->getFirstName() . "<br />";
        print "Last name is " . $objUser->getLastName() . "<br />";

        print "Saving...<br />";

        $objUser->Save();

        print "ID in database is " . $objUser->getID() . "<br />";



?>