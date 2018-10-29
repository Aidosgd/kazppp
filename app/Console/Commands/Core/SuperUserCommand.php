<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;


// Models
use App\Models\Admin;

class SuperUserCommand extends Command
{
    private $admin;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:add-super-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание супер юзера';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Admin $admin)
    {
        parent::__construct();
        $this->admin = $admin;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->askemail();
        $name = $this->ask('Введите имя');
        $password = $this->ask('Введите пароль');
        $this->admin->create([
            'super_user' => 1,
            'email' => $email,
            'name' => $name,
            'password' => $password,
        ]);

        $this->info('Супер администратор успешно добавлен.');
    }

    private function askemail()
    {
        $email = $this->ask('Введите email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Указанный вами e-mail имеет неверный формат');
            $this->askemail();
        }

        if ($this->admin->where('email', $email)->count()) {
            $this->error('Администратор с таким e-mail уже существует:');
            $this->askemail();
        }

        return $email;

    }
}
