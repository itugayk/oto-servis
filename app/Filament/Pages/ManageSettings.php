<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Ayarlar';
    protected static ?string $navigationLabel = 'Site Ayarları';
    protected static ?string $title = 'Site Ayarları';
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    /** Keys managed by this page. */
    protected array $keys = [
        'site_name', 'tagline', 'phone', 'whatsapp', 'email', 'address',
        'working_text', 'map_embed', 'instagram', 'facebook', 'youtube',
        'stat_years', 'stat_vehicles', 'stat_experts', 'stat_warranty',
        'hero_image', 'about_image',
    ];

    public function mount(): void
    {
        $values = [];
        foreach ($this->keys as $key) {
            $values[$key] = Setting::get($key);
        }
        $this->form->fill($values);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Genel')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')->label('Site adı'),
                        TextInput::make('tagline')->label('Slogan'),
                    ]),
                Section::make('İletişim')
                    ->columns(2)
                    ->schema([
                        TextInput::make('phone')->label('Telefon'),
                        TextInput::make('whatsapp')->label('WhatsApp (90555...)'),
                        TextInput::make('email')->label('E-posta')->email(),
                        TextInput::make('working_text')->label('Çalışma saatleri metni'),
                        Textarea::make('address')->label('Adres')->rows(2)->columnSpanFull(),
                        Textarea::make('map_embed')->label('Google Maps embed URL')->rows(2)->columnSpanFull(),
                    ]),
                Section::make('Sosyal Medya')
                    ->columns(3)
                    ->schema([
                        TextInput::make('instagram')->label('Instagram'),
                        TextInput::make('facebook')->label('Facebook'),
                        TextInput::make('youtube')->label('YouTube'),
                    ]),
                Section::make('Sayaçlar (Ana sayfa)')
                    ->columns(4)
                    ->schema([
                        TextInput::make('stat_years')->label('Yıllık tecrübe')->numeric(),
                        TextInput::make('stat_vehicles')->label('Bakılan araç')->numeric(),
                        TextInput::make('stat_experts')->label('Uzman teknisyen')->numeric(),
                        TextInput::make('stat_warranty')->label('Garanti (ay)')->numeric(),
                    ]),
                Section::make('Görseller')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('hero_image')->label('Hero görseli')->image()->disk('public')->directory('site'),
                        FileUpload::make('about_image')->label('Hakkımızda görseli')->image()->disk('public')->directory('site'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            Setting::set($key, is_array($value) ? json_encode($value) : (string) $value);
        }

        Notification::make()->title('Ayarlar kaydedildi')->success()->send();
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Actions\Action::make('save')
                ->label('Kaydet')
                ->submit('save'),
        ];
    }
}
