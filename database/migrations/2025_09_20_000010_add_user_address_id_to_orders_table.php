<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Get all foreign keys for a table
     *
     * @param string $tableName
     * @return array
     */
    protected function getForeignKeys(string $tableName): array
    {
        $conn = Schema::getConnection();
        $foreignKeys = [];
        
        try {
            $schema = $conn->getDoctrineSchemaManager();
            $table = $schema->listTableDetails($tableName);
            
            foreach ($table->getForeignKeys() as $foreignKey) {
                $foreignKeys[] = $foreignKey->getName();
            }
        } catch (\Exception $e) {
            // If there's an error, return empty array
        }
        
        return $foreignKeys;
    }
    
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Only add the column if it does not exist
            if (!Schema::hasColumn('orders', 'user_address_id')) {
                $table->foreignId('user_address_id')
                    ->nullable()
                    ->after('user_id');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            // Ensure the correct foreign key is set up
            // Check if the foreign key exists before trying to drop it
            $foreignKeys = $this->getForeignKeys('orders');
            $foreignKeyName = 'orders_user_address_id_foreign';
            
            if (in_array($foreignKeyName, $foreignKeys)) {
                $table->dropForeign([$foreignKeyName]);
            }

            $table->foreign('user_address_id')
                ->references('id')
                ->on('users_addresses')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop FK if exists using the same approach as in up()
            $foreignKeys = $this->getForeignKeys('orders');
            $foreignKeyName = 'orders_user_address_id_foreign';
            
            if (in_array($foreignKeyName, $foreignKeys)) {
                $table->dropForeign([$foreignKeyName]);
            }

            // Drop column if exists
            if (Schema::hasColumn('orders', 'user_address_id')) {
                $table->dropColumn('user_address_id');
            }
        });
    }
};