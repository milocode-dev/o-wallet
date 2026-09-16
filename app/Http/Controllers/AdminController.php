<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index() {
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $totalWallets = Wallet::count();
        $totalBalance = Wallet::sum('nominal');
        $todayTransactionsCount = Transaction::whereDate('transaction_date', today())->count();

        $recentTransactions = Transaction::with(['user', 'wallet', 'category'])
            ->orderByDesc('transaction_date')
            ->orderByDesc('id')
            ->take(10)
            ->get();

        return view('admin.index', compact(
            'totalUsers',
            'activeUsers',
            'totalWallets',
            'totalBalance',
            'todayTransactionsCount',
            'recentTransactions'
        ));
    }

    /**
     * Daftar seluruh user + status aktif, jumlah dompet, dan total saldo mereka.
     */
    public function users() {
        $users = User::withCount(['wallets', 'transactions'])
            ->withSum('wallets as total_balance', 'nominal')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.users', compact('users'));
    }

    /**
     * Aktifkan / nonaktifkan satu user. Admin tidak boleh menonaktifkan akunnya sendiri.
     */
    public function toggleActive(User $user) {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menonaktifkan akun Anda sendiri.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $message = $user->is_active
            ? "Akun {$user->name} telah diaktifkan kembali."
            : "Akun {$user->name} telah dinonaktifkan.";

        return back()->with('success', $message);
    }
}
