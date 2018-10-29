<?php

use App\Models\Contact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExampleContactTableSeeder extends Seeder
{
    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts = [
            [
                'name' => 'Ришат',
                'phone' => '+996552222350',
                'address' => '/dev/null',
            ],

            [
                'name' => 'Ерназ',
                'phone' => '+77075036800',
                'address' => '/dev/null',
            ],

            [
                'name' => 'Айдос',
                'phone' => '+77759844489',
                'address' => '/dev/null',
            ],

            [
                'name' => 'Николай',
                'phone' => '+996555967021',
                'address' => '/dev/null',
            ],

            [
                'name' => 'Мерей',
                'phone' => '+77071566388',
                'address' => '/dev/null',
            ]

        ];

        DB::table('contacts')->truncate();

        foreach ($contacts as $contact) {
            DB::table('contacts')->insert($contact);
        }
    }
}
