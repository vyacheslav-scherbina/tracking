<?php
use Orm\Model;

class Model_Image extends Model
{
	protected static $_table_name = 'images';
	
    protected static $_has_many   = array('person', 'unit', 'company');
    
	protected static $_properties = array(
		'id',
		'content',
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
    
    public static function set_config()
    {
        $config = array(
            'ext_whitelist' => array('jpg', 'jpeg', 'png', 'gif'),
        );
        Upload::process($config);
    }
}
