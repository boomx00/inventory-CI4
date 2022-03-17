<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Salesreceivables extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'payment_id' => [
				'type'           => 'varchar',
				'constraint'     => 30,
			],
			'order_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
			],
			'amount'       => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'detail' => [
				'type'           => 'VARCHAR',
				'constraint'       	 => 255,
			],
			'date'      => [
				'type'           => 'date',
			],
             'created_at' => [
				'type'           => 'DATETIME',
			],
              'updated_at' => [
				'type'           => 'DATETIME',
			]
           
		]);

		$this->forge->addPrimaryKey('payment_id',true);
//        $this->forge->addForeignKey('order_id','sales','order_id');
		$this->forge->createTable('salesreceivables');
    }

    public function down()
    {
        $this->forge->dropTable('salesreceivables');
    }
}
