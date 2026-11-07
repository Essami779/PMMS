<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('color_code')->default('indigo');
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('governorates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('color_code')->default('blue');
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('رمز العملة الدولي (YER, SAR, USD, ...)');
            $table->string('name', 50)->comment('الاسم الكامل للعملة');
            $table->string('symbol', 15)->default('ر.ي')->comment('رمز العرض');
            $table->string('flag', 10)->default('🇾🇪')->comment('علم العملة / الدولة');
            $table->string('color_code', 30)->default('emerald')->comment('كود لون الثيم');
            $table->string('hex_color', 10)->default('#10b981')->comment('اللون الست عشري الأساسي');
            $table->decimal('exchange_rate', 14, 4)->default(1.0000)->comment('سعر الصرف مقابل العملة الافتراضية');
            $table->boolean('is_default')->default(false)->comment('هل هي العملة الافتراضية');
            $table->boolean('is_active')->default(true)->comment('حالة تفعيل العملة');
            $table->unsignedSmallInteger('sort_order')->default(0)->comment('ترتيب العرض');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
        Schema::dropIfExists('governorates');
        Schema::dropIfExists('units');
    }
};
