<?php
        require("pdofactory.phpm");
        require("databoundobject.phpm");
        require("userv3.phpm");

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

        $id = $objUser->getID();
        print "ID in database is " . $id . "<br />";

        print "Destroying object...<br />";
        unset($objUser);

        print "Recreating object from ID $id<br />";
        $objUser = new User($objPDO, $id);

        print "First name is " . $objUser->getFirstName() . "<br />";
        print "Last name is " . $objUser->getLastName() . "<br />";

        print "Committing a change.... Steve will become Steven, 
               Nowicki will become Nowickcow<br/>";
        $objUser->setFirstName("Steven");
        $objUser->setLastName("Nowickcow");
        print "Saving...<br />";
        $objUser->Save();
?>