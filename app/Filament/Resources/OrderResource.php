<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteBulkAction;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

// v1 outline (built-in)
protected static ?string $navigationIcon  = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'الطلبات';
    protected static ?string $navigationGroup = 'المبيعات';
    protected static ?int    $navigationSort  = 3;

 public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('تفاصيل المنتجات')
                ->schema([
                    Repeater::make('details')
                        ->relationship('details')
                        ->schema([
                            TextInput::make('product_data->name')
                                ->label('المنتج')
                                ->disabled(),
                            TextInput::make('quantity')
                                ->label('الكمية')
                                ->disabled(),
                            TextInput::make('price')
                                ->label('سعر الوحدة')
                                ->disabled(),
                        ])
                        ->columns(3)
                        ->disableItemCreation()   // ← here
                        ->disableItemDeletion()   // ← and here
                        ->disableItemMovement(),  // ← and here
                ]),
            // …
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('name')->label('العميل')->sortable()->searchable(),
                TextColumn::make('email')->label('البريد')->sortable(),
                TextColumn::make('total')->label('الإجمالي')->money('EGP')->sortable(),
                TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->actions([
                ViewAction::make()->label('تفاصيل'),
            ])
            ->bulkActions([
                DeleteBulkAction::make()->label('حذف محدد'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view'  => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
