<?php

class Product extends Service {

  public static function all(){
    return [
      ['name' => 'Phone', 'price' => 70],
      ['name' => 'TV', 'price' => 1700],
      ['name' => 'Hammer', 'price' => 17],
    ];
  }
}