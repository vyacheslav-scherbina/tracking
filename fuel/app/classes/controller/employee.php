<?php
class Controller_Employee extends Controller_MyTemplate
{
    
    public function action_index()
		{
        $table=Model_Person::find('all',array('where'=>array('group'=>1)));
        $unit=Model_Unit::find('all');
		$data = array('table' => $table,'unit'=>$unit);
        $this->template->title = 'Employee';
        $this->template->search = View::forge('search');
        $this->template->content = View::forge('employee/index', $data);
		}
    
    public function action_add()
		{
        $this->template = null;
        $table = Input::post();
        $table['username'] = $table['email'];
        unset($table['email']);
		if(isset($table['is_unit_manager']))
			{
			$table['is_unit_manager']=1;
			}
        //$table['unit_id'] = $table['company_id'];
        //unset($table['company_id']);
        $table['group'] = 1;
        $new = Model_Person::forge($table)->save();
        echo $new;
		}
    
    public function action_edit()
		{
        $this->template = null;
        $table = Input::post();
        $entry = Model_Person::find($table['id']);
        $entry->first_name = $table['first_name'];
        $entry->last_name = $table['last_name'];
        $entry->password = $table['password'];
        $entry->username = $table['email'];
        $entry->skype = $table['skype'];
        $entry->phone = $table['phone'];
        $entry->unit_id = $table['company_id'];
        $result = $entry->save();
        echo $result;
		}
    
    public function action_delete()
		{
        $this->template = null;
        $id = Input::post('id');
        $entry = Model_Person::find($id);
        $entry->delete();
        $check = Model_Person::find($id);
        if (!$check)
			{
            echo '1';
			}
        else
			{
			echo '0';
			}
		}
	}
