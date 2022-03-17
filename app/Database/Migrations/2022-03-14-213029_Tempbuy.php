<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tempbuy extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'id' => [
				'type'           => 'INT',
				'constraint'     => 6,
			],
			'order_code'          => [
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
            'counter'       => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
             'created_at' => [
				'type'           => 'DATETIME',
			],
              'updated_at' => [
				'type'           => 'DATETIME',
			],
            'user'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
           
		]);

		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('tempbuy');
    }

    public function down()
    {
        //$this->forge->dropTable('tempbuy');
    }
}
