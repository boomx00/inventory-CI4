<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Expense extends Migration
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
			'date'       => [
				'type'           => 'date',
			],
			'category'      => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'amount'      => [
				'type'           => 'INT',
				'constraint'     => 11,
			],
			'detail' => [
				'type'           => 'VARCHAR',
				'constraint'       	 => 255,
			],
		]);

		$this->forge->addPrimaryKey('id',true);
		$this->forge->createTable('expense');
    }

    public function down()
    {
        $this->forge->dropTable('expense');
    }
}
