<?php

class ConclusionController {
    
    public function __construct() {}
    
    public function show($params=null) {
        $vHome = new ConclusionView();
        $vHome->show();
        
    }
}

