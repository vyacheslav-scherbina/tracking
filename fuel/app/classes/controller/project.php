<?php
class Controller_Project extends Controller_MyTemplate
{
    public $template = 'main';
    
    public function action_index()
    {
        $projects = Model_Project::find('all', array(
            'where'=> array(
                'status' => 1
            ),
            'order_by' => 'created_at',
        ));;

        $units=array();
        $contacts=array();
       
        foreach($projects as $id => $project)
        {
            foreach($project->persons as $person)
            {
                if($person->group==2) // 0 - super, 1 - employee, 2 - contact
                {
                    $contacts[$id]['persons'][]=$person;
                } elseif($person->group==1)
                {
                    if($person->unit)
                    {
                        $units[$id]['units'][$person->unit->id]=$person->unit;
                        $units[$id]['persons'][$person->unit->id][]=$person;
                    }
                }
                    
            }
            
        }

        $data['projects']=$projects;
        $data['units']=$units;
        $data['contacts']=$contacts;

       
        
        $this->template->search=false;
        $this->template->title = 'Projects';
        $data['superuser']=$this->_get_superuser();
        $this->template->content = View::forge('project/index', $data);        
    }
    
    public function action_create()
    {
        if(Model_Person::find(Input::post('manager')) && Model_Company::find(Input::post('company'))) {
            $project = new Model_Project();
            $project->status = 1;
            $project->name = Input::post('name');
            $project->manager_id = Input::post('manager');
            $project->company_id = Input::post('company');
            $project->save();
        }
        
        Response::redirect('project');
    }
    
     public function action_delete($id = null)
    {
        if ($id and $project =  Model_Project::find($id))
        {
                $project->status=0;
                $project->save();
        }
        
        Response::redirect('project');
    }
    
}
