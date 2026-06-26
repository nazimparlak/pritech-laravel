<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Tag;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Önce ortak kullanılacak 10 tane benzersiz Tag oluşturalım
        $tags = Tag::factory(10)->create();

        // 2. 5 tane Proje oluşturalım
        Project::factory(5)->create()->each(function ($project) use ($tags) {

            // 3. Her projeye bağlı 3 ila 7 arasında rastgele Issue ekleyelim
            $issues = Issue::factory(rand(3, 7))->create([
                'project_id' => $project->id
            ]);

            foreach ($issues as $issue) {
                // 4. Her Issue'ya rastgele 1 ila 3 adet Tag bağlayalım (Many-to-Many ara tablo doldurma)
                $issue->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );

                // 5. Her Issue'ya 2 ila 5 arasında sahte Comment (Yorum) ekleyelim
                Comment::factory(rand(2, 5))->create([
                    'issue_id' => $issue->id
                ]);
            }
        });
    }
}
