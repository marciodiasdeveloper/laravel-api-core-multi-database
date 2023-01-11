<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Module\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createModuleProfile();
        $this->createModuleUsers();
        $this->createModuleSchools();
        $this->createModuleSchedules();
    }

    public function createModuleProfile()
    {
        $module = Module::where('slug', 'profile')->first();

        if (!$module) {
            $module = new Module;
        }

        $module->uuid = $module->uuid ? $module->uuid : '';
        $module->name = 'Meu perfil';
        $module->slug = 'profile';
        $module->status = 'enabled';
        $module->order = 1;
        $module->summary = 'Gerenciador de perfil do usuário.';
        $module->status = 'enabled';
        $module->public = 0;
        $module->editable = 0;
        $module->removable = 0;
        $module->save();
    }

    public function createModuleUsers()
    {
        $module = Module::where('slug', 'users')->first();

        if (!$module) {
            $module = new Module;
        }

        $module->uuid = $module->uuid ? $module->uuid : '';
        $module->name = 'Usuários';
        $module->slug = 'users';
        $module->status = 'enabled';
        $module->order = 1;
        $module->summary = 'Gerenciador de usuários.';
        $module->status = 'enabled';
        $module->public = 0;
        $module->editable = 0;
        $module->removable = 0;
        $module->save();
    }

    public function createModuleSchools()
    {
        $module = Module::where('slug', 'schools')->first();

        if (!$module) {
            $module = new Module;
        }

        $module->uuid = $module->uuid ? $module->uuid : '';
        $module->name = 'Escolas';
        $module->slug = 'schools';
        $module->status = 'enabled';
        $module->order = 1;
        $module->summary = 'Gerenciador de escolas.';
        $module->status = 'enabled';
        $module->public = 1;
        $module->editable = 0;
        $module->removable = 0;
        $module->save();
    }

    public function createModuleSchedules()
    {
        $module = Module::where('slug', 'schedules')->first();

        if (!$module) {
            $module = new Module;
        }

        $module->uuid = $module->uuid ? $module->uuid : '';
        $module->name = 'Agenda de serviços';
        $module->slug = 'schedules';
        $module->status = 'enabled';
        $module->order = 1;
        $module->summary = 'Gerenciador para agenda de serviços.';
        $module->status = 'enabled';
        $module->public = 1;
        $module->editable = 0;
        $module->removable = 0;
        $module->save();
    }
}
