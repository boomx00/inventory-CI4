<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Stock extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'code'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
			],
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100
			],
			'price'      => [
				'type'           => 'INT',
			],
			'stock'      => [
				'type'           => 'INT',
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

		$this->forge->addPrimaryKey('code',true);
		$this->forge->createTable('stock');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('stock');

	}
}
