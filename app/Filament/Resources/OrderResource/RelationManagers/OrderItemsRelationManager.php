<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'آیتم‌های سفارش';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'title')
                    ->label('محصول')
                    ->searchable()
                    ->required()
                    ->disabled(),

                Forms\Components\TextInput::make('quantity')
                    ->label('تعداد')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->disabled(),

                Forms\Components\TextInput::make('unit_price')
                    ->label('قیمت واحد (تومان)')
                    ->numeric()
                    ->required()
                    ->disabled(),

                Forms\Components\TextInput::make('subtotal')
                    ->label('جمع جزء')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false)
                    ->formatStateUsing(fn ($record) => $record ? number_format($record->quantity * $record->unit_price) . ' تومان' : ''),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.title')
            ->columns([
                Tables\Columns\TextColumn::make('product.title')
                    ->label('محصول')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('تعداد')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->label('قیمت واحد')
                    ->formatStateUsing(fn ($state) => number_format($state) . ' تومان')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtotal')
                    ->label('جمع جزء')
                    ->formatStateUsing(fn ($record) => number_format($record->quantity * $record->unit_price) . ' تومان')
                    ->sortable()
                    ->color('success'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('id', 'desc');
    }
}



