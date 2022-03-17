<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Purchasereceivables extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'paymentid' => [
				'type'           => 'varchar',
				'constraint'     => 30,
			],
			'order_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			'amount'       => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'detail' => [
				'type'           => 'VARCHAR',
				'constraint'       	 => 255,
			],
			'images'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
             'created_at' => [
				'type'           => 'DATETIME',
			],
              'updated_at' => [
				'type'           => 'DATETIME',
			],
            
             'date' => [
				'type'           => 'date',
			],
             
		]);

		$this->forge->addPrimaryKey('payment_id',true);
        $this->forge->addForeignKey('order_id','purchase','order_id');
		$this->forge->createTable('purchasereceivables');
    }

    public function down()
    {
                        $this->forge->dropTable('purchasereceivables');

    }
}
