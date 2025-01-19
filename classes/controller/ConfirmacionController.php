<?php

class ConfirmacionController {
    
    public function __construct() {}
    
    public function show($params=null) {
        $vHome = new ConfirmacionView();
        $vHome->show();
    }
}

