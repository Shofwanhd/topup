<?php

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

new class extends Component {
    public $product;
    public $category;

    public function mount()
    {
        $this->product = Product::with('category', 'variation')->where('is_active', 1)->get();
        $this->category = Category::all();
    }
};
?>

<div>
    <div class="pt-4">
        <flux:heading size="xl">Category</flux:heading>
        <div class="grid grid-cols-4 gap-4 pt-4">
            @foreach ($category as $item)
                <flux:card size="sm" class="hover:bg-zinc-50 dark:hover:bg-zinc-700">
                    <flux:heading class="flex items-center gap-2">{{ $item->name }}
                    </flux:heading>
                </flux:card>
            @endforeach
        </div>
    </div>
    <div class="pt-4">
        <flux:heading size="xl" class="">Produk</flux:heading>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5 pt-4">
            @foreach ($product as $item)
                <a href="/product/{{ $item->slug }}">
                    <flux:card class="overflow-hidden hover:bg-zinc-50 dark:hover:bg-zinc-700">
                        <img src="{{ asset($item->pic) }}" alt="{{ $item->name }}" class="h-48 w-full object-cover">

                        <div class="space-y-3 p-3">
                            <div>
                                <h3 class="text-lg font-semibold">
                                    {{ $item->name }}
                                </h3>

                                <h3 class="text-md">
                                    {{ $item->category->name }}
                                </h3>

                                <p class="text-sm text-zinc-500 pt-4">
                                    {{ $item->description }}
                                </p>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-md font-semibold">
                                    @php
                                        $minPrice = $item->variation->min('price');
                                        $maxPrice = $item->variation->max('price');
                                    @endphp
                                    @if ($minPrice == $maxPrice)
                                        Rp{{ number_format($minPrice, 0, ',', '.') }}
                                    @else
                                        Rp{{ number_format($minPrice, 0, ',', '.') }}
                                        -
                                        Rp{{ number_format($maxPrice, 0, ',', '.') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </flux:card>
                </a>
            @endforeach
        </div>
    </div>
    <div class="py-4">
        <flux:separator />
    </div>

    <div class="pt-4">
        <flux:heading size="xl">How to Order</flux:heading>
        <div class="grid grid-cols-4 gap-4 pt-4">
            <flux:timeline size="lg">
                <flux:timeline.item>
                    <flux:timeline.indicator>
                        <flux:icon.cursor-arrow-rays variant="micro" />
                    </flux:timeline.indicator>

                    <flux:timeline.content>
                        <flux:heading>Select Product</flux:heading>
                        <flux:text>Pilih produk yang akan dibeli</flux:text>
                    </flux:timeline.content>
                </flux:timeline.item>
                <flux:timeline.item>
                    <flux:timeline.indicator><flux:icon.shopping-cart variant="micro" /></flux:timeline.indicator>

                    <flux:timeline.content>
                        <flux:heading>Order</flux:heading>
                        <flux:text>Isi form dan klik order</flux:text>
                    </flux:timeline.content>
                </flux:timeline.item>
                <flux:timeline.item>
                    <flux:timeline.indicator><flux:icon.credit-card variant="micro" /></flux:timeline.indicator>

                    <flux:timeline.content>
                        <flux:heading>Payment</flux:heading>
                        <flux:text>Lakukan pembayaran untuk transaksi</flux:text>
                    </flux:timeline.content>
                </flux:timeline.item>
                <flux:timeline.item>
                    <flux:timeline.indicator>
                        <flux:icon.check variant="micro" />
                    </flux:timeline.indicator>

                    <flux:timeline.content>
                        <flux:heading>Success</flux:heading>
                        <flux:text>Informasi pembelian kami kirimkan pada halaman <a href="/transaction"
                                class="font-bold underline">Transaksi</a>
                        </flux:text>
                    </flux:timeline.content>
                </flux:timeline.item>

                <!-- ... -->
            </flux:timeline>
        </div>
    </div>
    <div class="pt-4 grid grid-cols-2 gap-4">
        <div class="flex items-center justify-center min-h-[300px]">
            <h1 class="text-5xl">FAQ</h1>
        </div>
        <div class="">
            <flux:accordion>
                <flux:accordion.item>
                    <flux:accordion.heading>Cara Melakukan Pembelian?</flux:accordion.heading>

                    <flux:accordion.content>
                        Untuk melakukan pembelian bisa melakukan step by step pada section How to Order.
                    </flux:accordion.content>
                </flux:accordion.item>

                <flux:accordion.item>
                    <flux:accordion.heading>Bagaimana cara melihat status order?</flux:accordion.heading>

                    <flux:accordion.content>
                        Status order dapat dilihat pada menu Transaksi dengan memasukan nomor transaksi.
                    </flux:accordion.content>
                </flux:accordion.item>

                <flux:accordion.item>
                    <flux:accordion.heading>Metode pembayaran yang digunakan?</flux:accordion.heading>

                    <flux:accordion.content>
                        Untuk metode pembayaran menggunakan payment gateway dengan berbagai pilihan tipe pembayaran.
                    </flux:accordion.content>
                </flux:accordion.item>
            </flux:accordion>
        </div>
    </div>



</div>
