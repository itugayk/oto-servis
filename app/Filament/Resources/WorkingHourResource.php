<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkingHourResource\Pages;
use App\Models\WorkingHour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WorkingHourResource extends Resource
{
    protected static ?string $model = WorkingHour::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Ayarlar';
    protected static ?string $navigationLabel = 'Çalışma Saatleri';
    protected static ?string $modelLabel = 'Çalışma Saati';
    protected static ?string $pluralModelLabel = 'Çalışma Saatleri & Kapasite';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('day')
                        ->label('Gün')
                        ->options(WorkingHour::DAYS)
                        ->required()
                        ->native(false)
                        ->disabledOn('edit'),
                    Forms\Components\Toggle::make('is_open')->label('Açık')->default(true),
                    Forms\Components\TimePicker::make('open_time')->label('Açılış')->seconds(false)->format('H:i'),
                    Forms\Components\TimePicker::make('close_time')->label('Kapanış')->seconds(false)->format('H:i'),
                    Forms\Components\TextInput::make('slot_minutes')
                        ->label('Randevu aralığı (dk)')
                        ->numeric()
                        ->default(60)
                        ->helperText('Her randevu slotunun uzunluğu'),
                    Forms\Components\TextInput::make('capacity')
                        ->label('Slot kapasitesi (araç)')
                        ->numeric()
                        ->default(2)
                        ->helperText('Aynı saatte kabul edilebilecek araç sayısı'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('day')
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('day')
                    ->label('Gün')
                    ->formatStateUsing(fn (int $state) => WorkingHour::DAYS[$state] ?? $state),
                Tables\Columns\IconColumn::make('is_open')->label('Açık')->boolean(),
                Tables\Columns\TextColumn::make('open_time')->label('Açılış'),
                Tables\Columns\TextColumn::make('close_time')->label('Kapanış'),
                Tables\Columns\TextColumn::make('slot_minutes')->label('Aralık')->suffix(' dk'),
                Tables\Columns\TextColumn::make('capacity')->label('Kapasite')->suffix(' araç'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Düzenle'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkingHours::route('/'),
            'create' => Pages\CreateWorkingHour::route('/create'),
            'edit' => Pages\EditWorkingHour::route('/{record}/edit'),
        ];
    }
}
