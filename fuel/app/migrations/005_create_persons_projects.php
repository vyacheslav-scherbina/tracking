<?php

namespace Fuel\Migrations;

class Create_persons_projects
{
	public function up()
	{
		\DBUtil::create_table('persons_projects', array(
			'person_id' => array('constraint' => 11, 'type' => 'int'),
			'project_id' => array('constraint' => 11, 'type' => 'int'),
		), array('person_id', 'project_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('persons_projects');
	}
}

