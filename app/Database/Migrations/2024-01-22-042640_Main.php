<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Main extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'anchor' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'img' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'img_ref' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'desc' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
            ],
            'keywords' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'description' => [
                'type' => 'TEXT',
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
        $this->forge->createTable('main');
    }

    public function down()
    {
        $this->forge->dropTable('main');
    }
}
