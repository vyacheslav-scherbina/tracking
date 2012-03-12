<?php
class Controller_Unit extends Controller_MyTemplate
{

	public function action_index()
	{
        $units      = array();
        $managers   = array();
        $employees  = array();
        $superuser  = false;
        
		if (Auth::get_user('group') == 0) // if superuser
        {
            $superuser = true;
            $units     = Model_Unit::find('all');
        }
		elseif (Auth::get_user('group') == 1 and Auth::get_user('unit_id') != 0)
        {
            $units[Auth::get_user('unit_id')] = Model_Unit::find(Auth::get_user('unit_id'));
        }
        
        $homeless_employees = Model_Person::find()->where('unit_id', '0')->where('group', '1')->get();
        
        foreach ($units as $key => $unit)
        {
            $tmp             = Model_Unit::get_managers_and_employees($unit); 
            $managers[$key]  = $tmp['managers'];
            $employees[$key] = $tmp['employees'];
        }
        
        $data = array(
            'superuser'          => $superuser,
            'units'              => $units,
            'managers'           => $managers,
            'employees'          => $employees,
            'homeless_employees' => $homeless_employees,
        );
        
        $this->template->search  = false;
		$this->template->title   = "Units";
		$this->template->content = View::forge('unit/index', $data);
	}

    public function action_create()
	{
		if (Input::method() == 'POST')
		{
            if (Model_Unit::validate()) 
            {
                Model_Image::set_config();
                
                if ( ! Upload::is_valid())
                {
                    $image_id = 2; // 1 - person, 2 - unit, 3 - company
                }
                else
                {
                    $file     = Upload::get_files();
                    $content  = File::read($file[0]['file'], true);
                    $image    = Model_Image::forge(array('content' => $content));
                    $image->save();
                    $image_id = $image->id;
                }
                $unit = Model_Unit::forge(array('name' => Input::post('name'), 'image_id' => $image_id));
                $unit->save();
            }
            
		}
        
        Response::redirect('unit');
	}

    public function action_edit($id = null)
	{
		if ( ! is_null($id) and Model_Unit::validate()) 
        {
            $unit       = Model_Unit::find($id);
            $unit->name = Input::post('name');
            
            Model_Image::set_config();

            if (Upload::is_valid())
            {
                $file           = Upload::get_files();
                $content        = File::read($file[0]['file'], true);
                $image          = Model_Image::forge(array('content' => $content));
                $image->save();
                $unit->image_id = $image->id;
            }
            $unit->save();
        }
        Response::redirect('unit');
	}
    
    
	public function action_delete($id = null)
	{
		if ($id and $unit = Model_Unit::find($id))
		{
			$unit->delete();
		}
        $employees = Model_Person::find()->where('unit_id', $id)->get();
        
        foreach ($employees as $employee)
        {
            $employee->unit_id = 0;
            $employee->save();
        }
		Response::redirect('unit');
	}
}
