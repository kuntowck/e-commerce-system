<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'image_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'is_primary' => [
                'type'    => 'BOOLEAN',
                'default' => false,
                'null'    => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        // Primary Key
        $this->forge->addPrimaryKey('id');

        // Foreign Key
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');

        // Membuat tabel
        $this->forge->createTable('product_images');
    }

    public function down()
    {
        $this->forge->dropTable('product_images');
    }
}
