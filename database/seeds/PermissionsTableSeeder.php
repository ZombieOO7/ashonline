<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                
                'name' => 'user view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            1 => 
            array (
                
                'name' => 'user create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            2 => 
            array (
                
                'name' => 'user edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            3 => 
            array (
                
                'name' => 'user delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            4 => 
            array (
                
                'name' => 'user multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            5 => 
            array (
                
                'name' => 'admin view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            6 => 
            array (
                
                'name' => 'admin create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            7 => 
            array (
                
                'name' => 'admin edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            8 => 
            array (
                
                'name' => 'admin delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            9 => 
            array (
                
                'name' => 'admin multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            10 => 
            array (
                
                'name' => 'role view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            11 => 
            array (
                
                'name' => 'role create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            12 => 
            array (
                
                'name' => 'role edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            13 => 
            array (
                
                'name' => 'role delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            14 => 
            array (
                
                'name' => 'role multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            15 => 
            array (
                
                'name' => 'permission view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            16 => 
            array (
                
                'name' => 'permission create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            17 => 
            array (
                
                'name' => 'permission edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            18 => 
            array (
                
                'name' => 'permission delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            19 => 
            array (
                
                'name' => 'permission multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            20 => 
            array (
                
                'name' => 'user active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            21 => 
            array (
                
                'name' => 'user multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            22 => 
            array (
                
                'name' => 'user multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            23 => 
            array (
                
                'name' => 'admin active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            24 => 
            array (
                
                'name' => 'admin multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            25 => 
            array (
                
                'name' => 'admin multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            26 => 
            array (
                
                'name' => 'page view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            27 => 
            array (
                
                'name' => 'page create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            28 => 
            array (
                
                'name' => 'page edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            29 => 
            array (
                
                'name' => 'page delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            30 => 
            array (
                
                'name' => 'page multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            31 => 
            array (
                
                'name' => 'contact us create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            32 => 
            array (
                
                'name' => 'contact us edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            33 => 
            array (
                
                'name' => 'contact us view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            34 => 
            array (
                
                'name' => 'contact us delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            35 => 
            array (
                
                'name' => 'contact us multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            36 => 
            array (
                
                'name' => 'web setting view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            37 => 
            array (
                
                'name' => 'web setting create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            38 => 
            array (
                
                'name' => 'web setting update',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:34:57',
                'updated_at' => '2019-12-17 09:34:57',
            ),
            39 => 
            array (
                
                'name' => 'paper category view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:36:06',
                'updated_at' => '2019-12-17 09:36:06',
            ),
            40 => 
            array (
                
                'name' => 'paper category create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:36:20',
                'updated_at' => '2019-12-17 09:36:20',
            ),
            41 => 
            array (
                
                'name' => 'paper category edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:36:29',
                'updated_at' => '2019-12-17 09:36:29',
            ),
            42 => 
            array (
                
                'name' => 'paper category delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:36:37',
                'updated_at' => '2019-12-17 09:36:37',
            ),
            43 => 
            array (
                
                'name' => 'paper category active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:37:09',
                'updated_at' => '2019-12-17 09:37:09',
            ),
            44 => 
            array (
                
                'name' => 'paper category multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:37:18',
                'updated_at' => '2019-12-17 09:37:18',
            ),
            45 => 
            array (
                
                'name' => 'paper category multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:37:29',
                'updated_at' => '2019-12-17 09:37:29',
            ),
            46 => 
            array (
                
                'name' => 'paper category multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:37:41',
                'updated_at' => '2019-12-17 09:37:41',
            ),
            47 => 
            array (
                
                'name' => 'subject view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:38:14',
                'updated_at' => '2019-12-17 09:38:14',
            ),
            48 => 
            array (
                
                'name' => 'subject create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:38:21',
                'updated_at' => '2019-12-17 09:38:21',
            ),
            49 => 
            array (
                
                'name' => 'subject edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:38:34',
                'updated_at' => '2019-12-17 09:38:34',
            ),
            50 => 
            array (
                
                'name' => 'subject delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:39:01',
                'updated_at' => '2019-12-17 09:39:01',
            ),
            51 => 
            array (
                
                'name' => 'subject active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:39:13',
                'updated_at' => '2019-12-17 09:39:13',
            ),
            52 => 
            array (
                
                'name' => 'subject multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:39:29',
                'updated_at' => '2019-12-17 09:39:29',
            ),
            53 => 
            array (
                
                'name' => 'subject multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:39:44',
                'updated_at' => '2019-12-17 09:39:44',
            ),
            54 => 
            array (
                
                'name' => 'subject multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 09:39:52',
                'updated_at' => '2019-12-17 09:39:52',
            ),
            55 => 
            array (
                
                'name' => 'paper view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:16:12',
                'updated_at' => '2019-12-17 12:16:12',
            ),
            56 => 
            array (
                
                'name' => 'paper create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:16:33',
                'updated_at' => '2019-12-17 12:16:33',
            ),
            57 => 
            array (
                
                'name' => 'paper edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:16:55',
                'updated_at' => '2019-12-17 12:16:55',
            ),
            58 => 
            array (
                
                'name' => 'paper delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:17:08',
                'updated_at' => '2019-12-17 12:17:08',
            ),
            59 => 
            array (
                
                'name' => 'paper multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:17:35',
                'updated_at' => '2019-12-17 12:17:35',
            ),
            60 => 
            array (
                
                'name' => 'paper multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:18:06',
                'updated_at' => '2019-12-17 12:18:06',
            ),
            61 => 
            array (
                
                'name' => 'paper multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:18:37',
                'updated_at' => '2019-12-17 12:18:37',
            ),
            62 => 
            array (
                
                'name' => 'paper active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-17 12:19:00',
                'updated_at' => '2019-12-17 12:19:00',
            ),
            63 => 
            array (
                
                'name' => 'exam types view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:41:10',
                'updated_at' => '2019-12-18 05:54:05',
            ),
            64 => 
            array (
                
                'name' => 'exam types create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:41:26',
                'updated_at' => '2019-12-18 05:44:25',
            ),
            65 => 
            array (
                
                'name' => 'exam types edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:41:35',
                'updated_at' => '2019-12-18 05:44:21',
            ),
            66 => 
            array (
                
                'name' => 'exam types delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:41:45',
                'updated_at' => '2019-12-18 05:44:17',
            ),
            67 => 
            array (
                
                'name' => 'exam types active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:42:31',
                'updated_at' => '2019-12-18 05:44:13',
            ),
            68 => 
            array (
                
                'name' => 'exam types multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:42:57',
                'updated_at' => '2019-12-18 05:44:09',
            ),
            69 => 
            array (
                
                'name' => 'exam types multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:43:16',
                'updated_at' => '2019-12-18 05:44:03',
            ),
            70 => 
            array (
                
                'name' => 'exam types multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-18 05:45:20',
                'updated_at' => '2019-12-18 07:19:23',
            ),
            71 => 
            array (
                
                'name' => 'order view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-24 07:49:36',
                'updated_at' => '2019-12-24 07:49:36',
            ),
            72 => 
            array (
                
                'name' => 'stage create',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:38:49',
                'updated_at' => '2019-12-31 07:38:49',
            ),
            73 => 
            array (
                
                'name' => 'stage view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:38:55',
                'updated_at' => '2019-12-31 07:38:55',
            ),
            74 => 
            array (
                
                'name' => 'stage edit',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:39:04',
                'updated_at' => '2019-12-31 07:39:04',
            ),
            75 => 
            array (
                
                'name' => 'stage delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:39:18',
                'updated_at' => '2019-12-31 07:39:18',
            ),
            76 => 
            array (
                
                'name' => 'stage active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:39:28',
                'updated_at' => '2019-12-31 07:39:28',
            ),
            77 => 
            array (
                
                'name' => 'stage multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:39:36',
                'updated_at' => '2019-12-31 07:39:36',
            ),
            78 => 
            array (
                
                'name' => 'stage multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:39:46',
                'updated_at' => '2019-12-31 07:39:46',
            ),
            79 => 
            array (
                
                'name' => 'stage multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 07:39:54',
                'updated_at' => '2019-12-31 07:39:54',
            ),
            80 => 
            array (
                
                'name' => 'order multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:24:26',
                'updated_at' => '2019-12-31 09:24:26',
            ),
            81 => 
            array (
                
                'name' => 'order multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:24:36',
                'updated_at' => '2019-12-31 09:24:36',
            ),
            82 => 
            array (
                
                'name' => 'payment view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:24:56',
                'updated_at' => '2019-12-31 09:24:56',
            ),
            83 => 
            array (
                
                'name' => 'payment multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:25:09',
                'updated_at' => '2019-12-31 09:25:09',
            ),
            84 => 
            array (
                
                'name' => 'payment multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:25:14',
                'updated_at' => '2019-12-31 09:25:14',
            ),
            85 => 
            array (
                
                'name' => 'review view',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:25:30',
                'updated_at' => '2019-12-31 09:25:30',
            ),
            86 => 
            array (
                
                'name' => 'review multiple active',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:25:43',
                'updated_at' => '2019-12-31 09:25:43',
            ),
            87 => 
            array (
                
                'name' => 'review multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 09:25:49',
                'updated_at' => '2019-12-31 09:25:49',
            ),
            88 => 
            array (
                
                'name' => 'review multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 11:27:38',
                'updated_at' => '2019-12-31 11:27:38',
            ),
            89 => 
            array (
                
                'name' => 'review active inactive',
                'guard_name' => 'admin',
                'created_at' => '2019-12-31 13:22:16',
                'updated_at' => '2019-12-31 13:22:16',
            ),
            90 => 
            array (
                
                'name' => 'email template view',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:39:05',
                'updated_at' => '2020-01-06 07:39:05',
            ),
            91 => 
            array (
                
                'name' => 'email template create',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:39:15',
                'updated_at' => '2020-01-06 07:39:15',
            ),
            92 => 
            array (
                
                'name' => 'email template delete',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:39:22',
                'updated_at' => '2020-01-06 07:39:22',
            ),
            93 => 
            array (
                
                'name' => 'email template active inactive',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:39:32',
                'updated_at' => '2020-01-06 07:39:32',
            ),
            94 => 
            array (
                
                'name' => 'email template multiple delete',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:39:56',
                'updated_at' => '2020-01-06 07:39:56',
            ),
            95 => 
            array (
                
                'name' => 'email template multiple active',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:40:08',
                'updated_at' => '2020-01-06 07:40:08',
            ),
            96 => 
            array (
                
                'name' => 'email template multiple inactive',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:40:24',
                'updated_at' => '2020-01-06 07:40:24',
            ),
            97 => 
            array (
                
                'name' => 'email template edit',
                'guard_name' => 'admin',
                'created_at' => '2020-01-06 07:41:06',
                'updated_at' => '2020-01-06 07:41:06',
            ),
        ));
        
        
    }
}