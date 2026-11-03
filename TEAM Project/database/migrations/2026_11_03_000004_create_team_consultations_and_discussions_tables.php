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
        // 1. استشارات وجلسات إرشاد وتوجيه المشروع
        Schema::create('team_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->string('consultant_name');
            $table->string('consultant_title')->nullable();
            $table->string('consultant_avatar')->nullable();
            $table->string('topic');
            $table->string('category')->default('technical'); // technical, security, business, ux, legal
            $table->text('description')->nullable();
            $table->string('status')->default('pending'); // pending, confirmed, completed, cancelled
            $table->dateTime('session_date')->nullable();
            $table->string('meeting_link')->nullable();
            $table->text('recommendations')->nullable();
            $table->unsignedTinyInteger('rating')->nullable(); // 1 to 5
            $table->timestamps();
        });

        // 2. نقاشات وغرفة عمليات الفريق (War Room Discussions)
        Schema::create('team_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('category')->default('general'); // general, architecture, blocker, announcement, security
            $table->boolean('is_pinned')->default(false);
            $table->unsignedInteger('replies_count')->default(0);
            $table->timestamps();
        });

        // 3. ردود ومشاركات النقاش
        Schema::create('team_discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained('team_discussions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_discussion_replies');
        Schema::dropIfExists('team_discussions');
        Schema::dropIfExists('team_consultations');
    }
};

