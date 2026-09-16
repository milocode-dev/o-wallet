<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * Dipakai untuk 2 skenario dari halaman wallet.show: "Tambah Saldo" (type=income)
     * dan "Bayar" (type=expense).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string|required',
            'type' => 'string|required|in:income,expense',
            'nominal' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'string|nullable',
            'category_id' => 'required|exists:categories,id',
            'wallet_id' => 'required|exists:wallets,id',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        $wallet = Wallet::findOrFail($validatedData['wallet_id']);

        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'Saldo ditolak! Anda bukan user yang sah.');
        }

        $category = Category::findOrFail($validatedData['category_id']);

        if ($category->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Kategori bukan milik Anda.');
        }

        if ($category->type !== $validatedData['type']) {
            return back()->withErrors(['category_id' => 'Kategori tidak sesuai dengan jenis transaksi.'])->withInput();
        }

        // Bug lama: method ini dulu SELALU menambah saldo tanpa peduli tipe transaksi,
        // jadi transaksi expense (Bayar) malah menambah saldo dompet, bukan mengurangi.
        if ($validatedData['type'] === 'expense' && $wallet->nominal < $validatedData['nominal']) {
            return back()->withErrors(['nominal' => 'Saldo dompet tidak mencukupi untuk pembayaran ini.'])->withInput();
        }

        DB::transaction(function () use ($wallet, $validatedData) {
            Transaction::create($validatedData);

            if ($validatedData['type'] === 'income') {
                $wallet->update(['nominal' => $wallet->nominal + $validatedData['nominal']]);
            } else {
                $wallet->update(['nominal' => $wallet->nominal - $validatedData['nominal']]);
            }
        });

        $message = $validatedData['type'] === 'income' ? 'Saldo berhasil ditambahkan.' : 'Pembayaran berhasil dicatat.';

        return redirect()->route('wallet.show', $wallet->id)->with('success', $message);
    }

    public function transfer(Request $request) {
        $validatedData = $request->validate([
            'name' => 'string|required',
            'type' => 'string|required',
            'nominal' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'string|nullable',
            'wallet_id' => 'required|exists:wallets,id',
            'to_wallet_id' => 'required|exists:wallets,id|different:wallet_id',
        ], [
            'to_wallet_id.different' => 'Dompet tujuan tidak boleh sama dengan dompet asal.',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        $wallet = Wallet::findOrFail($validatedData['wallet_id']);
        $destination_wallet = Wallet::findOrFail($validatedData['to_wallet_id']);

        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'Saldo ditolak! Anda bukan user yang sah.');
        } else if ($destination_wallet->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan user yang sah.');
        }

        if ($wallet->nominal < $validatedData['nominal']) {
            return back()->withErrors(['nominal' => 'Saldo dompet tidak mencukupi untuk transfer ini.'])->withInput();
        }

        $dataDasar = [
            'name' => $validatedData['name'],
            'nominal' => $validatedData['nominal'],
            'transaction_date' => $validatedData['transaction_date'],
            'description' => $validatedData['description'],
            'user_id' => Auth::id(),
            'category_id' => null,
        ];

        $dataRow1 = $dataDasar + [
            'wallet_id' => $wallet->id,
            'type' => 'expense',
        ];

        $dataRow2 = $dataDasar + [
            'wallet_id' => $destination_wallet->id,
            'type' => 'income',
        ];

        DB::transaction(function () use ($wallet, $dataRow1, $dataRow2, $destination_wallet) {
            $createData1 = Transaction::create($dataRow1);
            $createData2 = Transaction::create($dataRow2);

            $createData1->update([
                'transfer_pair_id' => $createData2->id,
            ]);

            $createData2->update([
                'transfer_pair_id' => $createData1->id,
            ]);

            $destination_wallet->update([
                'nominal' => $destination_wallet->nominal + $dataRow2['nominal'],
            ]);

            $wallet->update([
                'nominal' => $wallet->nominal - $dataRow1['nominal'],
            ]);
        });

        return redirect()->route('wallet.show', $wallet->id)->with('success', 'Transfer berhasil dilakukan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan user yang sah.');
        }

        if ($transaction->transfer_pair_id !== null) {
            abort(403, 'Transaksi transfer tidak bisa diedit langsung. Hapus dan buat ulang.');
        }

        $categories = Category::where('user_id', Auth::id())
            ->where('type', $transaction->type)
            ->get();

        return view('transaction.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan user yang sah.');
        }

        if ($transaction->transfer_pair_id !== null) {
            abort(403, 'Transaksi transfer tidak bisa diedit langsung. Hapus dan buat ulang.');
        }

        $validatedData = $request->validate([
            'name' => 'string|required',
            'nominal' => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        try {
            DB::transaction(function () use ($transaction, $validatedData) {
                // Batalkan efek lama transaksi ini ke balance wallet
                $this->reverseBalance($transaction);

                // Cek saldo cukup sebelum menerapkan nominal baru (khusus expense)
                $walletAfterReverse = Wallet::findOrFail($transaction->wallet_id);
                if ($transaction->type === 'expense' && $walletAfterReverse->nominal < $validatedData['nominal']) {
                    throw new \RuntimeException('insufficient_balance');
                }

                // Update data transaksinya
                $transaction->update($validatedData);

                // Terapkan efek baru (pakai data yang udah ke-update) ke balance wallet
                $this->applyBalance($transaction->fresh());
            });
        } catch (\RuntimeException $e) {
            if ($e->getMessage() === 'insufficient_balance') {
                return back()->withErrors(['nominal' => 'Saldo dompet tidak mencukupi untuk perubahan nominal ini.'])->withInput();
            }
            throw $e;
        }

        return redirect()->route('wallet.show', $transaction->wallet_id)->with('success', 'Transaksi berhasil diperbarui.');
    }

        // Helper: membatalkan efek transaksi ke balance (dipakai pas destroy & sebelum update)
    private function reverseBalance(Transaction $transaction)
    {
        $wallet = Wallet::findOrFail($transaction->wallet_id);

        if ($transaction->type === 'income') {
            $wallet->update(['nominal' => $wallet->nominal - $transaction->nominal]);
        } else {
            // expense (termasuk expense dari transfer)
            $wallet->update(['nominal' => $wallet->nominal + $transaction->nominal]);
        }
    }

    // Helper: menerapkan efek transaksi ke balance (dipakai setelah update dengan data baru)
    private function applyBalance(Transaction $transaction)
    {
        $wallet = Wallet::findOrFail($transaction->wallet_id);

        if ($transaction->type === 'income') {
            $wallet->update(['nominal' => $wallet->nominal + $transaction->nominal]);
        } else {
            $wallet->update(['nominal' => $wallet->nominal - $transaction->nominal]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan user yang sah.');
        }

        DB::transaction(function () use ($transaction) {
            if ($transaction->transfer_pair_id !== null) {
                // Transfer: ada 2 row yang perlu di-reverse balance-nya dan dihapus bareng
                $pair = Transaction::findOrFail($transaction->transfer_pair_id);

                $this->reverseBalance($transaction);
                $this->reverseBalance($pair);

                $transaction->delete();
                $pair->delete();
            } else {
                // Transaksi biasa (income/expense)
                $this->reverseBalance($transaction);
                $transaction->delete();
            }
        });

        return redirect()->route('wallet.show', $transaction->wallet_id)->with('success', 'Transaksi berhasil dihapus.');
    }
}
