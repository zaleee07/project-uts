<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'sold_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'sold_at.required' => 'Tanggal penjualan wajib diisi.',
            'items.required' => 'Minimal satu produk harus dipilih untuk transaksi penjualan.',
            'items.min' => 'Minimal satu produk harus dipilih untuk transaksi penjualan.',
            'items.*.product_id.required' => 'Produk wajib dipilih.',
            'items.*.product_id.exists' => 'Produk yang dipilih tidak ditemukan.',
            'items.*.quantity.required' => 'Kuantitas produk wajib diisi.',
            'items.*.quantity.min' => 'Kuantitas minimal adalah 1.',
        ];
    }
}
