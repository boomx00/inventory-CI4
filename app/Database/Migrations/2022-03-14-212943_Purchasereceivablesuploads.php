<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Purchasereceivablesuploads extends Migration
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
             'paymentid' => [
				'type'           => 'varchar',
				'constraint'     => 30,
			],
			'order_id'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			'gambar'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 255,
			]
            ]);
		$this->forge->addPrimaryKey('id',true);
        $this->forge->addForeignKey('order_id','purchase','order_id');
//        $this->forge->addForeignKey('paymentid','purchasereceivables','paymentid');
       
		$this->forge->createTable('purchasereceivablesuploads');
    }

    public function down()
    {
        $this->forge->dropTable('purchasereceivables');
    }
}
