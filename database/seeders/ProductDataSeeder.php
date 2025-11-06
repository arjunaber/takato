<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Addon;
use App\Models\Ingredient;
use App\Models\RecipeItem;
use Illuminate\Support\Facades\DB;

class ProductDataSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel relasi agar bisa di-seed ulang
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        RecipeItem::truncate();
        DB::table('addon_product')->truncate();
        Ingredient::truncate();
        Addon::truncate();
        Category::truncate();
        Product::truncate(); // Ini juga akan menghapus varian karena cascadeOnDelete
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // === 1. Buat Kategori ===
        $catMakanan = Category::create(['name' => '🍜 Makanan Utama', 'icon' => '🍜']);
        $catMinuman = Category::create(['name' => '☕ Minuman', 'icon' => '☕']);
        $catCemilan = Category::create(['name' => '🍰 Cemilan', 'icon' => '🍰']);

        // === 2. Buat Add-Ons (Master) ===
        $addonTelur = Addon::create(['name' => 'Telur Mata Sapi', 'price' => 5000]);
        $addonKeju = Addon::create(['name' => 'Keju Parut', 'price' => 3000]);
        $addonKornet = Addon::create(['name' => 'Kornet', 'price' => 4000]);
        $addonSosis = Addon::create(['name' => 'Sosis', 'price' => 6000]);
        $addonSambalMatah = Addon::create(['name' => 'Sambal Matah', 'price' => 3000]);
        $addonSambalBawang = Addon::create(['name' => 'Sambal Bawang', 'price' => 0]);
        $addonCaramel = Addon::create(['name' => 'Caramel Drizzle', 'price' => 4000]);
        $addonExtraShot = Addon::create(['name' => 'Extra Shot Kopi', 'price' => 6000]);
        $addonJelly = Addon::create(['name' => 'Jelly', 'price' => 3000]);
        $addonSausBBQ = Addon::create(['name' => 'Saus BBQ', 'price' => 2000]);
        $addonEsKrim = Addon::create(['name' => 'Es Krim', 'price' => 7000]);

        // === 3. Buat Bahan Baku (Stok) ===
        $ingIndomie = Ingredient::create(['name' => 'Bungkus Indomie', 'unit' => 'pcs', 'stock' => 100]);
        $ingTelur = Ingredient::create(['name' => 'Telur Ayam', 'unit' => 'pcs', 'stock' => 200]);
        $ingAyam = Ingredient::create(['name' => 'Dada Ayam', 'unit' => 'gram', 'stock' => 5000]);
        $ingNasi = Ingredient::create(['name' => 'Nasi Putih', 'unit' => 'gram', 'stock' => 10000]);
        $ingKopi = Ingredient::create(['name' => 'Biji Kopi', 'unit' => 'gram', 'stock' => 2000]);
        $ingSusu = Ingredient::create(['name' => 'Susu UHT', 'unit' => 'ml', 'stock' => 5000]);
        $ingTeh = Ingredient::create(['name' => 'Bubuk Teh', 'unit' => 'gram', 'stock' => 1000]);
        $ingKentang = Ingredient::create(['name' => 'Kentang Beku', 'unit' => 'gram', 'stock' => 3000]);
        $ingRoti = Ingredient::create(['name' => 'Roti Tawar', 'unit' => 'pcs', 'stock' => 50]);

        // === 4. Buat Produk, Varian, Relasi Addon, dan Resep ===

        // --- Produk 1: Indomie ---
        $prodIndomie = Product::create(['category_id' => $catMakanan->id, 'name' => 'Indomie', 'is_favorite' => true]);
        $varIndomieGoreng = $prodIndomie->variants()->create(['name' => 'Goreng', 'price' => 15000]);
        $varIndomieKuah = $prodIndomie->variants()->create(['name' => 'Kuah', 'price' => 16000]);
        $prodIndomie->addons()->attach([$addonTelur->id, $addonKeju->id, $addonKornet->id, $addonSosis->id]);
        RecipeItem::create(['variant_id' => $varIndomieGoreng->id, 'ingredient_id' => $ingIndomie->id, 'quantity_used' => 1]);
        RecipeItem::create(['variant_id' => $varIndomieKuah->id, 'ingredient_id' => $ingIndomie->id, 'quantity_used' => 1]);

        // --- Produk 2: Ayam Geprek ---
        $prodAyam = Product::create(['category_id' => $catMakanan->id, 'name' => 'Ayam Geprek']);
        $varAyamOri = $prodAyam->variants()->create(['name' => 'Original', 'price' => 20000]);
        $varAyamPedas = $prodAyam->variants()->create(['name' => 'Pedas Nagih', 'price' => 22000]);
        $prodAyam->addons()->attach([$addonSambalBawang->id, $addonSambalMatah->id, $addonKeju->id]);
        RecipeItem::create(['variant_id' => $varAyamOri->id, 'ingredient_id' => $ingAyam->id, 'quantity_used' => 150]);
        RecipeItem::create(['variant_id' => $varAyamPedas->id, 'ingredient_id' => $ingAyam->id, 'quantity_used' => 150]);

        // --- Produk 3: Nasi Goreng ---
        $prodNasgor = Product::create(['category_id' => $catMakanan->id, 'name' => 'Nasi Goreng']);
        $varNasgorBiasa = $prodNasgor->variants()->create(['name' => 'Biasa', 'price' => 25000]);
        $varNasgorSpesial = $prodNasgor->variants()->create(['name' => 'Spesial', 'price' => 32000]);
        $prodNasgor->addons()->attach([$addonTelur->id, $addonSosis->id]);
        RecipeItem::create(['variant_id' => $varNasgorBiasa->id, 'ingredient_id' => $ingNasi->id, 'quantity_used' => 200]);
        RecipeItem::create(['variant_id' => $varNasgorSpesial->id, 'ingredient_id' => $ingNasi->id, 'quantity_used' => 200]);

        // --- Produk 4: Cafe Latte ---
        $prodLatte = Product::create(['category_id' => $catMinuman->id, 'name' => 'Cafe Latte', 'is_favorite' => true]);
        $varLatteHot = $prodLatte->variants()->create(['name' => 'Hot', 'price' => 25000]);
        $varLatteIce = $prodLatte->variants()->create(['name' => 'Ice', 'price' => 28000]);
        $prodLatte->addons()->attach([$addonCaramel->id, $addonExtraShot->id]);
        RecipeItem::create(['variant_id' => $varLatteHot->id, 'ingredient_id' => $ingKopi->id, 'quantity_used' => 20]);
        RecipeItem::create(['variant_id' => $varLatteHot->id, 'ingredient_id' => $ingSusu->id, 'quantity_used' => 150]);
        RecipeItem::create(['variant_id' => $varLatteIce->id, 'ingredient_id' => $ingKopi->id, 'quantity_used' => 20]);
        RecipeItem::create(['variant_id' => $varLatteIce->id, 'ingredient_id' => $ingSusu->id, 'quantity_used' => 200]);

        // --- Produk 5: Es Teh Manis ---
        $prodEsTeh = Product::create(['category_id' => $catMinuman->id, 'name' => 'Es Teh Manis']);
        $varEsTeh = $prodEsTeh->variants()->create(['name' => 'Original', 'price' => 8000]);
        $prodEsTeh->addons()->attach([$addonJelly->id]);
        RecipeItem::create(['variant_id' => $varEsTeh->id, 'ingredient_id' => $ingTeh->id, 'quantity_used' => 10]);

        // --- Produk 6: Kopi Hitam ---
        $prodKopiHitam = Product::create(['category_id' => $catMinuman->id, 'name' => 'Kopi Hitam']);
        $varKopiTubruk = $prodKopiHitam->variants()->create(['name' => 'Tubruk', 'price' => 12000]);
        $varKopiV60 = $prodKopiHitam->variants()->create(['name' => 'V60', 'price' => 22000]);
        // Tidak punya addons -> $prodKopiHitam->addons()->attach([]);
        RecipeItem::create(['variant_id' => $varKopiTubruk->id, 'ingredient_id' => $ingKopi->id, 'quantity_used' => 15]);
        RecipeItem::create(['variant_id' => $varKopiV60->id, 'ingredient_id' => $ingKopi->id, 'quantity_used' => 18]);

        // --- Produk 7: Kentang Goreng ---
        $prodKentang = Product::create(['category_id' => $catCemilan->id, 'name' => 'Kentang Goreng']);
        $varKentangOri = $prodKentang->variants()->create(['name' => 'Original', 'price' => 18000]);
        $varKentangKeju = $prodKentang->variants()->create(['name' => 'Bumbu Keju', 'price' => 20000]);
        $prodKentang->addons()->attach([$addonSausBBQ->id]);
        RecipeItem::create(['variant_id' => $varKentangOri->id, 'ingredient_id' => $ingKentang->id, 'quantity_used' => 100]);
        RecipeItem::create(['variant_id' => $varKentangKeju->id, 'ingredient_id' => $ingKentang->id, 'quantity_used' => 100]);

        // --- Produk 8: Roti Bakar ---
        $prodRoti = Product::create(['category_id' => $catCemilan->id, 'name' => 'Roti Bakar']);
        $varRotiCoklat = $prodRoti->variants()->create(['name' => 'Coklat', 'price' => 15000]);
        $varRotiKeju = $prodRoti->variants()->create(['name' => 'Keju Susu', 'price' => 17000]);
        $prodRoti->addons()->attach([$addonEsKrim->id, $addonKeju->id]);
        RecipeItem::create(['variant_id' => $varRotiCoklat->id, 'ingredient_id' => $ingRoti->id, 'quantity_used' => 2]);
        RecipeItem::create(['variant_id' => $varRotiKeju->id, 'ingredient_id' => $ingRoti->id, 'quantity_used' => 2]);
    }
}
