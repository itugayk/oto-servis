<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Randevular';
    protected static ?string $navigationLabel = 'Randevular';
    protected static ?string $modelLabel = 'Randevu';
    protected static ?string $pluralModelLabel = 'Randevular';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Randevu Bilgileri')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('reference')
                        ->label('Referans No')
                        ->disabled()
                        ->dehydrated(false)
                        ->placeholder('Otomatik oluşturulur'),
                    Forms\Components\Select::make('status')
                        ->label('Durum')
                        ->options(Appointment::STATUSES)
                        ->default('pending')
                        ->required()
                        ->native(false),
                    Forms\Components\Select::make('service_id')
                        ->label('Hizmet')
                        ->relationship('service', 'name')
                        ->searchable()
                        ->preload(),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\DatePicker::make('preferred_date')
                            ->label('Tarih')
                            ->required()
                            ->native(false)
                            ->displayFormat('d.m.Y'),
                        Forms\Components\TextInput::make('preferred_time')
                            ->label('Saat')
                            ->required()
                            ->placeholder('10:00'),
                    ]),
                ]),

            Forms\Components\Section::make('Müşteri')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Ad Soyad')
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label('Telefon')
                        ->tel()
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->label('E-posta')
                        ->email()
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Araç')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('vehicle_make')
                        ->label('Marka')
                        ->required(),
                    Forms\Components\TextInput::make('vehicle_model')
                        ->label('Model')
                        ->required(),
                    Forms\Components\TextInput::make('vehicle_year')
                        ->label('Yıl')
                        ->numeric()
                        ->minValue(1950)
                        ->maxValue((int) date('Y') + 1),
                    Forms\Components\TextInput::make('plate')
                        ->label('Plaka'),
                    Forms\Components\Textarea::make('notes')
                        ->label('Notlar')
                        ->columnSpanFull()
                        ->rows(3),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('preferred_date', 'asc')
            ->columns([
                Tables\Columns\TextColumn::make('reference')
                    ->label('Referans')
                    ->searchable()
                    ->copyable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Müşteri')
                    ->description(fn (Appointment $r) => $r->phone)
                    ->searchable(),
                Tables\Columns\TextColumn::make('vehicle_make')
                    ->label('Araç')
                    ->formatStateUsing(fn (Appointment $r) => trim("{$r->vehicle_make} {$r->vehicle_model}"))
                    ->description(fn (Appointment $r) => $r->plate)
                    ->searchable(['vehicle_make', 'vehicle_model', 'plate']),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Hizmet')
                    ->badge()
                    ->color('gray')
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('preferred_date')
                    ->label('Tarih')
                    ->date('d.m.Y')
                    ->description(fn (Appointment $r) => $r->preferred_time)
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => Appointment::STATUSES[$state] ?? $state)
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'info',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Durum')
                    ->options(Appointment::STATUSES),
                Tables\Filters\SelectFilter::make('service_id')
                    ->label('Hizmet')
                    ->relationship('service', 'name'),
            ])
            ->actions([
                Tables\Actions\Action::make('advance')
                    ->label('Durum')
                    ->icon('heroicon-m-arrow-path')
                    ->color('primary')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Yeni durum')
                            ->options(Appointment::STATUSES)
                            ->required()
                            ->native(false),
                    ])
                    ->fillForm(fn (Appointment $r) => ['status' => $r->status])
                    ->action(fn (Appointment $r, array $data) => $r->update(['status' => $data['status']])),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
