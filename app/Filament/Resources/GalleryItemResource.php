<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryItemResource\Pages;
use App\Models\GalleryItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryItemResource extends Resource
{
    protected static ?string $model = GalleryItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'İçerik';
    protected static ?string $navigationLabel = 'Galeri';
    protected static ?string $modelLabel = 'Galeri Görseli';
    protected static ?string $pluralModelLabel = 'Galeri';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Başlık')->required(),
                    Forms\Components\TextInput::make('category')
                        ->label('Kategori')
                        ->default('Atölye')
                        ->datalist(['Atölye', 'Mekanik', 'Kaporta', 'Araçlar']),
                    Forms\Components\FileUpload::make('image')
                        ->label('Görsel')
                        ->image()
                        ->disk('public')
                        ->directory('gallery')
                        ->imageEditor()
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Görsel')
                    ->getStateUsing(fn (GalleryItem $r) => media_url($r->image))
                    ->height(48)
                    ->width(72),
                Tables\Columns\TextColumn::make('title')->label('Başlık')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('category')->label('Kategori')->badge()->color('gray'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(['Atölye' => 'Atölye', 'Mekanik' => 'Mekanik', 'Kaporta' => 'Kaporta', 'Araçlar' => 'Araçlar']),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Düzenle'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryItems::route('/'),
            'create' => Pages\CreateGalleryItem::route('/create'),
            'edit' => Pages\EditGalleryItem::route('/{record}/edit'),
        ];
    }
}
