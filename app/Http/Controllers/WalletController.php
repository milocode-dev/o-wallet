<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
            'type' => 'string|required',
            'nominal' => 'required',
        ]);

        $validatedData['user_id'] = Auth::user()->id;

        Wallet::create($validatedData);

        return redirect('wallet');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $wallet = Wallet::findOrFail($id);

        return view('wallet.show', compact('wallet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $wallet = Wallet::findOrFail($id);

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
        $validatedData = $request->validate([
            'wallet_name' => 'string|required',
            'type' => 'string|required',
            'nominal' => 'required',
        ]);

        $wallet = Wallet::findOrFail($id);
        $wallet->update($validatedData);

        return redirect('wallet');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wallet = Wallet::findOrFail($id);

        $wallet->delete();

        return redirect('wallet');
    }
}
