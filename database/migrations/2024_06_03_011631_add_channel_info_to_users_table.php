<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChannelInfoToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable();
            if (!Schema::hasColumn('users', 'channel_name')) {
                $table->string('channel_name')->nullable();
            }
            if (!Schema::hasColumn('users', 'channel_description')) {
                $table->text('channel_description')->nullable();
            }
                if (!Schema::hasColumn('users', 'profile_picture')) {
                    $table->string('profile_picture')->nullable();
                }
            $table->string('credit_card')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            if (Schema::hasColumn('users', 'channel_name')) {
                $table->dropColumn('channel_name');
            }
            if (Schema::hasColumn('users', 'channel_description')) {
                $table->dropColumn('channel_description');
            }

            if (Schema::hasColumn('users', 'profile_picture')) {
                $table->dropColumn('profile_picture');
            }
            
            $table->dropColumn('credit_card');
        });
    }
}
