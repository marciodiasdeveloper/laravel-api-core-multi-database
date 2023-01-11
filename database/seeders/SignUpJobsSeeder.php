<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SignUp\Job;

class SignUpJobsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createJob('Proprietário');
        $this->createJob('Administrador');
        $this->createJob('Gerente');
        $this->createJob('Funcionário');
        $this->createJob('Outro');
    }

    public function createJob($name)
    {
        $job = Job::where('name', $name)->first();

        if (!$job) {
            $job = new Job;
        }

        $job->name = $name;
        $job->status = 'enabled';
        $job->save();
    }
}
