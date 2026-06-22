<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CMS\Models\Post;

class BlogPostsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title'       => 'Understanding Heart Health: Tips for a Stronger Cardiovascular System',
                'slug'        => 'understanding-heart-health',
                'category'    => 'Cardiology',
                'cat_color'   => 'bg-red-100 text-red-600',
                'excerpt'     => 'Maintaining a healthy heart requires consistent lifestyle habits. Learn how simple daily choices — from diet to exercise — can dramatically improve cardiovascular outcomes.',
                'body'        => '<p>Heart disease remains one of the leading causes of mortality worldwide, yet many of its risk factors are entirely preventable through lifestyle modifications and early detection.</p><h2>Exercise Regularly</h2><p>The American Heart Association recommends at least 150 minutes of moderate-intensity aerobic activity per week. Even brisk walking for 30 minutes a day can significantly reduce your risk of heart disease.</p><h2>Eat a Heart-Healthy Diet</h2><p>Focus on fruits, vegetables, whole grains, lean proteins, and healthy fats. The Mediterranean diet has been shown to reduce cardiovascular risk by up to 30%.</p><h2>Monitor Your Numbers</h2><p>Know your blood pressure, cholesterol, and blood sugar levels. Regular screenings allow early detection and intervention before conditions become serious.</p><h2>Manage Stress</h2><p>Chronic stress contributes to high blood pressure and inflammation. Practice mindfulness, yoga, or deep breathing exercises to keep stress in check.</p>',
                'author'      => 'Dr. Samuel Okonkwo',
                'author_role' => 'Cardiologist',
                'read_time'   => '5 min read',
                'grad'        => 'from-red-400 to-rose-600',
                'icon_path'   => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'status'      => 'published',
                'published_at'=> now()->subDays(7),
            ],
            [
                'title'       => 'Brain Health in the Digital Age: Managing Screen Time and Mental Fatigue',
                'slug'        => 'brain-health-digital-age',
                'category'    => 'Neurology',
                'cat_color'   => 'bg-violet-100 text-violet-600',
                'excerpt'     => 'As screen usage increases globally, neurologists are seeing a rise in digital fatigue. Discover expert-backed strategies to protect your brain health and maintain sharp cognition.',
                'body'        => '<p>We live in an age of unprecedented digital connectivity, and while technology brings immense benefits, excessive screen time is increasingly linked to neurological strain, disrupted sleep, and cognitive fatigue.</p><h2>What is Digital Fatigue?</h2><p>Digital fatigue occurs when prolonged exposure to digital screens leads to physical and mental exhaustion. Symptoms include headaches, blurred vision, difficulty concentrating, and irritability.</p><h2>The 20-20-20 Rule</h2><p>Every 20 minutes, look at something 20 feet away for at least 20 seconds. This simple practice gives your eye muscles a chance to relax and can significantly reduce digital eye strain.</p><h2>Protect Your Sleep</h2><p>Blue light from screens suppresses melatonin production. Avoid screens for at least 1 hour before bedtime.</p>',
                'author'      => 'Dr. Amaka Nwachukwu',
                'author_role' => 'Neurologist',
                'read_time'   => '7 min read',
                'grad'        => 'from-violet-400 to-purple-600',
                'icon_path'   => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                'status'      => 'published',
                'published_at'=> now()->subDays(13),
            ],
            [
                'title'       => 'Why Regular Health Screenings Are Essential for Preventive Care',
                'slug'        => 'preventive-health-screenings',
                'category'    => 'General Health',
                'cat_color'   => 'bg-blue-100 text-blue-600',
                'excerpt'     => 'Early detection saves lives. We break down which health screenings are recommended at every age and why a proactive approach to healthcare is always the smartest investment.',
                'body'        => '<p>Preventive healthcare is one of the most powerful tools available to us. Regular screenings can catch diseases at their earliest, most treatable stages — often before symptoms even appear.</p><h2>Screenings in Your 20s and 30s</h2><p>Blood pressure checks, cholesterol tests, diabetes screening, and dental check-ups form the foundation of preventive care for young adults.</p><h2>Screenings in Your 40s</h2><p>Add mammograms for women, colorectal cancer screening, more frequent blood sugar tests, and eye examinations. Cardiovascular risk assessments become more important in this decade.</p><h2>The ROI of Prevention</h2><p>Every naira spent on preventive screenings saves multiples in treatment costs. More importantly, early detection dramatically improves outcomes and quality of life.</p>',
                'author'      => 'Dr. Chioma Ezeh',
                'author_role' => 'General Practitioner',
                'read_time'   => '6 min read',
                'grad'        => 'from-blue-400 to-blue-600',
                'icon_path'   => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                'status'      => 'published',
                'published_at'=> now()->subDays(20),
            ],
            [
                'title'       => 'Post-Surgery Recovery: Expert Tips from Our Orthopedic Team',
                'slug'        => 'orthopedic-recovery-tips',
                'category'    => 'Orthopedics',
                'cat_color'   => 'bg-emerald-100 text-emerald-600',
                'excerpt'     => 'Recovering from orthopedic surgery requires more than just rest. Our surgeons share evidence-based strategies to accelerate healing and restore full mobility safely.',
                'body'        => '<p>Orthopedic surgery recovery is a journey that requires patience, discipline, and the right support. Whether you have had a joint replacement, spinal surgery, or fracture repair, the principles of good recovery remain consistent.</p><h2>Follow Your Rehabilitation Plan</h2><p>Physiotherapy is not optional — it is an essential part of your recovery. Attend every session and perform your home exercises consistently.</p><h2>Nutrition Matters</h2><p>Your body needs adequate protein, calcium, vitamin D, and zinc to repair tissue and bone. Focus on lean proteins, dairy products, leafy greens, and nuts during your recovery period.</p><h2>Rest and Sleep</h2><p>Growth hormone — essential for tissue repair — is released primarily during deep sleep. Aim for 8-9 hours of quality sleep per night.</p>',
                'author'      => 'Dr. Emeka Obi',
                'author_role' => 'Orthopedic Surgeon',
                'read_time'   => '8 min read',
                'grad'        => 'from-emerald-400 to-teal-600',
                'icon_path'   => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                'status'      => 'published',
                'published_at'=> now()->subDays(27),
            ],
            [
                'title'       => 'Complete Dental Health Guide: Beyond Brushing and Flossing',
                'slug'        => 'dental-health-guide',
                'category'    => 'Dentistry',
                'cat_color'   => 'bg-cyan-100 text-cyan-600',
                'excerpt'     => 'Good dental health is about much more than your morning routine. Our dental team shares the complete picture of oral health and its surprising connections to your overall wellbeing.',
                'body'        => '<p>Oral health is a window to your overall health. Research has established strong links between gum disease and conditions including heart disease, diabetes, and respiratory illness.</p><h2>The Right Brushing Technique</h2><p>Use a soft-bristled brush at a 45-degree angle to your gums. Brush in small circular motions for at least 2 minutes, twice daily. Aggressive brushing can damage enamel and gums over time.</p><h2>Floss Every Day</h2><p>Flossing removes plaque and food particles from between teeth where your brush cannot reach. Without daily flossing, you are leaving up to 40% of your tooth surfaces uncleaned.</p><h2>Regular Dental Visits</h2><p>See your dentist every 6 months for professional cleaning and examination. Many dental problems are entirely painless in their early stages — only a professional can catch them.</p>',
                'author'      => 'Dr. Chioma Ezeh',
                'author_role' => 'Dentist',
                'read_time'   => '5 min read',
                'grad'        => 'from-cyan-400 to-blue-500',
                'icon_path'   => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'status'      => 'published',
                'published_at'=> now()->subDays(35),
            ],
        ];

        foreach ($posts as $post) {
            Post::firstOrCreate(['slug' => $post['slug']], $post);
        }

        $this->command->info('Seeded ' . Post::where('approval_status', 'approved')->count() . ' published blog posts.');
    }
}
