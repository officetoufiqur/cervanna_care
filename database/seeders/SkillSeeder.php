<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $one = [
            'name' => 'Basic Patient Care (bathing, dressing, feeding, and assisting with mobility)',
            'type' => 'nurse',
        ];

        $two = [
            'name' => 'Vital Signs Monitoring(checking blood pressure, blood sugar, pulse, temperature, etc.',
            'type' => 'nurse',
        ];

        $three = [
            'name' => 'Medical Assistance: Aassisting nurses with wound care, administering medication (in some cases)',
            'type' => 'nurse',
        ];
        $four = [
            'name' => 'Compassion & Communication Skills',
            'type' => 'nurse',
        ];
        $five = [
            'name' => 'Special needs children caregiving',
            'type' => 'nurse',
        ];
        $six = [
            'name' => 'Elderly caregiving',
            'type' => 'nurse',
        ];
        $seven =
         [
             'name' => 'Handling Medical Equipment (e. g. feeding tubes, catheter, oxygen tanks)',
             'type' => 'nurse',
         ];

        $eight = [
            'name' => 'Basic Patient Care (bathing, dressing, feeding, and assisting with mobility)',
            'type' => 'nurse_ade_assistant',
        ];

        $nine = [
            'name' => 'Vital Signs Monitoring(checking blood pressure, blood sugar, pulse, temperature, etc.',
            'type' => 'nurse_ade_assistant',
        ];

        $ten = [
            'name' => 'Compassion &  strong communication Skills',
            'type' => 'nurse_ade_assistant',
        ];
        $eleven = [
            'name' => 'Special needs caregiver (name which special need you have worked with e. g. autistic, deaf, blind)',
            'type' => 'nurse_ade_assistant',
        ];
        $twelve = [
            'name' => 'Elderly caregiving',
            'type' => 'nurse_ade_assistant',
        ];

        foreach ([$one, $two, $three, $four, $five, $six, $seven, $eight, $nine, $ten, $eleven, $twelve] as $skill) {
            \App\Models\Skill::create($skill);
        }

    }
}
