<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;

class SeoCommand extends Command
{
    private $setting;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:add-seo-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание SEO настройки';

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
        $data = '{"ru":{"title":null,"meta_description":null,"meta_keywords":null},"kz":{"title":null,"meta_description":null,"meta_keywords":null},"en":{"title":null,"meta_description":null,"meta_keywords":null}}';
        $seo = [
            [
                'id' => 1,
                'alias' => 'main',
                'owner' => 'seo',
                'display_name' => 'Главная страница',
                'data' => $data
            ],
            [
                'id' => 2,
                'alias' => 'news',
                'owner' => 'seo',
                'display_name' => 'Новости',
                'data' => $data
            ],
        ];

        foreach ($seo as $item)
        {
            if (!$this->setting->where('alias', $item['alias'])->count())
            {
                $this->setting->create($item);
            }
        }

        $this->info('SEO настройки успешно добавлены');
    }
}
