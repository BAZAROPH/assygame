<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
    
                $table->foreign('pays_id')
                        ->references('id')
                        ->on('pays')
                        ->onDelete('cascade');
    
                $table->foreign('ville_id')
                        ->references('id')
                        ->on('villes')
                        ->onDelete('cascade');
            });

        Schema::table('produits', function (Blueprint $table) {
            $table->foreign('categorie_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');

            $table->foreign('fournisseur_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('mesure_id')
                    ->references('id')
                    ->on('mesures')
                    ->onDelete('cascade');
        });

        Schema::table('produit_likes', function (Blueprint $table) {
            $table->foreign('produit_id')
                    ->references('id')
                    ->on('produits')
                    ->onDelete('cascade');

            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('categorie_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');
        });

        Schema::table('options', function (Blueprint $table) {
            $table->foreign('produit_id')
                    ->references('id')
                    ->on('produits')
                    ->onDelete('cascade');

            $table->foreign('option_id')
                    ->references('id')
                    ->on('options')
                    ->onDelete('cascade');
        });

        Schema::table('tarifs', function (Blueprint $table) {
                $table->foreign('produit_id')
                        ->references('id')
                        ->on('produits')
                        ->onDelete('cascade');
            });

        Schema::table('commandes', function (Blueprint $table) {
            $table->foreign('client_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });

        Schema::table('villes', function (Blueprint $table) {
            $table->foreign('pays_id')
                    ->references('id')
                    ->on('pays')
                    ->onDelete('cascade');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('emetteur_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');

            $table->foreign('recepteur_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->foreign('moyen_id')
                    ->references('id')
                    ->on('moyens')
                    ->onDelete('cascade');

            $table->foreign('commande_id')
                    ->references('id')
                    ->on('commandes')
                    ->onDelete('cascade');
        });

        Schema::table('commande_produits', function (Blueprint $table) {
            $table->foreign('produit_id')
                    ->references('id')
                    ->on('produits')
                    ->onDelete('cascade');

            $table->foreign('commande_id')
                    ->references('id')
                    ->on('commandes')
                    ->onDelete('cascade');

            $table->foreign('option_id')
                    ->references('id')
                    ->on('options')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
