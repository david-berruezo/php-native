<?php
  // Incluimos funciones
  require_once('BandInterface.php');
  require_once('InstrumentInterface.php');
  require_once('class.Guitarrist.php');
  require_once('class.Guitar.php');
  require_once('class.LeadGuitarrist.php');
  require_once('class.Musician.php');
  require_once('class.RockBand.php');


  // Test Objects
  $band        = new RockBand("The Variables");
  $bandMemberA = new Guitarist("Jack", "Float");
  $bandMemberB = new LeadGuitarist("Jim", "Integer");

  $bandMemberA->addInstrument(new Guitar("Gibson Les Paul"));
  $bandMemberB->addInstrument(new Guitar("Fender Stratocaster"));
  $bandMemberB->addInstrument(new Guitar("Hondo H-77"));

  $band->addMusician($bandMemberA);
  $band->addMusician($bandMemberB);

  foreach($band->getMusicians() as $musician) {
    echo "Musician ".$musician->getName() . "<br>";
    echo "is the " . $musician->getMusicianType() . "<br>";
    echo "in the " . $musician->getBand()->getGenre() . " band <br>";
    echo "called " . $musician->getBand()->getName() . "<br>";

    foreach($musician->getInstruments() as $instrument) {
       echo "And plays the " . $instrument->getName() . " ";
       echo $instrument->getCategory() . "<br>";
    }
    echo "<p>";
  }
?>