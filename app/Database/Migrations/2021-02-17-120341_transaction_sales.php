<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionSales extends Migration
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
			'order_id'       => [
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
		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('transaction_Sales');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('transaction_sales');

	}
}
