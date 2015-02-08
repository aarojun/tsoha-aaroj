<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      if ($this->validators) {
        foreach($this->validators as $validator){
          // Kutsutaan validointimetodia ja lisätään sen palauttamat virheet taulukkoon
          $newerrors = array();
        
          $newerrors = $this->{$validator}();
          $errors = array_merge($errors, $newerrors);
      }
    }

      return $errors;
    }

  }
