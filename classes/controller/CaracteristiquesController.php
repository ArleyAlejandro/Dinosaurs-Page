<?php

class CaracteristiquesController {
    
    public function __construct() {}
    
    public function show($params=null) {
        $vHome = new CaracteristiquesView();
        $vHome->show();
        
    }
}

