<?php 
class ClassOne {
   protected $a = 10;
   public function changeValue($b){
    $this->a = $b;

   }
}

class ClassTwo extends ClassOne {
    public function changeValue($b){
         $this->a = $b;
         


    }
}
?>