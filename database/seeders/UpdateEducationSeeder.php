<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class UpdateEducationSeeder extends Seeder
{
    public function run(): void
    {
        collect([
            [
                'Bachelor of Science (B.Sc.) in Computer Science and Engineering (CSE)',
                'American International University-Bangladesh (AIUB)',
                'B.Sc. in CSE',
                '2021 - 2025',
                null,
                "Studied core Computer Science subjects including Software Engineering, Database Systems, Data Structures & Algorithms, Web Development, and Networking.\nCompleted academic projects using PHP, Laravel, MySQL, HTML, CSS, JavaScript, and Tailwind CSS.",
            ],
            [
                'Higher Secondary Certificate (HSC)',
                'Notre Dame College, Mymensingh',
                'Science',
                'Graduated: 2019',
                null,
                'Completed Higher Secondary education with a focus on Science.',
            ],
            [
                'Secondary School Certificate (SSC)',
                'Nabarun Public School',
                'Science',
                'Graduated: 2017',
                null,
                'Successfully completed Secondary School education with a Science background.',
            ],
        ])->each(fn (array $education, int $index) => Education::query()->updateOrCreate(
            ['level' => $education[0]],
            [
                'institution' => $education[1],
                'degree' => $education[2],
                'period' => $education[3],
                'result' => $education[4],
                'description' => $education[5],
                'sort_order' => $index,
                'is_visible' => true,
            ],
        ));

        Education::query()
            ->whereIn('level', ['School', 'College', 'University'])
            ->update(['is_visible' => false]);
    }
}
