<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'İçerik';
    protected static ?string $navigationLabel = 'Yorumlar';
    protected static ?string $modelLabel = 'Yorum';
    protected static ?string $pluralModelLabel = 'Yorumlar';
    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_approved', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')->label('Ad Soyad')->required(),
                    Forms\Components\TextInput::make('vehicle')->label('Araç'),
                    Forms\Components\Select::make('rating')
                        ->label('Puan')
                        ->options([5 => '★★★★★', 4 => '★★★★', 3 => '★★★', 2 => '★★', 1 => '★'])
                        ->default(5)
                        ->native(false)
                        ->required(),
                    Forms\Components\Textarea::make('body')->label('Yorum')->required()->rows(4)->columnSpanFull(),
                    Forms\Components\Toggle::make('is_approved')->label('Onaylı (sitede gösterilsin)')->default(false),
                    Forms\Components\Toggle::make('is_featured')->label('Öne çıkan')->default(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Müşteri')
                    ->description(fn (Testimonial $r) => $r->vehicle)
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Puan')
                    ->formatStateUsing(fn (int $state) => str_repeat('★', $state))
                    ->color('warning'),
                Tables\Columns\TextColumn::make('body')->label('Yorum')->limit(60)->wrap(),
                Tables\Columns\IconColumn::make('is_approved')->label('Onaylı')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->label('Öne çıkan')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')->label('Onay durumu'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Onayla')
                    ->icon('heroicon-m-check-circle')
                    ->color('success')
                    ->visible(fn (Testimonial $r) => ! $r->is_approved)
                    ->action(fn (Testimonial $r) => $r->update(['is_approved' => true])),
                Tables\Actions\EditAction::make()->label('Düzenle'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approveAll')
                        ->label('Seçilenleri onayla')
                        ->icon('heroicon-m-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_approved' => true])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
