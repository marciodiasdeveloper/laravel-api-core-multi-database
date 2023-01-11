<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\SignUp\WorkArea;

class SignUpWorkAreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createWorkArea('Salões de beleza e esmalterias');
        $this->createWorkArea('Médicos e dentistas');
        $this->createWorkArea('Clínicas de estética e massagistas');
        $this->createWorkArea('Psicólogos e terapeutas');
        $this->createWorkArea('Consultoria e coaching');
        $this->createWorkArea('Academias e estúdios');
        $this->createWorkArea('Oficinas e concessionárias');
        $this->createWorkArea('Quadras esportivas');
        $this->createWorkArea('Estúdios de música');
        $this->createWorkArea('Outros');
    }

    public function createWorkArea($name)
    {
        $work_area = WorkArea::where('name', $name)->first();

        if (!$work_area) {
            $work_area = new WorkArea;
        }

        $work_area->name = $name;
        $work_area->status = 'enabled';
        $work_area->save();
    }
}
