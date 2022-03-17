<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Salesreceivablesuploads extends Migration
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
			'order_id'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 20
			],
			'payment_id' => [
				'type'           => 'varchar',
				'constraint'     => 30,
			],
             ]);
		$this->forge->addPrimaryKey('id',true);
//        $this->forge->addForeignKey('order_id','sales','order_id');
//        $this->forge->addForeignKey('payment_id','salesreceivables','payment_id');
       
		$this->forge->createTable('salesreceivablesuploads');
    }

    public function down()
    {
        //$this->forge->dropTable('salesreceivablesuploads');
    }
}
