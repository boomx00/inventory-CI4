<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tempdelete extends Migration
{
	public function up()
	{
		$this->forge->addField([
				'id'          => [
					'type'           => 'INT',
					'unsigned'       => true,
					'auto_increment' => true
			],
			'order_id'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 50
			],
			'product_code'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50
			],
			'quantity'      => [
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

		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('tempdelete');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('tempdelete');

	}
}
