<?php

use Livewire\Component;
use App\Models\Transaction;

use Midtrans\Config;
use Midtrans\Snap;

new class extends Component {
    public $transaction;

    public function mount($id_transaksi)
    {
        $this->transaction = Transaction::where('id_transaksi', $id_transaksi)->first();
        //dd($this->transaction->id_transaksi);
    }

    public function payment()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $this->transaction->id_transaksi,
                'gross_amount' => $this->transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $this->transaction->name,
                'email' => $this->transaction->email,
                'phone' => $this->transaction->phone,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);
        Transaction::where('id_transaksi', $this->transaction->id_transaksi)->update([
            'snap_token' => $snapToken,
        ]);

        $this->dispatch('show-payment', token: $snapToken);
    }
};
?>

<div>
    <div class="flex justify-center">
        <flux:card class="space-y-6 max-w-lg w-full mt-4">
            <div>
                <div class="flex justify-between pt-4">
                    <h3 class="mb-4 text-lg font-semibold">
                        {{ $this->transaction->id_transaksi }}
                    </h3>

                    @if ($this->transaction->status_payment == 'paid')
                        <flux:badge color="green">{{ $this->transaction->status_payment }}</flux:badge>
                    @else
                        <flux:badge color="red">{{ $this->transaction->status_payment }}</flux:badge>
                    @endif
                </div>
                <h3 class="mb-4 text-sm">
                    <span class="text-red-500">*</span> Save your Order ID
                </h3>


                <flux:heading>Detail Pembeli</flux:heading>
                <div class="flex justify-between pt-4">
                    <span>Nama</span>
                    <span class="">
                        {{ $this->transaction->name }}
                    </span>
                </div>
                <div class="flex justify-between pt-4">
                    <span>Email</span>
                    <span class="">
                        {{ $this->transaction->email }}
                    </span>
                </div>
                <div class="flex justify-between pt-4">
                    <span>No HP</span>
                    <span class="">
                        {{ $this->transaction->phone }}
                    </span>
                </div>
                <div class="flex justify-between pt-4">
                    <span>Status Pesanan</span>
                    <span class="">
                        @if ($this->transaction->status == 'success')
                            <flux:badge color="green">{{ $this->transaction->status }}</flux:badge>
                        @elseif ($this->transaction->status == 'processing')
                            <flux:badge color="yellow">{{ $this->transaction->status }}</flux:badge>
                        @else
                            <flux:badge color="red">{{ $this->transaction->status }}</flux:badge>
                        @endif
                    </span>
                </div>

            </div>



        </flux:card>
    </div>
    <div class="flex justify-center">
        <flux:card class="space-y-6 max-w-lg w-full mt-4">
            <div>
                <div class="flex justify-between pt-4">
                    <h1 class="mb-4 text-lg font-semibold">
                        Your Order :
                    </h1>
                </div>
                <div class="flex justify-between pt-4">
                    <h1 class="mb-4 text-lg">
                        {{ $this->transaction->message }}
                    </h1>
                </div>

            </div>
        </flux:card>
    </div>
    @if ($this->transaction->status_payment == 'unpaid')
        <div class="flex justify-center">
            <div class="space-y-6 max-w-lg w-full mt-4">
                <div class="pt-4">
                    <flux:button variant="primary" wire:click="payment" id="pay-button" color="blue" class="w-full">
                        Bayar Pesanan
                    </flux:button>
                </div>
            </div>
        </div>
    @endif

    @script
        <script>
            $wire.on('show-payment', (event) => {

                snap.pay(event.token);

            });
        </script>
    @endscript

</div>
