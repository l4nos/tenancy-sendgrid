<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_authentication', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->string('domain', 255)->unique();
            $table->unsignedBigInteger('sendgrid_id')->nullable()->unique();
            $table->boolean('valid')->default(false);
            $table->json('dkim_setup')->nullable();
            $table->timestamps();
            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_authentication');
    }
};
