<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data dompet milik user yang sedang login
        $wallets = Wallet::where('user_id', auth()->id())->get();

        return view('wallet.index', compact('user', 'wallets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $walletType = [
            'tunai' => 'Tunai',
            'bank' => 'Bank',
            'e-wallet' => 'E-wallet',
        ];

        return view('wallet.create', compact('walletType'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'wallet_name' => 'string|required',
            'type' => 'string|required|in:tunai,bank,e-wallet',
            'nominal' => 'required|numeric|min:0',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        Wallet::create($validatedData);

        return redirect()->route('wallet.index')->with('success', 'Dompet berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'Saldo ditolak! Anda bukan user yang sah.');
        }

        $incomeCategories = Category::where('user_id', auth()->id())->where('type', 'income')->get();
        $expenseCategories = Category::where('user_id', auth()->id())->where('type', 'expense')->get();

        $allWallet = Wallet::where('user_id', auth()->id())->where('id', '!=', $wallet->id)->get();

        $transactions = $wallet->transactions()
            ->with('category')
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->get();

        return view('wallet.show', compact('wallet', 'incomeCategories', 'expenseCategories', 'allWallet', 'transactions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan pemilik dompet ini.');
        }

        $walletType = [
            'tunai' => 'Tunai',
            'bank' => 'Bank',
            'e-wallet' => 'E-wallet',
        ];

        return view('wallet.edit', compact('wallet', 'walletType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan pemilik dompet ini.');
        }

        $validatedData = $request->validate([
            'wallet_name' => 'string|required',
            'type' => 'string|required|in:tunai,bank,e-wallet',
            'nominal' => 'required|numeric|min:0',
        ]);

        $wallet->update($validatedData);

        return redirect()->route('wallet.index')->with('success', 'Dompet berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wallet = Wallet::findOrFail($id);

        if ($wallet->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak! Anda bukan pemilik dompet ini.');
        }

        $wallet->delete();

        return redirect()->route('wallet.index')->with('success', 'Dompet berhasil dihapus.');
    }
}
