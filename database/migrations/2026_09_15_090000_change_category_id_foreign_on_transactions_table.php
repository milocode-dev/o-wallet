<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sebelumnya category_id di transactions pakai cascadeOnDelete().
     * Efeknya: hapus kategori akan ikut menghapus SEMUA transaksi yang memakainya
     * langsung di level database, tanpa lewat logic reverseBalance() di
     * TransactionController -> saldo dompet jadi tidak sinkron.
     *
     * Diganti jadi nullOnDelete(): hapus kategori cukup mengosongkan category_id
     * pada transaksi terkait, transaksi & saldo tetap utuh.
     */
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->cascadeOnDelete();
        });
    }
};
