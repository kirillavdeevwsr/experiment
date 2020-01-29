<?php

namespace App\Console\Commands;

use App\Models\AdditionalInformationTeacher;
use App\Models\Role;
use App\Service\IntegrationOneC;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SynchronizeTeachers extends Command
{
    private $integration;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synchronize:teachers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация учетных записей из 1с в базу колледжа';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->integration = new IntegrationOneC();
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all()->pluck('email');
        $data = $this->integration->getTeachers();
        $roleTeacher = Role::where('short_name', 'teacher')->first();
        foreach($data['employees'] as $item) {
            if(!$users->contains($item['Email'])) {
                $user = new User();
                $user->login = $item['Login'];
                $user->email = $item['Email'];
                $user->password = bcrypt($item['Password']);
                $FIO = explode(" ", $item['additionalInformation']['FIO']);
                $user->name = $FIO[1];
                $user->surname = $FIO[0];
                $user->patronymic = $FIO[2];
                $user->full_name = $item['additionalInformation']['FIO'];
                $user->timestamps;
                $additional = new AdditionalInformationTeacher();
                $additional->birthday = $item['additionalInformation']['DateBirthday'];
                $additional->sex = $item['additionalInformation']['Sex'];
                $additional->ref_key = $item['Ref_Key'];
                $additional->adress = $item['additionalInformation']['Adress'];
                $additional->save();
                $user->additional_information = $additional->id;
                $user->save();
                $user->roles()->attach($roleTeacher->id);
            }
        }
        $this->info("Synchronize teachers successful completed!");
    }
}
