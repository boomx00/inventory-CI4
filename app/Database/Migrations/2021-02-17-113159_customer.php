<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Customer extends Migration
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
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100
			],
			'phone'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'address'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
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
		$this->forge->createTable('customer');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('customer');

	}
}
