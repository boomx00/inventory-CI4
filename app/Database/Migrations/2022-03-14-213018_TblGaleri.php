<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblGaleri extends Migration
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
			'judul'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			]);
		$this->forge->addPrimaryKey('id',true);
    
       
		$this->forge->createTable('tbl_galeri');
             
    }

    public function down()
    {
        //$this->forge->dropTable('tbl_galeri');
    }
}
