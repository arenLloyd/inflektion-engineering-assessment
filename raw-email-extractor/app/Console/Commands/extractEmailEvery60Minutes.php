<?php

namespace App\Console\Commands;
use App\Models\SuccessfulEmail;

use Illuminate\Console\Command;
use App\Helpers\EmailHelper;

class extractEmailEvery60Minutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:extract-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract raw email every hour';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emails = SuccessfulEmail::where(function($query) {
            $query->where('raw_text', null)
                  ->orWhere('raw_text', '');
        })->get();

        foreach ($emails as $email) {
            $plainText = EmailHelper::extractPlainText($email->email);

            $email->update([
                'raw_text' => $plainText,
            ]);
        }

        $this->info('Email extraction completed.');
    }
}
