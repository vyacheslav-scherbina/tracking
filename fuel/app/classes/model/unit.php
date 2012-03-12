<?php
use Orm\Model;

class Model_Unit extends Model
{
    
    protected static $_has_many   = array('persons');
    
    protected static $_belongs_to = array('image');
    
	protected static $_properties = array(
		'id',
		'name',
        'image_id',
		'created_at',
		'updated_at',
	);
    
    public static function get_managers_and_employees($unit)
    {
        $return = array(
            'managers' => array(),
            'employees' => array()
        );
        
        foreach ($unit['persons'] as $person)
        {
            if($person['group'] == 1)
            {
                if ($person['is_unit_manager'])
                {
                    $return['managers'][] = $person;
                }
                else
                {
                    $return['employees'][] = $person;
                }
            }
        }
        
        return $return;
    }
    
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate()
	{
        $unit_name = Input::post('name');
        
        if (empty($unit_name))
        {
            Session::set_flash('error', 'Unit Name cannot be empty');
            return false;
        }
        
        return true;
	}

}
