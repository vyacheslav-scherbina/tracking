<?php
abstract class Controller_MyTemplate extends Controller_Template
{
    public $template = 'main';
    
    public function before($data = null)
    {
        parent::before();

        if ( ! Auth::check())
        {
            Response::redirect('auth');
        }
        
        if ( ! Auth::has_access($this->request->uri->segments[0].'.'.$this->request->action))
        {
			die('forbidden');
		}
        $this->template->superuser=$this->_get_superuser();

    }
    
    protected function _get_superuser()
    {
        return (Auth::get_user('group') == 0);
    }
}
