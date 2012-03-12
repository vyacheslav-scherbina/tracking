<?php
class Controller_Projectajax extends Controller_MyRest
{
    
    private function _get_persons($group)
    {
        $result=array();
        if(!Input::post('without'))
            $without=array(-1);
        else
            $without=Input::post('without');
        $not_in_array= array_merge(array(-1), $without);
        
        $persons=Model_Person::find()->where('unit_id', Input::post('unitid'))->where('id', 'not in', $not_in_array)->where('group', $group)->get();
        
        foreach($persons as $id => $person)
        {
            $result[$id]['last_name']=$person->last_name;
            $result[$id]['first_name']=$person->first_name;
            
            $result[$id]['image']=$person->image_id;
        }
        return(array(
            'persons' => $result,
        ));        
        
    }
    public function post_employees()
    {
        $this->response($this->_get_persons(1));     
    }

    public function post_contacts()
    {
        $this->response($this->_get_persons(2)); 
    }    
    
    public function post_delete_person()
    {
        if (@Model_Project::find(Input::post('project_id'))->persons[Input::post('id')])
        {
            $project=Model_Project::find(Input::post('project_id'));
            unset($project->persons[Input::post('id')]);
            $project->save();
        }
        $this->response("1");
    }
    
    public function post_add_person()
    {
        if (($project = Model_Project::find(Input::post('project_id'))) && ($person = Model_Person::find(Input::post('id'))))
        {
            $project->persons[]=$person;
            $project->save();
        }
        $this->response("1");
    }
    
    public function post_units()
    {
         if(!Input::post('without'))
            $without=array(-1);
        else
            $without=Input::post('without');
        $not_in_array= array_merge(array(-1), $without);
        
        $units=Model_Unit::find()->where('id', 'not in', $not_in_array)->get();
        $this->response(array(
            'units' => $units,
        ));   
    }
    
    public function get_companies()
    {
        $companies = Model_Company::find('all', array(
            'order_by' => 'name',
        ));
        
        $this->response(array(
            'companies' => $companies,
        ));
    }
    
     public function get_managers()
    {
        $table = Model_Person::find('all', array(
            'where'=> array(
                'group' => 1
            ),
            'order_by' => 'last_name',
        ));
        $managers=array();
        foreach($table as $manager)
        {
            $managers[$manager->id]['name'] = "{$manager->first_name} {$manager->last_name}";
            $managers[$manager->id]['id'] = $manager->id;
        }
        
        $this->response(array(
            'managers' => $managers,
        ));
    }
    
}
