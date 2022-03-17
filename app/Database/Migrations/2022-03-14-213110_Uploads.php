<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Uploads extends Migration
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
			'code'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			]);
		$this->forge->addPrimaryKey('id',true);
        $this->forge->addForeignKey('code','stock','code');
       
		$this->forge->createTable('uploads');
              
    }

    public function down()
    {
        //$this->forge->dropTable('uploads');
    }
}
