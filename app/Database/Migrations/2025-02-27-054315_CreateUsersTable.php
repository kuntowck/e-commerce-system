<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
                'unique'     => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255, // Disimpan dalam bentuk hashed
                'null'       => false,
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user', 'moderator'],
                'default'    => 'user',
                'null'       => false,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'banned'],
                'default'    => 'active',
                'null'       => false,
            ],
            'last_login' => [
                'type' => 'TIMESTAMP',
                'null' => true, // Waktu terakhir login, bisa NULL jika belum pernah login
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

        // Membuat tabel
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
