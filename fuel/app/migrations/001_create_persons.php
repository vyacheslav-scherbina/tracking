<?php

namespace Fuel\Migrations;

class Create_persons
{
	public function up()
	{
		\DBUtil::create_table('persons', array(
            
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'username' => array('constraint' => 255, 'type' => 'varchar'),
			'password' => array('constraint' => 255, 'type' => 'varchar'),
            'group' => array('constraint' => 10, 'type' => 'int'),//0 - superusers, 1 - employees, 2 - contacts
            'last_login'  => array('constraint' => 255, 'type' => 'varchar'),
            'login_hash'  => array('constraint' => 255, 'type' => 'varchar'),
            
			'first_name' => array('constraint' => 255, 'type' => 'varchar'),
			'last_name' => array('constraint' => 255, 'type' => 'varchar'),
			'skype' => array('constraint' => 255, 'type' => 'varchar'),
			'phone' => array('constraint' => 255, 'type' => 'varchar'),
            
			'status' => array('constraint' => 11, 'type' => 'int'),//0 - working, 1 - fired, 
			'unit_id' => array('constraint' => 11, 'type' => 'int'),
			'is_unit_manager' => array('type' => 'boolean'),
			'image_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('persons');
	}
}
