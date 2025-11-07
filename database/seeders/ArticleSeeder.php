<?php
// ...
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory(25)->create(); // Crea 25 artículos de prueba
    }
}