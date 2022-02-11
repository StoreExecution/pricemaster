<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->get()->count() == 0) {
            DB::table('users')->insert([[
                'name' => "admin",
                'email' =>'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role_id'=>1,

            ],
                [
                    'name' => "sup",
                    'email' =>'sup@gmail.com',
                    'password' => Hash::make('sup'),
                    'role_id'=>2,

                ],
            ]);

            DB::table('suppliers')->insert([[
                'name' => "Initial",
                'adress' =>'',
                'phone' =>'0',
                'latitude' =>'0',
                'longitude' =>'0',
                'user_id' =>'1',



            ],

            ]);

            DB::table('categories')->insert([[
                'id' => 1,
                'name' => "categorie",




            ],

            ]);

            DB::table('sub_categories')->insert([[
                'id' => 1,
                'name' => "sous-categorie",
                'category_id' => 1,




            ],

            ]);

            DB::table('brands')->insert([[
                'id' => 1,
                'name' => "marque",





            ],

            ]);
        }
    }
}
