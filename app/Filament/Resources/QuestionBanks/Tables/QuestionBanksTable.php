<?php

namespace App\Filament\Resources\QuestionBanks\Tables;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class QuestionBanksTable
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Paket Ujian')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject.name')
                    ->label('Mata Pelajaran')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('Guru Pembuat')
                    ->sortable(),

                TextColumn::make('questions_count')
                    ->label('Jumlah Soal')
                    ->counts('questions'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
