<?php

// database/seeders/FaqsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;
use App\Models\Tag;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = Tag::all();

        // Ensure tags exist before creating FAQs
        if ($tags->count() == 0) {
            $this->command->info('No tags found. Please run TagsTableSeeder first.');
            return;
        }

        $faqs = [
            [
                'question' => 'What is Laravel?',
                'answer' => 'Laravel is a PHP framework for web artisans.',
                'tag' => 'General',
            ],
            [
                'question' => 'How do I reset my password?',
                'answer' => 'Click on "Forgot Password" on the login page.',
                'tag' => 'Account',
            ],
            [
                'question' => 'How do I update my billing information?',
                'answer' => 'Go to your account settings and click "Billing".',
                'tag' => 'Billing',
            ],
            [
                'question' => 'Why is my app slow?',
                'answer' => 'Check your server resources and optimize your queries.',
                'tag' => 'Technical',
            ],
            [
                'question' => 'Is there a mobile version of the product?',
                'answer' => 'Yes, we offer both iOS and Android apps.',
                'tag' => 'Product',
            ],
        ];

        foreach ($faqs as $faq) {
            $tag = $tags->where('name', $faq['tag'])->first();

            if ($tag) {
                Faq::create([
                    'question' => $faq['question'],
                    'answer' => $faq['answer'],
                    'tag_id' => $tag->id,
                    'status' => true,
                    'sort'=>rand(1,100),
                ]);
            }
        }
    }
}
