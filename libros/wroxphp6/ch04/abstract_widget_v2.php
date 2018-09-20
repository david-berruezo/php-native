<?abstract class Widget implements Observer {

  private $subject;

  abstract public function draw();

  public function update(Observable $subject) {
         $this->subject = $subject;
  }

  public function getSubject() {
         return $this->subject;
  }
}
?>