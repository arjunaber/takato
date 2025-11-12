@extends('layouts.admin')

@section('title', 'Edit Produk')

@push('styles')
    <style>
        /* == CSS VARIAN == */
        .variant-item {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
            align-items: flex-end;
        }

        .variant-item .form-group {
            margin-bottom: 0;
        }

        .variant-name {
            flex: 3;
        }

        .variant-price {
            flex: 2;
        }

        .variant-action {
            flex: 1;
            display: flex;
            gap: 5px;
        }

        .remove-variant-btn {
            background-color: #fff0f0;
            border: 1px solid #f5c6cb;
            color: var(--danger);
        }

        .btn-recipe {
            background-color: #e6f0ff;
            border: 1px solid #b3d1ff;
            color: var(--primary);
        }

        /* == CSS GAMBAR == */
        .image-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
            padding: 5px;
        }

        /* == CSS MODAL RESEP == */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: var(--card-bg);
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .modal-body {
            padding: 24px;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 20px 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* Form di dalam modal */
        #recipe-form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            align-items: flex-end;
        }

        #recipe-form-ingredient {
            flex: 3;
        }

        #recipe-form-amount {
            flex: 2;
        }

        #recipe-list .recipe-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
        }

        #recipe-list .recipe-list-item:last-child {
            border: none;
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Edit Produk: {{ $product->name }}</h1>
    </div>

    <div class="card">
        {{-- PENTING: Tambahkan enctype="multipart/form-data" --}}
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Form Nama Produk & Kategori --}}
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $product->name) }}" placeholder="cth: Kopi Susu Gula Aren">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            {{-- >>> BARU: INPUT GAMBAR & PREVIEW <<< --}}
            <div class="form-group">
                <label for="image">Gambar Produk (Biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">

                {{-- Preview Gambar --}}
                @php
                    $imageUrl = $product->image_url ? asset('storage/' . $product->image_url) : '#';
                @endphp
                <img id="image-preview" src="{{ $imageUrl }}" alt="Preview" class="image-preview"
                    style="{{ $product->image_url ? 'display: block;' : 'display: none;' }}">

                @error('image')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            {{-- >>> AKHIR INPUT GAMBAR <<< --}}

            <hr style="margin: 25px 0;">

            {{-- BAGIAN VARIAN --}}
            <h3>Varian Harga</h3>
            <div id="variants-container">
                @php
                    $variants = old(
                        'variants',
                        $product->variants
                            ->map(function ($v) {
                                return ['id' => $v->id, 'name' => $v->name, 'price' => $v->price];
                            })
                            ->toArray(),
                    );
                @endphp

                @foreach ($variants as $index => $variant)
                    <div class="variant-item">
                        <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant['id'] ?? '' }}">
                        <div class="form-group variant-name">
                            <label>Nama Varian</label>
                            <input type="text" name="variants[{{ $index }}][name]" class="form-control"
                                placeholder="cth: Regular" value="{{ $variant['name'] ?? '' }}">
                        </div>
                        <div class="form-group variant-price">
                            <label>Harga (Rp)</label>
                            <input type="number" name="variants[{{ $index }}][price]" class="form-control"
                                placeholder="cth: 15000" value="{{ $variant['price'] ?? '' }}">
                        </div>
                        <div class="variant-action">
                            <button type="button" class="btn remove-variant-btn">Hapus</button>

                            {{-- Tombol "Atur Resep" --}}
                            @if (!empty($variant['id']))
                                <button type="button" class="btn btn-recipe btn-atur-resep"
                                    data-variant-id="{{ $variant['id'] }}"
                                    data-variant-name="{{ $variant['name'] ?? 'Varian' }}">
                                    Resep
                                </button>
                            @else
                                <span style="font-size: 12px; color: var(--text-muted); text-align: center;">Simpan
                                    dulu</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-variant-btn" class="btn btn-secondary"
                style="background-color: var(--secondary-light); color: var(--text-color);">
                + Tambah Varian
            </button>
            @error('variants')
                <div style="color: var(--danger); margin-top: 15px;">{{ $message }} (Minimal harus ada 1 varian)</div>
            @enderror

            <hr style="margin: 25px 0;">

            {{-- Bagian Add-On --}}
            <h3>Pilihan Add-On</h3>
            <div class="form-group">
                <label for="addons">Pilih add-on yang tersedia untuk produk ini (Opsional):</label>
                <select name="addons[]" id="addons" class="form-control" multiple="multiple">
                    @foreach ($addons as $addon)
                        <option value="{{ $addon->id }}"
                            @if (old('addons')) {{ in_array($addon->id, old('addons')) ? 'selected' : '' }}
                            @else
                                {{ $product->addons->contains($addon->id) ? 'selected' : '' }} @endif>
                            {{ $addon->name }} (+ Rp {{ number_format($addon->price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol Simpan Utama --}}
            <div class="text-right" style="margin-top: 30px;">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Update Produk</button>
            </div>

        </form>
    </div>

    {{-- Template Varian --}}
    <template id="variant-template">
        <div class="variant-item">
            <input type="hidden" name="variants[__INDEX__][id]" value="">
            <div class="form-group variant-name">
                <label>Nama Varian</label>
                <input type="text" name="variants[__INDEX__][name]" class="form-control" placeholder="cth: Regular">
            </div>
            <div class="form-group variant-price">
                <label>Harga (Rp)</label>
                <input type="number" name="variants[__INDEX__][price]" class="form-control" placeholder="cth: 15000">
            </div>
            <div class="variant-action">
                <button type="button" class="btn remove-variant-btn">Hapus</button>
                <span style="font-size: 12px; color: var(--text-muted); text-align: center;">Simpan dulu</span>
            </div>
        </div>
    </template>


    {{-- =================================== --}}
    {{-- ==  HTML MODAL RESEP == --}}
    {{-- =================================== --}}
    <div class="modal-overlay" id="recipe-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="recipe-modal-title">Atur Resep</h2>
            </div>
            <div class="modal-body">
                <div id="recipe-form">
                    <div class="form-group" id="recipe-form-ingredient">
                        <label>Pilih Bahan Baku</label>
                        <select id="recipe-ingredient-select" class="form-control"></select>

                        {{-- INFO STOK --}}
                        <small id="recipe-stock-info"
                            style="color: var(--text-muted); margin-top: 5px; display: block;"></small>
                    </div>
                    <div class="form-group" id="recipe-form-amount">
                        <label>Jumlah</label>
                        <input type="number" step="0.01" id="recipe-amount-input" class="form-control"
                            placeholder="0.00">
                        <small style="color: transparent; margin-top: 5px; display: block;">&nbsp;</small>
                    </div>
                    <div class="variant-action">
                        <button type="button" id="recipe-add-btn" class="btn btn-primary">Add</button>
                    </div>
                </div>
                <hr style="margin: 20px 0;">
                <h3>Resep Saat Ini</h3>
                <div id="recipe-list"></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="recipe-modal-close" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">Batal</button>
                <button type="button" id="recipe-modal-save" class="btn btn-primary">Simpan Resep</button>
            </div>
        </div>
    </div>
    {{-- =================================== --}}
    {{-- ==  AKHIR KODE HTML MODAL  == --}}
    {{-- =================================== --}}

@endsection

@push('scripts')
    {{-- Script Varian & Select2 --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SCRIPT IMAGE PREVIEW START
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');

            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Jika user menghapus file, cek apakah ada gambar lama (yang sudah ada di src)
                    if (imagePreview.src === window.location.href + '#') {
                        imagePreview.style.display = 'none';
                    }
                    // Jika ada gambar lama, biarkan gambar lama tetap tampil.
                }
            });
            // SCRIPT IMAGE PREVIEW END

            // Script Varian
            const container = document.getElementById('variants-container');
            const addButton = document.getElementById('add-variant-btn');
            const template = document.getElementById('variant-template');

            addButton.addEventListener('click', addVariantRow);

            function addVariantRow() {
                const newRow = template.content.cloneNode(true);
                const index = Date.now();
                const html = newRow.firstElementChild.innerHTML.replace(/__INDEX__/g, index);
                const div = document.createElement('div');
                div.className = 'variant-item';
                div.innerHTML = html;
                div.querySelector('.remove-variant-btn').addEventListener('click', function() {
                    this.closest('.variant-item').remove();
                });
                container.appendChild(div);
            }

            container.querySelectorAll('.remove-variant-btn').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.variant-item').remove();
                });
            });

            // Script Select2
            $(document).ready(function() {
                $('#addons').select2({
                    placeholder: "Cari dan pilih add-on...",
                    allowClear: true
                });
            });
        });
    </script>

    {{-- Script Modal Resep (DENGAN INFO STOK) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('recipe-modal');
            const modalTitle = document.getElementById('recipe-modal-title');
            const recipeList = document.getElementById('recipe-list');
            const ingredientSelect = document.getElementById('recipe-ingredient-select');
            const amountInput = document.getElementById('recipe-amount-input');
            const addRecipeBtn = document.getElementById('recipe-add-btn');
            const saveRecipeBtn = document.getElementById('recipe-modal-save');
            const closeRecipeBtn = document.getElementById('recipe-modal-close');

            // ELEMEN BARU UNTUK INFO STOK
            const stockInfo = document.getElementById('recipe-stock-info');

            let currentVariantId = null;
            let allIngredients = [];
            let currentRecipe = [];

            // --- FUNGSI BARU: Menampilkan sisa stok ---
            function updateStockInfo() {
                const selectedOption = ingredientSelect.options[ingredientSelect.selectedIndex];
                if (selectedOption && selectedOption.value) { // Cek value juga agar tidak error saat option kosong
                    // Ambil data 'stock' dan 'unit' dari dataset option
                    stockInfo.innerText =
                        `Stok saat ini: ${selectedOption.dataset.stock} ${selectedOption.dataset.unit}`;
                    stockInfo.style.color = 'var(--text-muted)';
                } else {
                    stockInfo.innerText = '';
                }
            }

            // --- Fungsi untuk membuka modal ---
            async function openRecipeModal(variantId, variantName) {
                currentVariantId = variantId;
                modalTitle.innerText = `Atur Resep: ${variantName}`;
                recipeList.innerHTML = 'Memuat...';
                ingredientSelect.innerHTML = '<option value="">Memuat bahan...</option>'; // Placeholder loading
                currentRecipe = [];

                try {
                    const response = await fetch(`/admin/variants/${variantId}/recipe`);
                    if (!response.ok) throw new Error('Gagal mengambil data resep');

                    const data = await response.json();
                    allIngredients = data.all_ingredients;

                    // Bersihkan dan isi ulang Select
                    ingredientSelect.innerHTML =
                    '<option value="">-- Pilih Bahan Baku --</option>'; // Opsi default
                    allIngredients.forEach(ing => {
                        const option = document.createElement('option');
                        option.value = ing.id;
                        option.text = `${ing.name} (${ing.unit})`;
                        // SIMPAN INFO STOK DI DALAM OPTION
                        option.dataset.stock = ing.stock;
                        option.dataset.unit = ing.unit;
                        ingredientSelect.appendChild(option);
                    });

                    // Muat resep saat ini
                    data.current_recipe.forEach(item => {
                        currentRecipe.push({
                            ingredient_id: item.id,
                            name: item.name,
                            unit: item.unit,
                            quantity_used: item.pivot.quantity_used
                        });
                    });

                    // Tampilkan stok untuk item pertama setelah semua dimuat
                    updateStockInfo();

                    renderRecipeList();
                    modal.style.display = 'flex';
                } catch (error) {
                    console.error(error);
                    alert(error.message);
                }
            }

            // --- Fungsi untuk merender daftar resep di modal ---
            function renderRecipeList() {
                recipeList.innerHTML = '';
                if (currentRecipe.length === 0) {
                    recipeList.innerHTML = '<p style="color: var(--text-muted);">Belum ada resep.</p>';
                    return;
                }
                currentRecipe.forEach((item, index) => {
                    const div = document.createElement('div');
                    div.className = 'recipe-list-item';
                    div.innerHTML = `
                        <span>
                            <strong>${item.name}</strong>: ${item.quantity_used} ${item.unit}
                        </span>
                        <button type="button" class="btn btn-danger btn-sm remove-recipe-item" data-index="${index}">Hapus</button>
                    `;
                    recipeList.appendChild(div);
                });
            }

            // --- Event listener ---
            // Saat dropdown bahan baku diganti, update info stok
            ingredientSelect.addEventListener('change', updateStockInfo);

            addRecipeBtn.addEventListener('click', function() {
                const selectedId = parseInt(ingredientSelect.value);
                const amount = parseFloat(amountInput.value);

                if (!selectedId || isNaN(amount) || amount <= 0) {
                    alert('Pilih bahan baku dan isi jumlah dengan benar.');
                    return;
                }
                if (currentRecipe.some(item => item.ingredient_id === selectedId)) {
                    alert('Bahan baku sudah ada di resep.');
                    return;
                }

                // Cek apakah jumlahnya melebihi stok (hanya untuk peringatan visual)
                const selectedOption = ingredientSelect.options[ingredientSelect.selectedIndex];
                const currentStock = parseFloat(selectedOption.dataset.stock);
                if (amount > currentStock) {
                    stockInfo.innerText =
                        `PERINGATAN: Stok saat ini (${currentStock} ${selectedOption.dataset.unit}) tidak cukup!`;
                    stockInfo.style.color = 'var(--danger)';
                    // Lanjutkan, karena resep boleh melebihi stok yang ada
                } else {
                    updateStockInfo(); // Kembalikan warna normal jika stok cukup
                }

                const ingredient = allIngredients.find(ing => ing.id === selectedId);
                currentRecipe.push({
                    ingredient_id: ingredient.id,
                    name: ingredient.name,
                    unit: ingredient.unit,
                    quantity_used: amount
                });

                renderRecipeList();
                amountInput.value = '';
            });

            recipeList.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-recipe-item')) {
                    const index = parseInt(e.target.dataset.index);
                    currentRecipe.splice(index, 1);
                    renderRecipeList();
                }
            });

            saveRecipeBtn.addEventListener('click', async function() {
                this.disabled = true;
                this.innerText = 'Menyimpan...';
                try {
                    const dataToSave = currentRecipe.map(item => ({
                        ingredient_id: item.ingredient_id,
                        quantity_used: item.quantity_used
                    }));

                    const response = await fetch(`/admin/variants/${currentVariantId}/recipe`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            recipes: dataToSave,
                            _method: 'PUT' // Tambahkan ini karena route update biasanya PUT/PATCH
                        })
                    });

                    const result = await response.json();
                    if (!response.ok) throw new Error(result.message || 'Gagal menyimpan');

                    alert(result.message);
                    closeModal();

                } catch (error) {
                    console.error(error);
                    alert(error.message);
                } finally {
                    this.disabled = false;
                    this.innerText = 'Simpan Resep';
                }
            });

            function closeModal() {
                modal.style.display = 'none';
                currentVariantId = null;
            }
            closeRecipeBtn.addEventListener('click', closeModal);

            document.getElementById('variants-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-atur-resep')) {
                    const variantId = e.target.dataset.variantId;
                    const variantName = e.target.dataset.variantName;
                    openRecipeModal(variantId, variantName);
                }
            });

            // Inisialisasi Select2 pada dropdown resep (karena diisi ulang secara dinamis)
            $(document).ready(function() {
                $('#recipe-ingredient-select').select2({
                    dropdownParent: $('#recipe-form-ingredient'),
                    placeholder: "-- Pilih Bahan Baku --",
                    allowClear: true
                });

                // Panggil ulang Select2 setelah modal dibuka dan select diisi ulang
                modal.addEventListener('transitionend', function() {
                    if (modal.style.display === 'flex') {
                        $('#recipe-ingredient-select').select2('open');
                    }
                });
            });

        });
    </script>
@endpush
