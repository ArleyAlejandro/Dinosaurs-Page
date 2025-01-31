<?php

class MantenimientoController {
    
    public function __construct() {}
    
    public function show($params=null) {
        $vMantenimiento = new MantenimientoView();
        $vMantenimiento->show();
        
    }
}

