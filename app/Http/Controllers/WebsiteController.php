<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /** Homepage */
    public function home()
    {
        return view('website.home');
    }

    /** About Us page */
    public function about()
    {
        return view('website.pages.about');
    }

    /** Departments / Services page */
    public function services()
    {
        return view('website.pages.services');
    }

    /** Doctors listing page */
    public function doctors()
    {
        return view('website.pages.doctors');
    }

    /** Blog listing page */
    public function blog()
    {
        $posts = $this->getBlogPosts();
        return view('website.pages.blog.index', compact('posts'));
    }

    /** Single blog post page */
    public function blogShow(string $slug)
    {
        $posts   = $this->getBlogPosts();
        $post    = collect($posts)->firstWhere('slug', $slug);
        $related = collect($posts)->where('slug', '!=', $slug)->take(3)->values()->all();

        if (! $post) {
            abort(404);
        }

        return view('website.pages.blog.show', compact('post', 'related'));
    }

    /** Contact page */
    public function contact()
    {
        return view('website.pages.contact');
    }

    // ─────────────────────────────────────────────────────────────
    // Shared demo data helpers
    // ─────────────────────────────────────────────────────────────

    private function getBlogPosts(): array
    {
        return [
            [
                'slug'      => 'understanding-heart-health',
                'category'  => 'Cardiology',
                'cat_color' => 'bg-red-100 text-red-600',
                'date'      => 'May 18, 2026',
                'date_iso'  => '2026-05-18',
                'title'     => 'Understanding Heart Health: Tips for a Stronger Cardiovascular System',
                'excerpt'   => 'Maintaining a healthy heart requires consistent lifestyle habits. Learn how simple daily choices — from diet to exercise — can dramatically improve cardiovascular outcomes.',
                'body'      => '<p>Heart disease remains one of the leading causes of mortality worldwide, yet many of its risk factors are entirely preventable through lifestyle modifications and early detection.</p>
                    <h2>Exercise Regularly</h2>
                    <p>The American Heart Association recommends at least 150 minutes of moderate-intensity aerobic activity per week. Even brisk walking for 30 minutes a day can significantly reduce your risk of heart disease.</p>
                    <h2>Eat a Heart-Healthy Diet</h2>
                    <p>Focus on fruits, vegetables, whole grains, lean proteins, and healthy fats. Limit sodium, saturated fats, and processed foods. The Mediterranean diet has been shown to reduce cardiovascular risk by up to 30%.</p>
                    <h2>Monitor Your Numbers</h2>
                    <p>Know your blood pressure, cholesterol, and blood sugar levels. Regular screenings allow early detection and intervention before conditions become serious.</p>
                    <h2>Manage Stress</h2>
                    <p>Chronic stress contributes to high blood pressure and inflammation. Practice mindfulness, yoga, or deep breathing exercises to keep stress in check.</p>
                    <h2>Quit Smoking</h2>
                    <p>Smoking damages blood vessels and dramatically increases heart disease risk. Quitting at any age has immediate and long-term benefits for your cardiovascular health.</p>',
                'read_time' => '5 min read',
                'grad'      => 'from-red-400 to-rose-600',
                'icon_path' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'author'    => 'Dr. Samuel Okonkwo',
                'author_role' => 'Cardiologist',
            ],
            [
                'slug'      => 'brain-health-digital-age',
                'category'  => 'Neurology',
                'cat_color' => 'bg-violet-100 text-violet-600',
                'date'      => 'May 12, 2026',
                'date_iso'  => '2026-05-12',
                'title'     => 'Brain Health in the Digital Age: Managing Screen Time and Mental Fatigue',
                'excerpt'   => 'As screen usage increases globally, neurologists are seeing a rise in digital fatigue. Discover expert-backed strategies to protect your brain health and maintain sharp cognition.',
                'body'      => '<p>We live in an age of unprecedented digital connectivity, and while technology brings immense benefits, excessive screen time is increasingly linked to neurological strain, disrupted sleep, and cognitive fatigue.</p>
                    <h2>What is Digital Fatigue?</h2>
                    <p>Digital fatigue, or "screen fatigue," occurs when prolonged exposure to digital screens leads to physical and mental exhaustion. Symptoms include headaches, blurred vision, difficulty concentrating, and irritability.</p>
                    <h2>The 20-20-20 Rule</h2>
                    <p>Every 20 minutes, look at something 20 feet away for at least 20 seconds. This simple practice gives your eye muscles a chance to relax and can significantly reduce digital eye strain.</p>
                    <h2>Protect Your Sleep</h2>
                    <p>Blue light from screens suppresses melatonin production. Avoid screens for at least 1 hour before bedtime, or use blue light filtering glasses and Night Mode settings on your devices.</p>
                    <h2>Take Regular Breaks</h2>
                    <p>Follow the Pomodoro Technique: work for 25 minutes, then take a 5-minute break. Get up, stretch, and look away from your screen during breaks.</p>
                    <h2>Mindful Technology Use</h2>
                    <p>Schedule specific times to check emails and social media rather than reacting to every notification. Intentional technology use reduces cognitive load and anxiety.</p>',
                'read_time' => '7 min read',
                'grad'      => 'from-violet-400 to-purple-600',
                'icon_path' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z',
                'author'    => 'Dr. Amaka Nwachukwu',
                'author_role' => 'Neurologist',
            ],
            [
                'slug'      => 'preventive-health-screenings',
                'category'  => 'General Health',
                'cat_color' => 'bg-blue-100 text-blue-600',
                'date'      => 'May 5, 2026',
                'date_iso'  => '2026-05-05',
                'title'     => 'Why Regular Health Screenings Are Essential for Preventive Care',
                'excerpt'   => 'Early detection saves lives. We break down which health screenings are recommended at every age and why a proactive approach to healthcare is always the smartest investment.',
                'body'      => '<p>Preventive healthcare is one of the most powerful tools available to us. Regular screenings can catch diseases at their earliest, most treatable stages — often before symptoms even appear.</p>
                    <h2>Screenings in Your 20s and 30s</h2>
                    <p>Blood pressure checks, cholesterol tests, diabetes screening, cervical cancer screening (Pap smear), STI testing, and dental check-ups form the foundation of preventive care for young adults.</p>
                    <h2>Screenings in Your 40s</h2>
                    <p>Add mammograms for women, colorectal cancer screening, more frequent blood sugar tests, and eye examinations. Cardiovascular risk assessments become more important in this decade.</p>
                    <h2>Screenings in Your 50s and Beyond</h2>
                    <p>Colonoscopies, bone density scans (DEXA), lung cancer screening for smokers, comprehensive eye exams for glaucoma, and hearing tests are key preventive measures in later decades.</p>
                    <h2>The ROI of Prevention</h2>
                    <p>Every naira spent on preventive screenings saves multiples in treatment costs. More importantly, early detection dramatically improves outcomes and quality of life.</p>
                    <h2>Book Your Screening Today</h2>
                    <p>At Ogechi Hospital, we offer comprehensive preventive health packages tailored to your age and risk profile. Our team of specialists makes the process quick, comfortable, and thorough.</p>',
                'read_time' => '6 min read',
                'grad'      => 'from-blue-400 to-blue-600',
                'icon_path' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                'author'    => 'Dr. Chioma Ezeh',
                'author_role' => 'General Practitioner',
            ],
            [
                'slug'      => 'orthopedic-recovery-tips',
                'category'  => 'Orthopedics',
                'cat_color' => 'bg-emerald-100 text-emerald-600',
                'date'      => 'April 28, 2026',
                'date_iso'  => '2026-04-28',
                'title'     => 'Post-Surgery Recovery: Expert Tips from Our Orthopedic Team',
                'excerpt'   => 'Recovering from orthopedic surgery requires more than just rest. Our surgeons share evidence-based strategies to accelerate healing and restore full mobility safely.',
                'body'      => '<p>Orthopedic surgery recovery is a journey that requires patience, discipline, and the right support. Whether you have had a joint replacement, spinal surgery, or fracture repair, the principles of good recovery remain consistent.</p>
                    <h2>Follow Your Rehabilitation Plan</h2>
                    <p>Physiotherapy is not optional — it is an essential part of your recovery. Attend every session and perform your home exercises consistently. Skipping exercises, even a few days, can set back your progress significantly.</p>
                    <h2>Manage Pain Proactively</h2>
                    <p>Do not wait until pain becomes severe to take medication. Staying ahead of pain allows you to participate more effectively in physiotherapy and daily activities critical to healing.</p>
                    <h2>Nutrition Matters</h2>
                    <p>Your body needs adequate protein, calcium, vitamin D, and zinc to repair tissue and bone. Focus on lean proteins, dairy products, leafy greens, and nuts during your recovery period.</p>
                    <h2>Rest and Sleep</h2>
                    <p>Growth hormone — essential for tissue repair — is released primarily during deep sleep. Aim for 8-9 hours of quality sleep per night and take daytime naps if needed.</p>',
                'read_time' => '8 min read',
                'grad'      => 'from-emerald-400 to-teal-600',
                'icon_path' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                'author'    => 'Dr. Emeka Obi',
                'author_role' => 'Orthopedic Surgeon',
            ],
            [
                'slug'      => 'dental-health-guide',
                'category'  => 'Dentistry',
                'cat_color' => 'bg-cyan-100 text-cyan-600',
                'date'      => 'April 20, 2026',
                'date_iso'  => '2026-04-20',
                'title'     => 'Complete Dental Health Guide: Beyond Brushing and Flossing',
                'excerpt'   => 'Good dental health is about much more than your morning routine. Our dental team shares the complete picture of oral health and its surprising connections to your overall wellbeing.',
                'body'      => '<p>Oral health is a window to your overall health. Research has established strong links between gum disease and conditions including heart disease, diabetes, and respiratory illness.</p>
                    <h2>The Right Brushing Technique</h2>
                    <p>Use a soft-bristled brush at a 45-degree angle to your gums. Brush in small circular motions for at least 2 minutes, twice daily. Aggressive brushing can damage enamel and gums over time.</p>
                    <h2>Floss Every Day</h2>
                    <p>Flossing removes plaque and food particles from between teeth where your brush cannot reach. Without daily flossing, you are leaving up to 40% of your tooth surfaces uncleaned.</p>
                    <h2>Diet and Your Teeth</h2>
                    <p>Limit sugary and acidic foods and drinks. Sugar feeds the bacteria that produce tooth-decaying acid. When you do consume acidic drinks, use a straw and wait 30 minutes before brushing.</p>
                    <h2>Regular Dental Visits</h2>
                    <p>See your dentist every 6 months for professional cleaning and examination. Many dental problems, including cavities and gum disease, are entirely painless in their early stages — only a professional can catch them.</p>',
                'read_time' => '5 min read',
                'grad'      => 'from-cyan-400 to-blue-500',
                'icon_path' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'author'    => 'Dr. Chioma Ezeh',
                'author_role' => 'Dentist',
            ],
            [
                'slug'      => 'managing-diabetes-naturally',
                'category'  => 'Endocrinology',
                'cat_color' => 'bg-orange-100 text-orange-600',
                'date'      => 'April 12, 2026',
                'date_iso'  => '2026-04-12',
                'title'     => 'Managing Type 2 Diabetes: Lifestyle Changes That Make a Real Difference',
                'excerpt'   => 'Type 2 diabetes is largely preventable and manageable with the right lifestyle modifications. Our endocrinology team outlines a comprehensive, evidence-based approach to blood sugar control.',
                'body'      => '<p>Type 2 diabetes affects millions of people globally, but it is also one of the most manageable chronic conditions when approached with the right lifestyle strategies and medical support.</p>
                    <h2>The Power of Weight Management</h2>
                    <p>Losing just 5-10% of body weight can significantly improve insulin sensitivity and blood sugar control. Even modest weight loss reduces the need for medication in many patients.</p>
                    <h2>Exercise as Medicine</h2>
                    <p>Both aerobic exercise and resistance training improve insulin sensitivity. Aim for 150 minutes of moderate activity per week, spread across most days. Even short 10-minute walks after meals can lower post-meal blood sugar spikes.</p>
                    <h2>Low Glycaemic Index Eating</h2>
                    <p>Choose foods that release glucose slowly. Focus on vegetables, legumes, whole grains, and lean proteins. Limit white rice, white bread, sugary drinks, and processed snacks.</p>
                    <h2>Monitor Your Blood Sugar</h2>
                    <p>Regular self-monitoring gives you real-time feedback on how food, exercise, stress, and sleep affect your blood sugar. Work with your care team to set personalised target ranges.</p>',
                'read_time' => '9 min read',
                'grad'      => 'from-orange-400 to-amber-600',
                'icon_path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'author'    => 'Dr. Samuel Okonkwo',
                'author_role' => 'Endocrinologist',
            ],
        ];
    }
}
