<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [

            // ===== NURSE =====
            [
                'name' => 'Basic Patient Care (bathing, dressing, feeding, and assisting with mobility)',
                'type' => 'nurse',
            ],
            [
                'name' => 'Vital Signs Monitoring (checking blood pressure, blood sugar, pulse, temperature, etc.)',
                'type' => 'nurse',
            ],
            [
                'name' => 'Medical Assistance: Assisting nurses with wound care and administering medication (in some cases)',
                'type' => 'nurse',
            ],
            [
                'name' => 'Compassion & Communication Skills',
                'type' => 'nurse',
            ],
            [
                'name' => 'Special needs children caregiving',
                'type' => 'nurse',
            ],
            [
                'name' => 'Elderly caregiving',
                'type' => 'nurse',
            ],
            [
                'name' => 'Handling Medical Equipment (e.g., feeding tubes, catheter, oxygen tanks)',
                'type' => 'nurse',
            ],

            // ===== NURSE AIDE ASSISTANT =====
            [
                'name' => 'Basic Patient Care (bathing, dressing, feeding, and assisting with mobility)',
                'type' => 'nurse_aide_assistant',
            ],
            [
                'name' => 'Vital Signs Monitoring (checking blood pressure, blood sugar, pulse, temperature, etc.)',
                'type' => 'nurse_aide_assistant',
            ],
            [
                'name' => 'Compassion & Strong Communication Skills',
                'type' => 'nurse_aide_assistant',
            ],
            [
                'name' => 'Special needs caregiver (e.g., autistic, deaf, blind)',
                'type' => 'nurse_aide_assistant',
            ],
            [
                'name' => 'Elderly caregiving',
                'type' => 'nurse_aide_assistant',
            ],

            // ===== INSTITUTION NURSE =====
            [
                'name' => 'Basic Patient Care (bathing, dressing, feeding, and assisting with mobility)',
                'type' => 'institution_nurse',
            ],
            [
                'name' => 'Vital Signs Monitoring (checking blood pressure, blood sugar, pulse, temperature, etc.)',
                'type' => 'institution_nurse',
            ],
            [
                'name' => 'Medical Assistance: Assisting nurses with wound care and administering medication (in some cases)',
                'type' => 'institution_nurse',
            ],
            [
                'name' => 'Compassion & Communication Skills',
                'type' => 'institution_nurse',
            ],
            [
                'name' => 'Special needs children caregiving',
                'type' => 'institution_nurse',
            ],
            [
                'name' => 'Elderly caregiving',
                'type' => 'institution_nurse',
            ],
            [
                'name' => 'Handling Medical Equipment (e.g., feeding tubes, catheter, oxygen tanks)',
                'type' => 'institution_nurse',
            ],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                [
                    'name' => $skill['name'],
                    'type' => $skill['type'],
                ],
                $skill
            );
        }
    }

}
