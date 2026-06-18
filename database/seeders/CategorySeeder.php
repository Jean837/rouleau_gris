<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void {
        $categories = [
            ['name' => 'Poésie',       'color' => '#8B5CF6'],
            ['name' => 'Philosophie',  'color' => '#6B7280'],
            ['name' => 'Technologie',  'color' => '#3B82F6'],
            ['name' => 'Journal',      'color' => '#D97706'],
            ['name' => 'Lectures',     'color' => '#059669'],
        ];
        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}