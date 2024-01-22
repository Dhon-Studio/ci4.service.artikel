<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Content extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'id_main' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'id_header' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addKey('id_main');
        $this->forge->addKey('id_header');
        $this->forge->addForeignKey('id_main', 'main', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_header', 'content_header', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('content');
    }

    public function down()
    {
        $this->forge->dropTable('content');
    }
}
