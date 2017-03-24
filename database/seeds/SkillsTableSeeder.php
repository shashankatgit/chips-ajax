<?php

use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $skill = new \App\Skill();
        $skill->skill = "Tech Writing";
        $skill->save();

        $skill = new \App\Skill();
        $skill->skill = "Blogging";
        $skill->save();

        $skill = new \App\Skill();
        $skill->skill = "Script Writing";
        $skill->save();

        $skill = new \App\Skill();
        $skill->skill = "Creative Writing";
        $skill->save();

        $skill = new \App\Skill();
        $skill->skill = "Copy Writer";
        $skill->save();

    }
}
