<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\SubjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'COMPUTER LANGUAGES' => [
                'C++', 'C Language', 'C#', 'Java', 'Python', 'PHP', 'SQL', 'Javascript', 'html', 'CSS', 'Ruby', 'Perl'
            ],
            'LANGUAGES AND LITERATURE' => [
                'English', 'Urdu', 'Arabic', 'French', 'German', 'Spanish', 'Chinese', 'Persian'
            ],
            'PRIMARY AND MIDDLE GRADES' => [
                'Mathematics', 'Science', 'English (Primary)', 'Urdu (Primary)', 'Social Studies', 'ICT'
            ],
            'CAMBRIDGE O LEVEL / IGCSE / ICE' => [
                'Physics', 'Chemistry', 'Biology', 'Mathematics (D)', 'Additional Mathematics', 'English Language', 'Computer Science', 'Economics', 'Business Studies', 'Accounting'
            ],
            'CAMBRIDGE A LEVEL / PRE-U / AICE' => [
                'Physics (A-Level)', 'Chemistry (A-Level)', 'Biology (A-Level)', 'Mathematics (A-Level)', 'Further Mathematics', 'Computer Science (A-Level)', 'Economics (A-Level)', 'Business (A-Level)', 'Law'
            ],
            'MATRICULATION' => [
                'Ninth Class (Science)', 'Ninth Class (Arts)', 'Tenth Class (Science)', 'Tenth Class (Arts)'
            ],
            'F.SC / I.COM / ICS' => [
                'F.Sc Pre-Medical', 'F.Sc Pre-Engineering', 'ICS (Computer Science)', 'I.Com (Commerce)'
            ],
            'STANDARD TESTS' => [
                'SAT', 'GRE', 'GMAT', 'IELTS', 'TOEFL', 'MDCAT', 'ECAT'
            ],
            'QURAN' => [
                'Nazra Quran', 'Tajweed', 'Hifz', 'Translation/Tafseer'
            ]
        ];

        foreach ($data as $categoryName => $subjects) {
            $category = SubjectCategory::create([
                'name' => $categoryName,
                'slug' => Str::slug($categoryName),
                'is_active' => true
            ]);

            foreach ($subjects as $subjectName) {
                // Handle special characters for slugs to avoid duplicates (e.g. C++ and C# both becoming 'c')
                $slug = Str::slug($subjectName);
                if ($subjectName === 'C++') $slug = 'cpp';
                if ($subjectName === 'C#') $slug = 'c-sharp';

                Subject::create([
                    'category_id' => $category->id,
                    'name' => $subjectName,
                    'slug' => $slug,
                ]);
            }
        }
    }
}
