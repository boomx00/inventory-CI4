<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sales extends Migration
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
			'date'          => [
				'type'           => 'date',
			],
			'order_id'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 20
			],
			'customer'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'sales'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'total'      => [
				'type'           => 'INT',
			],
			'paid'      => [
				'type'           => 'INT',
			],
			'unpaid'      => [
				'type'           => 'INT',
			],
			'status'      => [
				'type'           => 'ENUM("lunas-cash","bon-hutang")',
			],
			'detail'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
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
		$this->forge->createTable('sales');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('sales');

	}
}
