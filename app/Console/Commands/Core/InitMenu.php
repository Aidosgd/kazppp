<?php

namespace App\Console\Commands\Core;

use App\Models\Setting;
use Illuminate\Console\Command;

class InitMenu extends Command
{
    private $setting;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:init-menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Инициализация меню';

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
        if (is_array($menu = config('project.menus')))
        {
            $menuSettings = $this->setting->firstOrCreate([
                'alias' => 'menu',
                'owner' => 'menu',
                'display_name' => 'Настройка меню'
            ]);

            $menuSettings->data = json_encode($menu);
            $menuSettings->save();

            $this->info('Меню инициализировано');
        } else {
            $this->error('Конфиг не найден');
        }
    }
}
