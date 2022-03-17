<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Uploadsothersales extends Migration
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
			'salesid'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			]);
		$this->forge->addPrimaryKey('id',true);
       
		$this->forge->createTable('uploadsothersales');
             
    }

    public function down()
    {
        //$this->forge->dropTable('uploadsothersales');
    }
}
