<?php
use Orm\Model;

class Model_Project extends Model
{
	protected static $_table_name = 'projects';
        
        	protected static $_belongs_to = array(
		'manager' => array(
			'model_to' => 'Model_Person',
                                                      'key_from' => 'manager_id',
			'key_to' => 'id',
		),
                    
                                    'company' => array(
			'model_to' => 'Model_Company',
                                                      'key_from' => 'company_id',
			'key_to' => 'id',
		));
	
	protected static $_many_many = array(
		'persons' => array(
			'key_from' => 'id', //текущий id 
			'key_through_from' => 'project_id', // текущий id в связке
			'table_through' => 'persons_projects', // имя таблицы связки
			'key_through_to' => 'person_id', // id второй таблицы в связке
			'model_to' => 'Model_Person', // модель второй таблицы
			'key_to' => 'id', //id второй таблицы
			'cascade_save' => true,
			'cascade_delete' => false,
		)
	);
    
	protected static $_properties = array(
		'id',
		'name',
		'status', // 0 - off, 1 - on
                                    'company_id',
		'manager_id',
		'created_at',
		'updated_at',
	);

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

}
