<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('مشتری')
                            ->searchable()
                            ->placeholder('انتخاب مشتری'),

                        Forms\Components\TextInput::make('total_amount')
                            ->label('مبلغ کل (تومان)')
                            ->numeric()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('وضعیت سفارش')
                            ->options([
                                'new' => 'جدید',
                                'pending' => 'در انتظار بررسی',
                                'shipped' => 'ارسال شده',
                                'delivered' => 'تحویل داده شده',
                                'cancelled' => 'لغو شده',
                            ])
                            ->default('new')
                            ->required(),

                        Forms\Components\Select::make('payment_status')
                            ->label('وضعیت پرداخت')
                            ->options([
                                'pending' => 'در انتظار پرداخت',
                                'paid' => 'پرداخت موفق',
                                'failed' => 'پرداخت ناموفق',
                                'refunded' => 'مرجوع شده',
                            ])
                            ->default('pending')
                            ->required(),

                        Forms\Components\Textarea::make('description')
                            ->label('توضیحات سفارش')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('شماره سفارش')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('مشتری')->searchable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('مبلغ کل')
                    ->formatStateUsing(fn($state) => number_format($state) . ' تومان')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\SelectColumn::make('status')
                    ->label('وضعیت سفارش')
                    ->options([
                        'new' => 'جدید',
                        'pending' => 'در انتظار',
                        'shipped' => 'ارسال شده',
                        'delivered' => 'تحویل شده',
                        'cancelled' => 'لغو شده',
                    ]),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('وضعیت پرداخت')
                    ->colors([
                        'danger' => 'failed',
                        'warning' => 'pending',
                        'success' => 'paid',
                        'primary' => 'refunded',
                    ])
                    ->icons([
                        'heroicon-m-x-circle' => 'failed',
                        'heroicon-m-clock' => 'pending',
                        'heroicon-m-check-circle' => 'paid',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ثبت')
                    ->dateTime('Y/m/d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'جدید',
                        'shipped' => 'ارسال شده',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
