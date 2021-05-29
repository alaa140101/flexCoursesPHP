<?php

class Service {

  public $available = false;
  public $taxRate = 0;

  public function __construct(){

  }

  public function available(){
    $this->available = true;
  }

  public static function all(){
    return [
      ['name' => 'Consultation', 'price' => 500, 'days' => ['Sun', 'Mon']],
      ['name' => 'Training', 'price' => 200, 'days' => ['Tues', 'Wed']],
      ['name' => 'Design', 'price' => 100, 'days' => ['Thu', 'Fri']],
      ['name' => 'Coding', 'price' => 1000, 'days' => ['Sat', 'Sun']]
    ];
  }

  public function getTotal($price){
    $total = $price;
    if ($this->taxRate > 0) {
      $total += ($total * $this->taxRate);
    } 
    return $total;
  }
}