<?php
class Model_Person extends Orm\Model
{
	protected static $_table_name = 'persons';
	
	protected static $_belongs_to = array(
		'unit' => array(
			'key_from' => 'unit_id',
			'key_to' => 'id',
		),
		'company' => array(
			'key_from' => 'unit_id',
			'key_to' => 'id',
		),
        'image'
    );
    
	protected static $_properties = array(
		'id',
        'username',
        'password',
        'group',
        
        'last_login' => array(
            'default' => ''
        ),
        'login_hash' => array(
            'default' => ''
        ),
        
		'first_name',
		
        'last_name',
        
        'skype' => array(
			'default' => ''
		),
        'phone' => array(
			'default' => ''
		),
        'status' => array(
			'default' => '1'
		),
        'unit_id' => array(
			'default' => '0'
		),
        'is_unit_manager' => array(
			'default' => '0'
		),
		'image_id' => array(
			'default' => '1' // image by default - id 1 - person's icon; id 2 - unit's icon; id 3 - company's icon;
		),
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
