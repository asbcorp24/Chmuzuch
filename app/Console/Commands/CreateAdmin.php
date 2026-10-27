<?php
namespace App\Console\Commands;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
class CreateAdmin extends Command {
 protected $signature='cms:create-admin {email?} {--name=}';
 protected $description='Create or promote a CMS super administrator';
 public function handle(): int {
  $email=$this->argument('email')?:$this->ask('E-mail');
  $name=$this->option('name')?:$this->ask('Имя','Администратор');
  $password=$this->secret('Пароль (минимум 10 символов)');
  if(strlen((string)$password)<10){$this->error('Пароль должен содержать минимум 10 символов.');return self::FAILURE;}
  User::updateOrCreate(['email'=>$email],['name'=>$name,'password'=>Hash::make($password),'role'=>'super_admin','is_active'=>true]);
  $this->info('Главный администратор создан.');
  return self::SUCCESS;
 }
}