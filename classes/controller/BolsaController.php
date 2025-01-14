<?php

class BolsaController{
    
    public function __construct() {}
    
    public function show($params=null) {
        $vHome = new BolsaView();
        $vHome->show();
    }
}