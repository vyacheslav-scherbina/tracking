<?php
class Controller_Unitajax extends Controller_MyRest
{
    
    public function post_save_changes()
    {
        if ($employee = Model_Person::find(Input::post('id')))
        {
            $employee->unit_id = Input::post('unit_id');
            $employee->is_unit_manager = Input::post('is_unit_manager');
            $employee->save();
        }
    }
    
}
