<?php

use Livewire\Component;
use App\Models\Transaction;

new class extends Component {
    public $transaction;
    public $transactionStatus = '';
    public $transactionAvailable = '';

    public function find()
    {
        // dd($this->transaction);

        $transaksi = Transaction::where('id_transaksi', $this->transaction)->first();

        if (!$transaksi) {
            $this->transactionStatus = 'Transaksi tidak ditemukan. Pastikan kode transaksi yang Anda masukkan sudah benar atau hubungi admin jika mengalami kendala.';
            return;
        }

        return $this->redirect('/transaction/' . $transaksi->id_transaksi);
    }
};
?>

<div>
    {{-- Order your soul. Reduce your wants. - Augustine --}}
    <div class="flex justify-center">
        <flux:card class="space-y-6 max-w-lg w-full mt-4">
            <div>
                <flux:heading size="lg">Cek Transaksi</flux:heading>
                <flux:text class="mt-2">Masukkan nomor transaksi</flux:text>
            </div>

            <form wire:submit="find">
                <div class="space-y-6">
                    <flux:input wire:model="transaction" placeholder="INV000000" class="flex-1" />
                </div>
                <div class="space-y-2 mt-4">
                    <flux:button variant="primary" class="w-full" type="submit">Cari Transaksi</flux:button>
                </div>
            </form>
            @if ($transactionStatus)
                <div class="mt-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                    {{ $transactionStatus }}
                </div>
            @endif
        </flux:card>
    </div>
</div>
