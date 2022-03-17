<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Temptable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'order_id'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 50
			],
			'order_code'       => [
					'type'           => 'VARCHAR',
					'constraint'     => 50
				],
			'product_code'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50
			],
			'product_name'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50
			],

			'customer'      => [
				'type'           => 'VARCHAR',
				'constraint'	=> 100,
			],
			'date'      => [
				'type'           => 'DATE',
			],
				'price'      => [
					'type'           => 'INT',
				],
				'quantity'      => [
					'type'           => 'INT',
				],
				'total'      => [
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

		$this->forge->createTable('temptable');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('temptable');

	}
}
