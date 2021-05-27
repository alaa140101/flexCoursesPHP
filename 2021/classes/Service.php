<?php

class Service {

  public $available = false;

  public function __construct(){

  }

  public function available(){
    $this->available = true;
  }

  public function all(){
    return [
      ['name' => 'Consultation', 'price' => 500, 'days' => ['Sun', 'Mon']],
      ['name' => 'Training', 'price' => 200, 'days' => ['Tues', 'Wed']],
      ['name' => 'Design', 'price' => 100, 'days' => ['Thu', 'Fri']]
    ];
  }
}