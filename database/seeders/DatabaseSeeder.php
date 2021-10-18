<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Core\Models\Setting;
use Core\Models\Location\City;
use Core\Models\Location\District;
use Core\Models\Location\Neighborhood;
use Core\Models\Page;
use JsonMachine\JsonMachine;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Core\Models\Auth\User::factory(10)->create();
        \Core\Models\Product\Product::factory(10)->create();
        \Core\Models\Product\ProductCategory::factory(5)->create();
        \Core\Models\Product\Subcategory::factory(5)->create();
        \Blog\Models\Post::factory(5)->create();
        \Blog\Models\PostCategory::factory(5)->create();
        \Blog\Models\PostTag::factory(5)->create();
        \Core\Models\Coupon::factory(5)->create();
        // \App\Models\Auth\Address::factory(5)->create();

        // General settings
        $siteSettings = [
            'title' => 'Mercury',
            'description' => 'Mercury helps you to create e-commerce sites.',
            'logo' => 0,
            'service_mode' => false,
            'email' => 'test@test.test',
            'phone' => '+00 000 000 00 00',
            'facebook_url' => 'https://facebook.com',
            'instagram_url' => 'https://instagram.com',
            'twitter_url' => 'https://twitter.com',
            'youtube_url' => 'https://youtube.com',
            'linkedin_url' => 'https://linkedin.com',
            'tiktok_url' => 'https://tiktok.com',
        ];

        Setting::create([
            'key' => 'site',
            'value' => json_encode($siteSettings),
        ]);

        // Integration settings
        $integrationSettings = [
            'google_analytics' => '',
        ];

        Setting::create([
            'key' => 'integration',
            'value' => json_encode($integrationSettings),
        ]);

        // E-mail settings
        $mailSettings = [
            'smtp_server_address' => '',
            'smpt_port' => '465',
            'email_username' => '',
            'email_password' => '',
            'email_from_name' => ''
        ];

        Setting::create([
            'key' => 'email',
            'value' => json_encode($mailSettings),
        ]);

        // Shipment settings
        $shipment = [
            [
                'id' => md5('Test Method' . date('h:i:s-d.m.Y')),
                'name' => 'Test Method',
                'price' => 10
            ]
        ];

        Setting::create([
            'key' => 'shipment',
            'value' => json_encode($shipment),
        ]);

        // Product settings
        $dbcl = [ // Delivery by courier locations
            [
                'region' => 'Bursa',
                'districts' => [
                    [
                        'name' => 'Dumlupınar Mah.',
                        'price' => 20.00,
                    ]
                ]
            ]
        ];

        $productSettings = [
            'delivery_information' => "Shipment information",
            'delivery_by_courier_locations' => $dbcl,
        ];

        Setting::create([
            'key' => 'product',
            'value' => json_encode($productSettings),
        ]);

        // Frontpage settings
        $frontpageSettings = [
            'main_slider' => [
                [
                    'title' => 'Slide 1',
                    'description' => 'Slide 1 Description',
                    'image' => 0,
                    'button' => [
                        'text' => 'Order Now',
                        'url' => '#'
                    ]
                ]
            ],
            'what_we_do' => [
                'title' => 'Title',
                'description' => "Description.",
                'images' => [
                    0,
                    0,
                    0,
                    0
                ]
            ],
            'online_order_cta' => [
                'title' => "Try Ordering Online!",
                'description' => "Try Ordering Online text description.",
                'images' => [
                    0,0,0,0
                ],
                'button' => [
                    'text' => 'Order Online',
                    'url' => '/order-online'
                ]
            ],
            'the_story' => [
                'title' => 'About Us',
                'description' => "About us long text.",
                'button' => [
                    'text' => 'About us',
                    'url' => '/about-us'
                ],
                'image' => 0
            ],
            'product_showcase' => [
                'title' => 'Products',
                'description' => 'Products description.',
                'button' => [
                    'text' => 'See All',
                    'url' => '#'
                ]
            ]
        ];

        Setting::create([
            'key' => 'frontpage',
            'value' => json_encode($frontpageSettings),
        ]);

        // Menu settings
        $menu_settings = [
            'special' => [
                [
                    'title' => 'Special Day',
                    'url' => '#'
                ]
            ],
            'header' => [
                [
                    'title' => 'Online Order',
                    'url' => '/online-order'
                ],
                [
                    'title' => 'Menu',
                    'url' => '/menu'
                ],
                [
                    'title' => 'Products',
                    'items' => [
                        [
                            'title' => 'Cakes',
                            'items' => [
                                [
                                    'title' => 'Special Cakes',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Mini Cakes',
                                    'url' => '#'
                                ]
                            ]
                        ],
                        [
                            'title' => 'Desserts',
                            'items' => [
                                [
                                    'title' => 'Milky',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Sugary',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Petitfour',
                                    'url' => '#'
                                ]
                            ]
                        ],
                        [
                            'title' => 'Bakery',
                            'items' => [
                                [
                                    'title' => 'Boreks',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Simit',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Breads',
                                    'url' => '#'
                                ]
                            ]
                        ],
                        [
                            'title' => 'Hots',
                            'items' => [
                                [
                                    'title' => 'Pizza',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Pasta',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Pide',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Burger',
                                    'url' => '#'
                                ]
                            ]
                        ],
                        [
                            'title' => 'Drinsk',
                            'items' => [
                                [
                                    'title' => 'Hot Drinks',
                                    'url' => '#'
                                ],
                                [
                                    'title' => 'Cold Drinks',
                                    'url' => '#'
                                ]
                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'Contact',
                    'url' => '/contact'
                ],
                [
                    'title' => 'Blog',
                    'url' => '/blog'
                ]
            ],
            'footer' => [
                [
                    'title' => 'Company',
                    'items' => [
                        [
                            'title' => 'About us',
                            'url' => '/about-us'
                        ],
                        [
                            'title' => 'Branches',
                            'url' => '#'
                        ],
                        [
                            'title' => 'Contact',
                            'url' => '/contact'
                        ],
                        [
                            'title' => 'GPDDR & Privacy',
                            'url' => '/gpddr-and-privacy'
                        ]
                    ]
                ],
                [
                    'title' => 'Account',
                    'items' => [
                        [
                            'title' => 'Login',
                            'url' => route('store.login')
                        ],
                        [
                            'title' => 'Register',
                            'url' => route('store.register')
                        ],
                        [
                            'title' => 'Track Order',
                            'url' => route('store.orders')
                        ]
                    ]
                ],
                [
                    'title' => 'Helpful Links',
                    'items' => [
                        [
                            'title' => 'Sitemap',
                            'url' => '#'
                        ],
                        [
                            'title' => 'Online Order',
                            'url' => '/online-order'
                        ]
                    ]
                ]
            ]
        ];

        Setting::create([
            'key' => 'menu',
            'value' => json_encode($menu_settings)
        ]);

        $branchSettings = [
            [
                'id' => md5('Dumlupınar Mah.' . date('d.m.Y:h:i:s')),
                'slug' => 'dumlupinar',
                'name' => 'Dumlupınar Mah.',
                'address' => 'Dumlupınar mh. Cumhuriyet cd. No. 102 Nilüfer / BURSA',
                'phone' => '(000) 000 00 00',
                'image' => 0,
                'embed_url' => '#',
                'map_url' => '#'
            ]
        ];

        Setting::create([
            'key' => 'branches',
            'value' => json_encode($branchSettings)
        ]);

        // Special pages
        $kvkkPage = [
            'title' => 'GPDDR & Privacy',
            'content' => 'asdfasdf',
            'slug' => 'gpddr-and-privacy', 
        ];

        Page::create($kvkkPage);

        $cookiePage = [
            'title' => 'Cookie Policy',
            'content' => 'Cookie policy',
            'slug' => 'cookie-policy',
        ];

        Page::create($cookiePage);

        $this->call([
            \Database\Seeders\PageSeeder::class,
        ]);
    }
}
