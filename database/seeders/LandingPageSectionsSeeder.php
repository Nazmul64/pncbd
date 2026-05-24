<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingPage;
use App\Models\LandingPageBlock;
use App\Models\Product;

class LandingPageSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create a dummy product to link to
        $product = Product::first();
        if (!$product) {
            $product = Product::create([
                'name' => 'Lactoflow Natural Supplement',
                'slug' => 'lactoflow-natural-supplement',
                'sku' => 'LFNS-001',
                'purchase_price' => 500,
                'selling_price' => 980,
                'current_price' => 980,
                'qty' => 100,
                'status' => 1,
                'is_active' => 1
            ]);
        }

        // Create or Update the Custom Demo Landing Page
        $landing = LandingPage::updateOrCreate(
            ['slug' => 'lactoflow-supplement'],
            [
                'title'         => 'বুকের দুধ বৃদ্ধির নির্ভরযোগ্য ন্যাচারাল সাপ্লিমেন্ট',
                'product_id'    => $product->id,
                'template_name' => 'landing-1',
                'bg_color' => '#fff0f2', // Matching the screenshot's soft pink/cream bg
                'text_color' => '#333333',
                'btn_color' => '#0073c6',
                'is_full_width' => true,
                'is_template'   => false,
                'status'        => true,
            ]
        );

        // Delete old blocks for this landing page if any to avoid duplication
        LandingPageBlock::where('landing_page_id', $landing->id)->delete();

        // 1. Add "কেন ভালো মানের পন্য বেছে নিবেন" (features_2col) Block
        LandingPageBlock::create([
            'landing_page_id' => $landing->id,
            'type'            => 'features_2col',
            'order'           => 1,
            'content'         => [
                'title'       => 'কেন ভালো মানের পণ্য বেছে নিবেন?',
                'left_title'  => 'ক্ষতি / অপকারিতা (অন্যান্য সাধারণ প্রোডাক্ট)',
                'left_icon'   => 'cross',
                'left_items'  => [
                    '১০০% কেমিক্যাল ও প্রিজারভেটিভ যুক্ত সাধারণ সাপ্লিমেন্ট',
                    'কৃত্রিম সুগার ও অতিরিক্ত ক্ষতিকারক কালার ব্যবহার',
                    'কোনো প্রকার ল্যাব টেস্ট বা লাইসেন্স ছাড়া প্রস্তুতকৃত ফর্মুলা',
                    'ব্যবহারের পর শরীরের স্থায়ী হরমোনাল ভারসাম্য নষ্ট করা'
                ],
                'right_title' => 'উপকারিতা / লাভ (Lactoflow Supplement)',
                'right_icon'  => 'check',
                'right_items' => [
                    '১০০% প্রাকৃতিক ভেষজ উপাদান থেকে তৈরি নিরাপদ সূত্র',
                    'কোনো প্রকার কেমিক্যাল বা কৃত্রিম রং ব্যবহার করা হয়নি',
                    'ISO এবং BSTI ল্যাব টেস্ট অনুমোদিত ও প্রামাণ্য গুণমান',
                    'হাজারো মায়েদের শতভাগ সন্তুষ্টি ও পজিটিভ ফিডব্যাক'
                ],
                'title_color' => '#0073c6',
                'bg_color'    => '#fff0f2',
                'padding'     => 60,
                'aos_type'    => 'fade-up',
                'aos_duration' => 800,
                'bottom_image' => 'supplement_bottom_demo.png',
                'bottom_title' => 'কেন Lactoflow Natural Supplement বুকের দুধ বৃদ্ধির সবচেয়ে নির্ভরযোগ্য সাপ্লিমেন্ট?',
                'bottom_bullets' => [
                    'অভিজ্ঞ ইউনানি ও আয়ুর্বেদিক চিকিৎসকদের দ্বারা তৈরি',
                    'সম্পূর্ণ প্রাকৃতিক ও চিনি-মুক্ত',
                    'কোনো প্রিজারভেটিভ বা কৃত্রিম রং নেই',
                    'আধুনিক বিজ্ঞানের সাথে ঐতিহ্যবাহী উপাদানের সংমিশ্রণ',
                    'বৈজ্ঞানিকভাবে পরীক্ষিত ও নিরাপদ'
                ],
                'bottom_image_position' => 'left'
            ]
        ]);

        // 2. Add "ন্যাচারাল সাপ্লিমেন্ট" (product_highlight) Block
        LandingPageBlock::create([
            'landing_page_id' => $landing->id,
            'type'            => 'product_highlight',
            'order'           => 2,
            'content'         => [
                'main_title'    => 'ন্যাচারাল সাপ্লিমেন্ট (বুকের দুধ বৃদ্ধির নির্ভরযোগ্য সমাধান)',
                'subtitle'      => 'মায়েদের সুস্থতা ও শিশুর পুষ্টি নিশ্চিত করতে সম্পূর্ণ প্রাকৃতিক ফর্মুলা',
                'image'         => 'supplement_demo.png', // Fallback or placeholder
                'image_position' => 'left',
                'bullets'       => [
                    'তৈরি সম্পূর্ণ রং ও রাসায়নিক মুক্ত উপাদান দিয়ে',
                    'আধুনিক বিজ্ঞানের সাথে ঐতিহ্যবাহী আয়ুর্বেদিক ফর্মুলার মেলবন্ধন',
                    'শিশুর জন্য বুকের দুধের পরিমাণ ও পুষ্টিগুণ বাড়ায়',
                    'মায়ের প্রসব পরবর্তী শারীরিক দুর্বলতা ও ক্লান্তি দূর করে',
                    'হজম শক্তি বৃদ্ধি করে এবং কোষ্ঠকাঠিন্য দূর করতে সাহায্য করে'
                ],
                'price_label'   => 'সাপ্লিমেন্টের বর্তমান বিশেষ অফার মূল্য:',
                'price'         => '৯৮০ টাকা',
                'delivery_text' => 'সারা দেশে ফ্রি হোম ডেলিভারি ও ক্যাশ অন ডেলিভারি সুবিধা!',
                'contact_label' => 'যেকোনো প্রশ্ন বা সরাসরি অর্ডারের জন্য কল করুন:',
                'phone'         => '01700000000',
                'title_color'   => '#0073c6',
                'text_color'    => '#2e7d32',
                'bg_color'      => '#ffffff',
                'padding'       => 65,
                'aos_type'      => 'fade-up',
                'aos_duration'  => 900
            ]
        ]);

        // 3. Add "ਬੁੱਕਰ ਦੁੱਧੇਰ ਸਮਸ੍ਯਾ ਸਮਾਧਾਨੇ" (feature_3box) Block - EXACT CONTENT FROM SCREENSHOT!
        LandingPageBlock::create([
            'landing_page_id' => $landing->id,
            'type'            => 'feature_3box',
            'order'           => 3,
            'content'         => [
                'title'       => 'বুকের দুধের সমস্যা সমাধানে Lactoflow Natural Supplement-এর কার্যকারিতা-',
                'subtitle'    => '',
                'box_bg'      => 'transparent',
                'title_color' => '#ffffff', // Used inside white title on blue background
                'boxes'       => [
                    [
                        'title' => 'বুকের দুধ বাড়ায় ও ফ্লো স্বাভাবিক রাখে-',
                        'text'  => 'প্রাকৃতিক গ্যালাকট্যাগ উপাদান বুকের দুধের পরিমাণ ও প্রবাহ বাড়ায়,ফলে মা ও শিশু দুজনেই পান প্রয়োজনীয় পুষ্টি।'
                    ],
                    [
                        'title' => 'প্রসব-পরবর্তী শক্তি পুনরুদ্ধারে সহায়ক-',
                        'text'  => 'প্রসবের পর শরীরে যে দুর্বলতা আসে, Lactoflow Natural Supplement তা দূর করে শক্তি, সহনশীলতা ও প্রাণশক্তি ফিরিয়ে আনে।'
                    ],
                    [
                        'title' => 'মায়ের পুষ্টি ঘাটতি পূরণে কার্যকর-',
                        'text'  => 'প্রাকৃতিক ভেষজ উপাদান শরীরে প্রয়োজনীয় পুষ্টি সরবরাহ করে,যাতে মা থাকেন সুস্থ সবল, হাসিখুশি ও প্রাণবন্তু।'
                    ],
                    [
                        'title' => 'মানসিক প্রশান্তি ও রিলাক্সেশন আনে-',
                        'text'  => 'Lactoflow Natural Supplement শরীরে অক্সিটোসিন হরমোন বাড়িয়ে মনের চাপ কমায় ও এনে দেয় প্রশান্তি ও শান্ত ঘুম।'
                    ],
                    [
                        'title' => 'প্রাকৃতিক ভাবে ইমিউনিটি শক্তিশালী করে-',
                        'text'  => 'ভেষজ উপাদান শরীরের রোগ প্রতিরোধ ক্ষমতা বাড়িয়ে মা ও শিশুকে রাখে নিরাপদ ও সুস্থ।'
                    ],
                    [
                        'title' => 'মাতৃত্বের পর শরীরের প্রাণশক্তি ফিরিয়ে আনে-',
                        'text'  => 'Clinically trusted formulation শরীরের পুনরুদ্ধার প্রক্রিয়া ত্বরান্বিত করে,যাতে মা আগের মতো স্বাভাবিক ও সক্রিয় থাকেন।'
                    ]
                ],
                'bg_color'    => '#fff0f2', // Screenshot background color (soft pink/cream)
                'padding'     => 60,
                'aos_type'    => 'fade-up',
                'aos_duration' => 1000
            ]
        ]);
    }
}
