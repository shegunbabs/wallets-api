<?php

namespace App\Console\Commands;

use App\Actions\CreateUser;
use App\DTOs\UserData;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StoreUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-user {name : system name} {email : system email} {password : system password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a User';

    /**
     * Execute the console command.
     */
    public function handle(CreateUser $createUser): int
    {
        $data['name'] = $this->argument('name');
        $data['email'] = $this->argument('email');
        $data['password'] = $this->argument('password');

        $validator = Validator::make($data, $this->rules());

        if ($validator->fails()) {
            $errorsText = '';
            foreach ($validator->errors()->toArray() as $error) {
                $errorsText .= $error[0] . "\r\n";
            }
            $this->error($errorsText);
            return Command::FAILURE;
        }

        $userDTO = UserData::from($data);

        ['user' => $user, 'secret_key' => $secret_key] = $createUser->handle($userDTO);

        $this->info("User {$user->name} created successfully. Secret: {$secret_key}");
        return Command::SUCCESS;
    }

    private function rules(): array {
        return [
            'name' => ['required', 'string', 'min:5', 'max:50', 'unique:users,name'],
            'email' => ['required', 'email:dns,rfc', 'string', 'min:5', 'max:50', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:50']
        ];
    }
}
