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
use Carbon\Carbon;

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

                        Forms\Components\Textarea::make('shipping_address')
                            ->label('آدرس ارسال')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('shipping_phone')
                            ->label('شماره تماس ارسال')
                            ->tel(),

                        Forms\Components\TextInput::make('postal_code')
                            ->label('کد پستی')
                            ->maxLength(10),

                        Forms\Components\TextInput::make('tracking_code')
                            ->label('کد پیگیری')
                            ->disabled(),

                        Forms\Components\TextInput::make('transaction_id')
                            ->label('شناسه تراکنش')
                            ->disabled(),
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
                    ->formatStateUsing(fn ($state) => self::toJalali($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('tracking_code')
                    ->label('کد پیگیری')
                    ->searchable(),

                Tables\Columns\TextColumn::make('shipping_phone')
                    ->label('تماس')
                    ->searchable(),
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
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    /**
     * Convert Gregorian date to Jalali (Persian) date format
     * Note: This is a simplified version. For accurate conversion, install morilog/jalali package
     */
    protected static function toJalali($date): string
    {
        if (!$date) {
            return '-';
        }

        try {
            $carbon = Carbon::parse($date);
            
            // Convert to Jalali year (approximate - subtract 621-622 years)
            $gregorianYear = (int) $carbon->format('Y');
            $gregorianMonth = (int) $carbon->format('m');
            $gregorianDay = (int) $carbon->format('d');
            
            // Basic conversion (for accurate conversion, use morilog/jalali)
            $jalaliYear = $gregorianYear - 621;
            if ($gregorianMonth <= 3 || ($gregorianMonth == 3 && $gregorianDay < 21)) {
                $jalaliYear -= 1;
            }
            
            // Format: YYYY/MM/DD HH:MM
            return sprintf(
                '%d/%02d/%02d %02d:%02d',
                $jalaliYear,
                $carbon->format('m'),
                $carbon->format('d'),
                $carbon->format('H'),
                $carbon->format('i')
            );
        } catch (\Exception $e) {
            return $date instanceof \DateTimeInterface 
                ? $date->format('Y/m/d H:i') 
                : (string) $date;
        }
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
