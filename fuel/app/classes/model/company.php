<?php
class Model_Company extends Orm\Model
{
	protected static $_table_name = 'companies';
	
    protected static $_belongs_to = array('image');
    
	protected static $_properties = array(
		'id',
		'name',
		'country',
		'details' => array(
			'default' => ''
		),
		'image_id' => array(
			'default' => 3 // image by default - id 1 - person's icon; id 2 - unit's icon; id 3 - company's icon;
		),
		'updated_at',
		'created_at'
	);
	
	protected static $_has_many = array(
		'persons' => array(
			'where' => array(
				array('group', '=', 2)
			),
			'key_from' => 'id',
			'key_to' => 'unit_id'
		)
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