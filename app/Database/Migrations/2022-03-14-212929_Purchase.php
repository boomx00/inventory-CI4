<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Purchase extends Migration
{
    public function up()
    {
         $this->forge->addField([
			'order_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			'supplier'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'total'      => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'paid'      => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
             'unpaid'      => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
             'status'      => [
				'type'              => 'ENUM',
                'constraint'        => "'lunas-cash','bon-hutang'",
			],
			'detail' => [
				'type'           => 'VARCHAR',
				'constraint'       	 => 255,
			],
             'created_at' => [
				'type'           => 'DATETIME',
			],
              'updated_at' => [
				'type'           => 'DATETIME',
			],
             'days' => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
             'nopolice' => [
				'type'           => 'varchar',
				'constraint'     => 10,
			],
             'products' => [
				'type'           => 'varchar',
				'constraint'     => 255,
			],
             'transaction' => [
				'type'           => 'varchar',
				'constraint'     => 20,
			],
             'cashier' => [
				'type'           => 'varchar',
				'constraint'     => 50,
			],
             
		]);

		$this->forge->addPrimaryKey('order_id',true);
		$this->forge->createTable('purchase');
    }

    public function down()
    {
                $this->forge->dropTable('purchase');

    }
}
