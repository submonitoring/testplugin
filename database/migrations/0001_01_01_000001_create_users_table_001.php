<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('canviewany_id')->nullable();
            $table->json('cancreate_id')->nullable();
            $table->json('canupdate_id')->nullable();
            $table->json('canview_id')->nullable();
            $table->json('candelete_id')->nullable();
            $table->json('canforcedelete_id')->nullable();
            $table->json('canforcedeleteany_id')->nullable();
            $table->json('canrestore_id')->nullable();
            $table->json('canrestoreany_id')->nullable();
            $table->json('canreorder_id')->nullable();
        });
    }
};
