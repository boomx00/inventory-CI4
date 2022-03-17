<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Supplier extends Migration
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
            'code'       => [
				'type'           => 'varchar',
				'constraint'     => 30
			],
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100
			],
			'phone'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'address'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'detail' => [
				'type'           => 'VARCHAR',
				'constraint'       	 => 100,
			]
			
		]);
		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('supplier');
    }

    public function down()
    {
        //$this->forge->dropTable('supplier');
    }
}
