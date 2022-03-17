<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tempeditbuy extends Migration
{
    public function up()
    {
        $this->forge->addField([
             'id' => [
				'type'           => 'INT',
				'constraint'     => 6,
			],
			'order_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
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
           
		]);

		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('tempeditbuy');
    }

    public function down()
    {
        //$this->forge->dropTable('tempbuy');
    }
}
