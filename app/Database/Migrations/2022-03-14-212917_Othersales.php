<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Othersales extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'date'       => [
				'type'           => 'date',
			],
			'category'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 50,
			],
			'amount'      => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'detail'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			],
		]);

		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('othersales');
    }

    public function down()
    {
                        $this->forge->dropTable('othersales');

    }
}
