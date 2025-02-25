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
            $table->json('canviewany_id');
            $table->json('cancreate_id');
            $table->json('canupdate_id');
            $table->json('canview_id');
            $table->json('candelete_id');
            $table->json('canforcedelete_id');
            $table->json('canforcedeleteany_id');
            $table->json('canrestore_id');
            $table->json('canrestoreany_id');
            $table->json('canreorder_id');
        });
    }
};
