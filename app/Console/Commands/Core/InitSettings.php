<?php

namespace App\Console\Commands\Core;

use App\Models\Setting;
use Illuminate\Console\Command;

class InitSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:init-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Инициализация настроек';

    private $setting;


    private $settings = [
        [
            'alias' => 'main_page',
            'owner' => 'settings',
            'display_name' => 'Настройка главной страницы'
        ],

        [
            'alias' => 'footer_text',
            'owner' => 'settings',
            'display_name' => 'Настройка футера'
        ]
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Setting $setting)
    {
        parent::__construct();
        $this->setting = $setting;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->settings as $setting)
        {
            $this->info($setting['display_name']);
            $this->setting->firstOrCreate($setting);
        }
    }
}
