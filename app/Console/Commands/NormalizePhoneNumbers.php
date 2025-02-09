<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CekPlagiasi;

class NormalizePhoneNumbers extends Command
{
    protected $signature = 'normalize:phone-numbers';

    protected $description = 'Menormalkan nomor telepon di database';

    public function handle()
    {
        $this->info('Mulai menormalkan nomor telepon...');

        $documents = CekPlagiasi::all();
        $count = 0;

        foreach ($documents as $document) {
            $originalPhoneNumber = $document->nomor_hp;
            $normalizedPhoneNumber = preg_replace('/^\+?0?/', '', $originalPhoneNumber);
            $normalizedPhoneNumber = '62' . $normalizedPhoneNumber;

            if ($originalPhoneNumber !== $normalizedPhoneNumber) {
                $document->nomor_hp = $normalizedPhoneNumber;
                $document->save();
                $count++;
            }
        }

        $this->info("Normalisasi selesai. {$count} nomor telepon diperbarui.");
    }
}
