<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->collation('utf8mb4_unicode_ci');
            $table->string('school_name_bn')->collation('utf8mb4_unicode_ci');
            $table->string('email')->unique()->collation('utf8mb4_unicode_ci');
            $table->string('password')->collation('utf8mb4_unicode_ci');
            $table->string('address')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('phone_number')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('unique_id')->nullable()->collation('utf8mb4_unicode_ci');
            $table->integer('color')->default('0');
            $table->integer('language')->default('bn');
            $table->integer('status')->default('1');
            $table->string('za_ip_address')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('zk_ip_port')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('state')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('city')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('postcode')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('school_logo')->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('slogan')->nullable();
            $table->string('slogan_bn')->nullable();
            $table->string('ein_number')->nullable();
            $table->boolean('is_editor')->default(false);
            $table->double('billing_add')->nullable();
            $table->timestamp('trial_end_date')->nullable();
            $table->integer('subscription_status')->default('0');
            $table->tinyInteger('is_down')->default('0');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
        // $table->dropColumn('trial_end_date');
    }
}
