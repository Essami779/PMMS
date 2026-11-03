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
        // 1. Teams Table (بيانات الفريق ومشرع التخرج)
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leader_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('project_title');
            $table->text('description')->nullable();
            $table->string('category')->nullable()->default('الذكاء الاصطناعي وتطبيقات الويب');
            $table->string('university')->nullable()->default('جامعة صنعاء');
            $table->string('department')->nullable()->default('كلية الحاسوب وتكنولوجيا المعلومات');
            $table->string('invite_code', 12)->unique();
            $table->string('status', 50)->default('in_progress'); // ideation, in_progress, under_review, completed
            $table->unsignedTinyInteger('progress_percentage')->default(25);
            $table->string('github_repo')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        // 2. Team Members Table (أعضاء الفريق وأدوارهم)
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role_in_team', 100)->default('عضو فريق'); // قائد الفريق، مبرمج واجهات، مبرمج خلفية، مهندس ذكاء اصطناعي، مصمم UI/UX، مسؤول التوثيق
            $table->timestamp('joined_at')->useCurrent();
            $table->string('status', 30)->default('active'); // active, inactive, pending
            $table->timestamps();

            $table->unique(['team_id', 'user_id']);
        });

        // 3. Team Invitations Table (نظام الدعوات المعلقة والروابط)
        Schema::create('team_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('invited_by')->constrained('users')->onDelete('cascade');
            $table->string('email');
            $table->string('role_in_team', 100)->default('عضو فريق');
            $table->string('token', 64)->unique();
            $table->string('status', 30)->default('pending'); // pending, accepted, rejected, cancelled
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // 4. Member Profiles & CVs Table (السيرة الذاتية وملفات الأعضاء)
        Schema::create('member_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->unique();
            $table->string('job_title')->nullable()->default('مهندس برمجيات');
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->text('skills')->nullable(); // JSON or comma-separated
            $table->string('university_id_number')->nullable();
            $table->string('major')->nullable();
            $table->decimal('gpa', 4, 2)->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('cv_path')->nullable(); // PDF file path
            $table->timestamps();
        });

        // 5. Team Tasks & Monitoring Table (متابعة وإسناد المهام للقائد)
        Schema::create('team_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status', 30)->default('todo'); // todo, in_progress, review, done
            $table->string('priority', 20)->default('medium'); // low, medium, high, urgent
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_tasks');
        Schema::dropIfExists('member_profiles');
        Schema::dropIfExists('team_invitations');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('teams');
    }
};

