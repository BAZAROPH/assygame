<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('titre');
            $table->text('sous_titre')->nullable();
            $table->text('description')->nullable();
            $table->integer('promo')->nullable();
            $table->biginteger('categorie_id');
            $table->biginteger('mesure_id')->nullable();
            $table->biginteger('fournisseur_id')->nullable();
            $table->softDeletes('deleted_at');
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
        Schema::dropIfExists('produits');
    }
}
