<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Uploadpurchase extends Migration
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
             'gambar' => [
				'type'           => 'varchar',
				'constraint'     => 255,
			],
			'order_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			]);
		$this->forge->addPrimaryKey('id',true);
               $this->forge->addForeignKey('order_id','purchase','order_id');

		$this->forge->createTable('uploadspurchase');
             
    }

    public function down()
    {
        //$this->forge->dropTable('uploadspurchase');
    }
}
