<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true, // Bisa kosong
            ],
            'price' => [
                'type'       => 'INT',
                'constraint' => 11, // Contoh: 9999.99
                'null'       => false,
            ],
            'stock' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, // Tidak boleh negatif
                'null'       => false,
                'default'    => 0, // Stok default 0
            ],
            'category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['available', 'unavailable'],
                'default'    => 'available',
                'null'       => false,
            ],
            'is_new' => [
                'type'    => 'BOOLEAN',
                'default' => false,
                'null'    => false,
            ],
            'is_sale' => [
                'type'    => 'BOOLEAN',
                'default' => false,
                'null'    => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true, // Untuk soft delete
            ],
        ]);

        // Primary Key
        $this->forge->addPrimaryKey('id');

        // Foreign Key
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');

        // Membuat tabel
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
