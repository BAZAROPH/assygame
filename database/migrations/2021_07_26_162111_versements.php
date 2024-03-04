<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')
            ->nullable()
            ->constrained('commandes')
            ->onUpdate('cascade')
            ->onDelete('set null');
            $table->foreignId('user_id')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('set null');
            $table->double('montant')->nullable();
            $table->string('transid')->nullable();
            $table->string('abonnement')->nullable();
            $table->string('methode')->nullable();
            $table->string('payid')->nullable();
            $table->string('buyername')->nullable();
            $table->string('transstatus')->nullable();
            $table->string('signature')->nullable();
            $table->string('phone')->nullable();
            $table->string('errormessage')->nullable();
            $table->string('statut')->nullable();
            $table->string('datepaiement')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('versements');
    }
}
