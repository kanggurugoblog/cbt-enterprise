<?php

namespace App\Filament\Resources\QuestionBanks\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class QuestionBankForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Blok 1: Informasi Utama Paket Soal
                Card::make()->schema([
                    TextInput::make('name')
                        ->label('Nama Paket Soal')
                        ->required()
                        ->placeholder('Contoh: Penilaian Harian Matematika Semester 1'),

                    Select::make('subject_id')
                        ->label('Mata Pelajaran')
                        ->relationship('subject', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('user_id')
                        ->label('Guru Pembuat')
                        ->relationship('user', 'name')
                        ->default(auth()->id())
                        ->required(),
                ])->columns(1),

                // Blok 2: Repeater Butir Soal & Pilihan Jawaban Bertingkat
                Card::make()->schema([
                    Section::make('Butir Soal & Pilihan Jawaban')
                        ->description('Tambahkan soal dan kunci jawaban di bawah ini.')
                        ->schema([
                            Repeater::make('questions')
                                ->relationship('questions') // Terhubung ke model QuestionBank
                                ->orderColumn('order')
                                ->schema([
                                    RichEditor::make('question_text')
                                        ->label('Teks Soal (Mendukung Gambar & Rumus)')
                                        ->required()
                                        ->columnSpanFull(),

                                    Select::make('type')
                                        ->label('Tipe Soal')
                                        ->options([
                                            'pilihan_ganda' => 'Pilihan Ganda',
                                            'esai' => 'Esai / Uraian',
                                        ])
                                        ->default('pilihan_ganda')
                                        ->live()
                                        ->required(),

                                    FileUpload::make('image_path')
                                        ->label('Upload Gambar Soal (Opsional)')
                                        ->image()
                                        ->directory('soal-images'),

                                    // Sub-Repeater Pilihan Jawaban (Muncul jika tipe = pilihan_ganda)
                                    Repeater::make('options')
                                        ->relationship('options') // Terhubung ke model Question
                                        ->label('Pilihan Jawaban (A-E)')
                                        ->schema([
                                            TextInput::make('option_text')
                                                ->label('Teks Opsi')
                                                ->required(),

                                            Toggle::make('is_correct')
                                                ->label('Kunci Jawaban')
                                                ->onIcon('heroicon-m-check')
                                                ->offIcon('heroicon-m-x-mark')
                                                ->inline(false),
                                        ])
                                        ->columns(2)
                                        ->grid(2)
                                        ->visible(fn ($get) => $get('type') === 'pilihan_ganda')
                                        ->createItemButtonLabel('Tambah Opsi Jawaban'),
                                ])
                                ->createItemButtonLabel('Tambah Nomor Soal Baru')
                                ->columnSpanFull(),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
