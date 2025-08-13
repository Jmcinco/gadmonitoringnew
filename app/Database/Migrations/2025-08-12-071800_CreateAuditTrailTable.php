<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAuditTrailTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'action' => [
                'type' => 'ENUM',
                'constraint' => ['CREATE', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT'],
                'null' => false,
            ],
            'table_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'record_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'employee_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'employee_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'details' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'old_data' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'new_data' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('action');
        $this->forge->addKey('table_name');
        $this->forge->addKey('created_at');
        
        // Add foreign key constraint
        $this->forge->addForeignKey('user_id', 'employees', 'emp_id', 'SET NULL', 'CASCADE');
        
        $this->forge->createTable('audit_trail');
    }

    public function down()
    {
        $this->forge->dropTable('audit_trail');
    }
}
