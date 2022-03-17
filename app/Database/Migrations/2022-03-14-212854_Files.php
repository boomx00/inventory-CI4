<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Files extends Migration
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
			'name'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'type'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			'created_at'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
			
		]);

		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('files');
    }

    public function down()
    {
                $this->forge->dropTable('files');

    }
}
