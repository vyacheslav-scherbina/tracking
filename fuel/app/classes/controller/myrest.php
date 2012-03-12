<?php
abstract class Controller_MyRest extends Controller_Rest
{
    public function before()
	{
		parent::before();
        
        if ( ! Auth::check()) die; // временное решение
        
        /*$tmp = (explode('.', $this->request->action));
        echo $this->request->controller;   //  Здесь лежит имя контроллера 
        echo $action = strtolower(Input::method().'_'.$tmp[0]);*/  //Здесь лежит имя метода 
		
	}   
}
