<?php

class Controller_Auth extends Controller
{
    
    public function action_index()
    {
        if (Auth::check())
        {
            Response::redirect('unit'); // или на стартовую
        }
        
        return View::forge('login/index');
    }
    
    public function action_login()
    {
        if (Input::method() == 'POST')
		{
            if (Auth::instance()->login(Input::post('username'), Input::post('password')))
            {
                Response::redirect('auth');
            }
            else
            {
                Session::set_flash('username', Input::post('username'));
                Session::set_flash('error', 'The Username or Password you entered is incorrect');
            }
		}
        
        Response::redirect('auth');
    }
    
    public function action_logout()
    {
        Auth::instance()->logout();
        Response::redirect('auth');
    }
}