<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employee extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'auto_increment' => true
			],
			'firstname'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 50
			],
			'lastname'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'city'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'address'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'phoneone'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'phonetwo'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'created_at' => [
				'type'           => 'DATETIME',
				'null'       	 => true,
			],
			'updated_at' => [
				'type'           => 'DATETIME',
				'null'       	 => true,
			]
		]);
		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('employee');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('employee');

	}
}
