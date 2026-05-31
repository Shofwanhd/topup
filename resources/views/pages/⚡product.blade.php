<?php

use Livewire\Component;
use App\Models\Product;
use App\Models\Transaction;

use Midtrans\Config;
use Midtrans\Snap;

new class extends Component {
    public $product;
    public $variation = 0;

    public $name;
    public $email;
    public $phone;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->with('variation', 'category')->first();
        // dd($this->product);
    }

    public function getSubtotalProperty()
    {
        return $this->product->variation->firstWhere('id', $this->variation)?->price ?? 0;
    }

    public function getFeeProperty()
    {
        return $this->subtotal * 0.007; // 0.7%
    }

    public function getTotalProperty()
    {
        return $this->subtotal + $this->fee;
    }

    public function store()
    {
        // dd(request()->all());
        // dd($this->phone);
        $selectedVariation = $this->product->variation->firstWhere('id', $this->variation);

        // dd($selectedVariation);

        // $transaction = [
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'phone' => '+62' . $this->phone,
        //     'product' => $this->product->name,
        //     'variation' => $selectedVariation->variation,
        //     'amount' => $selectedVariation->price,
        // ];

        // dd($transaction);

        $transaction = Transaction::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => '+62' . $this->phone,
            'product' => $this->product->name,
            'variation' => $selectedVariation->variation,
            'amount' => $selectedVariation->price,
        ]);

        return $this->redirect('/transaction/' . $transaction->id_transaksi);

        // Config::$serverKey = config('midtrans.server_key');
        // Config::$isProduction = config('midtrans.is_production');
        // Config::$isSanitized = true;
        // Config::$is3ds = true;

        // $params = [
        //     'transaction_details' => [
        //         'order_id' => $transaction->id_transaksi,
        //         'gross_amount' => $transaction->amount,
        //     ],
        //     'customer_details' => [
        //         'first_name' => $transaction->name,
        //         'email' => $transaction->email,
        //         'phone' => $transaction->phone,
        //     ],
        // ];

        // $snapToken = Snap::getSnapToken($params);
        // $transaction->update([
        //     'snap_token' => $snapToken,
        // ]);

        // $this->dispatch('show-payment', token: $snapToken);
    }
};
?>

<div>
    <div class="pt-4 flex justify-center">

        <div class="grid gap-6 lg:grid-cols-2 items-start">
            {{-- Product Card --}}
            <flux:card class="overflow-hidden p-0">
                <img src="{{ asset($this->product->pic) }}" alt="{{ $this->product->name }}"
                    class="h-40 w-full object-cover">

                <div class="flex gap-4 p-4">

                    <div>
                        <flux:badge color="blue">{{ $this->product->category->name }}</flux:badge>

                        <h2 class="mt-2 text-2xl font-bold">
                            {{ $this->product->name }}
                        </h2>
                    </div>
                </div>

                <div class="grid grid-cols-2">
                    <div class="flex items-center justify-center gap-2 py-3">
                        ⭐ Terpercaya
                    </div>

                    <div class="flex items-center justify-center gap-2 py-3">
                        👍 Garansi
                    </div>
                </div>
            </flux:card>

            {{-- Form --}}
            <form wire:submit="store">
                <div class="space-y-6">
                    <flux:card>
                        <h3 class="mb-4 text-lg font-semibold">
                            Order {{ $this->product->name }}
                        </h3>
                        <div>
                            <flux:input wire:model="name" placeholder="Name" class="flex-1" label="Name" />
                        </div>
                        <div class="pt-4">
                            <flux:input wire:model="email" placeholder="Email" class="flex-1" label="Email" />
                        </div>
                        <div class="pt-4">
                            <flux:input.group label="No HP">
                                <flux:input.group.prefix>+62</flux:input.group.prefix>
                                <flux:input wire:model="phone" placeholder="85xxxxxxx" />
                            </flux:input.group>
                        </div>
                    </flux:card>

                    <flux:card>
                        <h3 class="text-lg font-semibold">
                            Pilih Variasi
                            <span class="text-red-500">*</span>
                        </h3>

                        <flux:radio.group wire:model.live="variation" label="" variant="cards"
                            class="max-sm:flex-col">
                            @foreach ($this->product->variation as $variation)
                                <flux:radio value="{{ $variation->id }}" label="{{ $variation->variation }}"
                                    description="Rp. {{ number_format($variation->price) }}" checked />
                            @endforeach
                        </flux:radio.group>

                        <div class="flex justify-between pt-4">
                            <span>Subtotal</span>
                            <span class="font-semibold">
                                Rp {{ number_format($this->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        {{-- <div class="flex justify-between pt-4">
                            <span>Biaya Layanan</span>
                            <span>
                                Rp {{ number_format($this->fee, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between pt-4">
                            <span>Total</span>
                            <span class="font-semibold">
                                Rp {{ number_format($this->total, 0, ',', '.') }}
                            </span>
                        </div> --}}

                        <div class="pt-4">
                            <flux:button variant="primary" type="submit" id="pay-button" color="blue" class="w-full">
                                Order
                            </flux:button>
                        </div>

                    </flux:card>

                </div>
            </form>

        </div>
        {{-- @script
            <script>
                $wire.on('show-payment', (event) => {

                    snap.pay(event.token);

                });
            </script>
        @endscript --}}

    </div>
</div>
