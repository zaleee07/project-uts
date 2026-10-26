<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchased_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Pemasok (supplier) wajib dipilih.',
            'supplier_id.exists' => 'Pemasok yang dipilih tidak ditemukan.',
            'purchased_at.required' => 'Tanggal pembelian wajib diisi.',
            'items.required' => 'Minimal satu item produk harus ditambahkan.',
            'items.min' => 'Minimal satu item produk harus ditambahkan.',
            'items.*.product_id.required' => 'Produk wajib dipilih.',
            'items.*.product_id.exists' => 'Produk tidak valid.',
            'items.*.quantity.required' => 'Kuantitas produk wajib diisi.',
            'items.*.quantity.min' => 'Kuantitas minimal adalah 1.',
            'items.*.unit_cost.required' => 'Harga beli satuan wajib diisi.',
            'items.*.unit_cost.min' => 'Harga beli satuan tidak boleh negatif.',
        ];
    }
}
