@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@push('styles')
    <style>
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

        .image-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
            padding: 5px;
            display: none;
            /* Sembunyikan jika tidak ada gambar */
        }
    </style>
@endpush

@section('content')
    <div class="page-header">
        <h1>Tambah Produk Baru</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                    placeholder="cth: Kopi Susu Gula Aren">
                @error('name')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror


            </div>

            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror


            </div>

            {{-- INPUT GAMBAR BARU --}}
            <div class="form-group">
                <label for="image">Gambar Produk (Opsional)</label>
                {{-- Pastikan ini bertipe file dan memiliki atribut accept --}}
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                {{-- Elemen untuk menampilkan preview gambar --}}
                <img id="image-preview" src="#" alt="Preview" class="image-preview">
                @error('image')
                    <div style="color: var(--danger); margin-top: 5px;">{{ $message }}</div>
                @enderror

            </div>
            {{-- AKHIR INPUT GAMBAR BARU --}}




            <hr style="margin: 25px 0;">

            <h3>Varian Harga</h3>
            <div id="variants-container">
                @if (old('variants'))
                    @foreach (old('variants') as $index => $variant)
                        <div class="variant-item">
                            <div class="form-group variant-name">
                                <label>Nama Varian</label>
                                <input type="text" name="variants[{{ $index }}][name]" class="form-control"
                                    placeholder="cth: Regular" value="{{ $variant['name'] }}">
                            </div>
                            <div class="form-group variant-price">
                                <label>Harga (Rp)</label>
                                <input type="number" name="variants[{{ $index }}][price]" class="form-control"
                                    placeholder="cth: 15000" value="{{ $variant['price'] }}">
                            </div>
                            <div class="variant-action">
                                <button type="button" class="btn remove-variant-btn">Hapus</button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <button type="button" id="add-variant-btn" class="btn btn-secondary"
                style="background-color: var(--secondary-light); color: var(--text-color);">
                + Tambah Varian
            </button>

            {{-- TAMBAHAN CATATAN UNTUK RESEP --}}
            <small style="color: var(--text-muted); display: block; margin-top: 10px;">
                Anda bisa mengatur resep (potong stok) untuk setiap varian setelah produk ini disimpan.
            </small>

            @error('variants')
                <div style="color: var(--danger); margin-top: 15px;">{{ $message }} (Minimal harus ada 1 varian)</div>
            @enderror



            <hr style="margin: 25px 0;">

            <h3>Pilihan Add-On</h3>
            <div class="form-group">
                <label for="addons">Pilih add-on yang tersedia untuk produk ini (Opsional):</label>
                <select name="addons[]" id="addons" class="form-control" multiple="multiple">
                    @foreach ($addons as $addon)
                        <option value="{{ $addon->id }}"
                            {{ is_array(old('addons')) && in_array($addon->id, old('addons')) ? 'selected' : '' }}>
                            {{ $addon->name }} (+ Rp
                            {{ number_format($addon->price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-right" style="margin-top: 30px;">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"
                    style="background-color: var(--secondary-light); color: var(--text-color);">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
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
            </div>
        </div>
    </template>

@endsection

@push('scripts')
    <script>
        // Script untuk Varian
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('variants-container');
            const addButton = document.getElementById('add-variant-btn');
            const template = document.getElementById('variant-template');

            // Tambahan untuk Image Preview
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
                    imagePreview.style.display = 'none';
                    imagePreview.src = '#';
                }
            });

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

            @if (!old('variants'))
                addVariantRow();
            @endif

            // Script untuk Select2 Addon
            $(document).ready(function() {
                $('#addons').select2({
                    placeholder: "Cari dan pilih add-on...",
                    allowClear: true
                });
            });
        });
    </script>
@endpush
