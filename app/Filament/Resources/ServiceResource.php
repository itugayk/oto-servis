<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationGroup = 'İçerik';
    protected static ?string $navigationLabel = 'Hizmetler';
    protected static ?string $modelLabel = 'Hizmet';
    protected static ?string $pluralModelLabel = 'Hizmetler';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Hizmet adı')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug (URL)')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\Select::make('icon')
                        ->label('İkon')
                        ->options([
                            'clipboard-document-check' => 'Periyodik bakım',
                            'wrench-screwdriver' => 'Mekanik',
                            'sparkles' => 'Kaporta & boya',
                            'lifebuoy' => 'Lastik',
                            'cpu-chip' => 'Elektronik',
                            'bolt' => 'Enerji / akü',
                            'cog-6-tooth' => 'Genel',
                            'truck' => 'Ağır vasıta',
                        ])
                        ->default('wrench-screwdriver')
                        ->native(false)
                        ->required(),
                    Forms\Components\TextInput::make('summary')
                        ->label('Kısa açıklama')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description')
                        ->label('Detaylı açıklama')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Görsel ve Fiyat')
                ->columns(3)
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Görsel')
                        ->image()
                        ->disk('public')
                        ->directory('services')
                        ->imageEditor()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('price_from')
                        ->label('Başlangıç fiyatı (₺)')
                        ->numeric()
                        ->prefix('₺'),
                    Forms\Components\TextInput::make('duration_min')
                        ->label('Süre (dakika)')
                        ->numeric()
                        ->suffix('dk'),
                    Forms\Components\TextInput::make('sort_order')
                        ->label('Sıra')
                        ->numeric()
                        ->default(0),
                ]),

            Forms\Components\Section::make('İçerik Detayları')
                ->schema([
                    Forms\Components\Repeater::make('features')
                        ->label('Hizmet kapsamı (maddeler)')
                        ->simple(
                            Forms\Components\TextInput::make('item')->required()
                        )
                        ->addActionLabel('Madde ekle')
                        ->defaultItems(3),
                    Forms\Components\Repeater::make('faqs')
                        ->label('Sıkça sorulan sorular')
                        ->schema([
                            Forms\Components\TextInput::make('q')->label('Soru')->required(),
                            Forms\Components\Textarea::make('a')->label('Cevap')->required()->rows(2),
                        ])
                        ->addActionLabel('Soru ekle')
                        ->columns(1)
                        ->defaultItems(0),
                ]),

            Forms\Components\Section::make('Yayın')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_featured')->label('Öne çıkan')->default(false),
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Hizmet')
                    ->description(fn (Service $r) => Str::limit($r->summary, 50))
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('price_from')
                    ->label('Fiyattan')
                    ->money('TRY', 0)
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('duration_min')
                    ->label('Süre')
                    ->suffix(' dk')
                    ->placeholder('—'),
                Tables\Columns\IconColumn::make('is_featured')->label('Öne çıkan')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
