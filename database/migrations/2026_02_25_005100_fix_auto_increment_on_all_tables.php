<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixAutoIncrementOnAllTables extends Migration
{
    /**
     * Tables that were missing AUTO_INCREMENT on their `id` primary key.
     */
    private $tables = [
        'images'                 => 'BIGINT UNSIGNED',
        'access_keys'            => 'BIGINT UNSIGNED',
        'addresses'              => 'BIGINT UNSIGNED',
        'admin_menu'             => 'INT UNSIGNED',
        'admin_operation_log'    => 'INT UNSIGNED',
        'admin_permissions'      => 'INT UNSIGNED',
        'admin_roles'            => 'INT UNSIGNED',
        'affiliate_commissions'  => 'BIGINT UNSIGNED',
        'affiliate_transactions' => 'BIGINT UNSIGNED',
        'affiliate_withdraws'    => 'BIGINT UNSIGNED',
        'app_version'            => 'BIGINT UNSIGNED',
        'chat_heads'             => 'BIGINT UNSIGNED',
        'chat_messages'          => 'BIGINT UNSIGNED',
        'countries'              => 'BIGINT UNSIGNED',
        'delivery_addresses'     => 'BIGINT UNSIGNED',
        'districts'              => 'BIGINT UNSIGNED',
        'failed_jobs'            => 'BIGINT UNSIGNED',
        'fcm_tokens'             => 'BIGINT UNSIGNED',
        'forgot_password'        => 'BIGINT UNSIGNED',
        'gens'                   => 'BIGINT UNSIGNED',
        'jobs'                   => 'BIGINT UNSIGNED',
        'mail_subscription'      => 'BIGINT UNSIGNED',
        'migrations'             => 'INT UNSIGNED',
        'notification_models'    => 'BIGINT UNSIGNED',
        'ordered_items'          => 'BIGINT UNSIGNED',
    ];

    public function up()
    {
        foreach ($this->tables as $table => $type) {
            if (Schema::hasTable($table)) {
                DB::statement("ALTER TABLE `{$table}` MODIFY `id` {$type} NOT NULL AUTO_INCREMENT");
            }
        }
    }

    public function down()
    {
        // Removing AUTO_INCREMENT is destructive and unnecessary; left as no-op.
    }
}
