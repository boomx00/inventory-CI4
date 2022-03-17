<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TransactionPurchase extends Migration
{
    public function up()
    {
         $this->forge->addField([
             'id' => [
				'type'           => 'int',
				'constraint'     => 6,
			],
			'order_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			 'product_code'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
            'product_name'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			'price'       => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
            'quantity'       => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
            'total'       => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
             'created_at' => [
				'type'           => 'DATETIME',
			],
              'updated_at' => [
				'type'           => 'DATETIME',
			],
             'status'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
             'days'       => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
             
		]);

		$this->forge->addPrimaryKey('id',true);
        $this->forge->addForeignKey('order_id','purchase','order_id');
		$this->forge->createTable('transaction_purchase');
    }

    public function down()
    {
        //$this->forge->dropTable('transaction_purchase');
    }
}
