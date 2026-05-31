<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_transaksi'),
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone'),
                TextEntry::make('product'),
                TextEntry::make('variation'),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('status_payment')
                    ->badge(),
                TextEntry::make('payment_method')
                    ->placeholder('-'),
                TextEntry::make('midtrans_order_id')
                    ->placeholder('-'),
                TextEntry::make('midtrans_transaction_id')
                    ->placeholder('-'),
                TextEntry::make('message')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
