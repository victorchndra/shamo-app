<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function all(Request $request) {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        if($id) {
            $transaction = Transaction::with(['items.product'])->find($id);

            if($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    "Data transaksi berhasil diambil"
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    "Data transaksi tidak ada",
                    404
                );
            }
        }

        $transaction = Transaction::with(['items.product'])->where('users_id', Auth::user()->id);

        if($status) {
            $transaction->where('status', $status);
        }

        return ResponseFormatter::success(
            $transaction->paginate($limit),
            "Data list transaksi berhasil diambil"
        );
    }

    public function checkout(Request $request) {
        // Validasi request
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id', //exists:[tableName],[columnID]
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING,SUCCESS,CANCELLED,FAILED,SHIPPING,SHIPPED', //in : cuma utk value itu saja
        ]);

        // Insert data ke tabel transaction (except items), ini akan membentuk id sekali transaksi
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status,
        ]);

        // Insert data item ke tabel transaction item, ini artinya sekali transaksi terdapat beberapa produk (foreach) dan qty
        foreach ($request->items as $product) {
            TransactionItem::create([
                'users_id' => Auth::user()->id,
                'products_id' => $product['id'],
                'transactions_id' => $transaction->id, //$transaction->id dipanggil dari transaction yang baru saja di create di function ini
                'quantity' => $product['quantity'],
            ]);
        }

        return ResponseFormatter::success(
            $transaction->load('items.product'), //load digunakan untuk memanggil relasi data yang baru saja dibuat, karena data yang baru dibuat belum ke update sama relasinya ketika dipanggil.
            "Transaksi berhasil"
        );
    }
}
