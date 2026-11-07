<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category', 50)->default('technical'); // technical, architecture, pitch_deck, reports, agreements
            $table->string('file_path');
            $table->string('file_name');
            $table->unsignedBigInteger('file_size')->default(0); // in bytes
            $table->string('file_type', 20)->default('pdf');
            $table->string('version', 20)->default('v1.0');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_documents');
    }
};

