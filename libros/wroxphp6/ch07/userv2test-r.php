<?php

        require("userv2.phpm");
        require("pdofactory.phpm");

        print "Running...<br />";

        $strDSN = "pgsql:dbname=chapterseven;host=localhost;port=5432";
        $objPDO = PDOFactory::GetPDO($strDSN, "chapterseven", "chapterseven",
                  array());
        $objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $objUser = new User($objPDO, 1);
        print "First name is " . $objUser->getFirstName() . "<br />";



?>