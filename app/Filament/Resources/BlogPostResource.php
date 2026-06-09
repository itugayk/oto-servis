<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'İçerik';
    protected static ?string $navigationLabel = 'Blog';
    protected static ?string $modelLabel = 'Blog Yazısı';
    protected static ?string $pluralModelLabel = 'Blog Yazıları';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Başlık')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug((string) $state)))
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug (URL)')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('category')
                        ->label('Kategori')
                        ->default('Bakım İpuçları')
                        ->datalist(['Bakım İpuçları', 'Mevsimlik Bakım', 'Lastik', 'Arıza Tespiti', 'Sürüş', 'Kaporta & Boya']),
                    Forms\Components\TextInput::make('author')->label('Yazar')->default('OtoPro Ekibi'),
                    Forms\Components\TextInput::make('read_minutes')->label('Okuma süresi (dk)')->numeric()->default(4),
                    Forms\Components\Textarea::make('excerpt')
                        ->label('Özet')
                        ->required()
                        ->rows(2)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('cover_image')
                        ->label('Kapak görseli')
                        ->image()
                        ->disk('public')
                        ->directory('blog')
                        ->imageEditor()
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('body')
                        ->label('İçerik')
                        ->required()
                        ->columnSpanFull(),
                ]),
            Forms\Components\Section::make('Yayın')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_published')->label('Yayında')->default(true),
                    Forms\Components\DateTimePicker::make('published_at')
                        ->label('Yayın tarihi')
                        ->default(now())
                        ->native(false),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Kapak')
                    ->getStateUsing(fn (BlogPost $r) => media_url($r->cover_image))
                    ->height(40)
                    ->width(64),
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->description(fn (BlogPost $r) => $r->category)
                    ->searchable()
                    ->weight('bold')
                    ->limit(50),
                Tables\Columns\TextColumn::make('published_at')->label('Yayın')->date('d.m.Y')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->label('Yayında')->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')->label('Yayında'),
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
