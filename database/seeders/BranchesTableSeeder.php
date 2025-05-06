<?php
// database/seeders/BranchesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchesTableSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            'فرع تمريض البالغين',
            'فرع أساسيات التمريض',
            'فرع صحة الأم والوليد',
            'فرع صحة المجتمع',
            'فرع تمريض الأطفال',
            'فرع تمريض الصحة النفسية',
            'فرع العلوم الأساسية',
            'نشاطات طلابية',
            'برنامج حكومي',
            'التعليم المستمر',
            'العلمية',
            'الإرشاد النفسي',
            'التأهيل والتوظيف',
            'شؤون المرأة',
            'حقوق الإنسان',
            'الدراسات العليا',
            'طلاب',
        ];

        foreach ($branches as $name) {
            DB::table('branches')->updateOrInsert(
                ['name' => $name],   // شرط الـ WHERE
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
