<?php

use Illuminate\Database\Seeder;

class EmailTemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('email_templates')->delete();
        
        \DB::table('email_templates')->insert(array (
            0 => 
            array (
                'id' => 2,
                'uuid' => '762ece0b-8cf9-43f5-9704-6d6480a682e4',
                'title' => 'contact us',
                'subject' => 'contact us',
                'body' => '<p><strong>Full Name : </strong>[USER_FULL_NAME]</p>

<p><strong>Email : </strong>[EMAIL]</p>

<p><strong>Phone : </strong>[PHONE]</p>

<p><strong>Subject : </strong>[SUBJECT]</p>

<p><strong>Message : </strong>[MESSAGE]</p>',
                'slug' => 'contact-us',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-01-06 10:48:56',
                'updated_at' => '2020-01-31 07:26:57',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 3,
                'uuid' => '990a12d7-03f9-44df-b98c-f5b927e29ed9',
                'title' => 'Order Email To User',
                'subject' => 'Paper Download Link',
            'body' => '<p>Please click below on the Download to download the paper(s) ordered. The papers are for your personal and private use only.</p>',
                'slug' => 'order-email-to-user',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-01-30 13:32:04',
                'updated_at' => '2020-01-31 07:27:18',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 4,
                'uuid' => 'e4f99328-1892-4ae1-aa75-e14d87eec4b9',
                'title' => 'Order Email To Admin',
                'subject' => 'Paper Download Link',
            'body' => '<p>Please click below on the Download to download the paper(s) ordered. The papers are for your personal and private use only.</p>',
                'slug' => 'order-email-to-admin',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-01-30 13:32:41',
                'updated_at' => '2020-01-31 07:27:32',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 5,
                'uuid' => '3c657429-1c5f-419a-ab29-97e164513132',
                'title' => 'Review Feedback',
                'subject' => 'Review Feedback Details',
                'body' => '<p><strong>Full Name : </strong>[USER_FULL_NAME]<br />
<br />
<strong>Email : </strong>[EMAIL]</p>',
                'slug' => 'review-feedback',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-01-30 13:33:08',
                'updated_at' => '2020-01-31 07:27:59',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 6,
                'uuid' => '598fa44b-422a-4da3-b003-5addeb2ea670',
                'title' => 'Review Feedback Reminder',
                'subject' => 'Feedback Reminder',
                'body' => '<p>Please provide us feedback</p>',
                'slug' => 'review-feedback-reminder',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-01-30 13:33:40',
                'updated_at' => '2020-02-04 11:05:13',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 10,
                'uuid' => '08e61933-f2ce-4f3f-8567-27ebe02378c1',
                'title' => 'Review and Rate',
                'subject' => 'User Review',
                'body' => '<p>You have received a review </p>',
                'slug' => 'review-and-rate',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-02 13:31:41',
                'updated_at' => '2020-12-02 13:31:41',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 9,
                'uuid' => '4cecfc61-de7c-414b-a2cc-59d2fa639ca3',
                'title' => 'Forgot password',
                'subject' => 'Link to reset password',
                'body' => '<p>Hello <strong>[USER_FULL_NAME]</strong>,<br />
<br />
please click on to link <strong>[LINK]</strong> to reset password</p>',
                'slug' => 'forgot-password',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-02 13:29:06',
                'updated_at' => '2020-12-18 14:23:38',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'uuid' => '3be00878-746f-44aa-97b2-e152992405c1',
                'title' => 'Parent Registration',
                'subject' => 'Verification Link For Registration',
                'body' => '<h2>Thanks for Joining</h2>

<p>Hello <strong>[USER_FULL_NAME]</strong>,<br />
<br />
please click on to link <strong>[LINK]</strong> to verify your account.</p>',
                'slug' => 'parent-registration',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-02 13:24:57',
                'updated_at' => '2020-12-18 14:23:45',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 11,
                'uuid' => '1db5f5a6-52bd-4bc9-9b0b-a33a75cff4cc',
                'title' => 'Update Password',
                'subject' => 'Password Updated',
                'body' => '<p>Hello <strong>[USER_FULL_NAME]</strong>,<br />
<br />
your password was successfully updated .</p>',
                'slug' => 'update-password',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-02 13:33:56',
                'updated_at' => '2020-12-21 04:31:35',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 13,
                'uuid' => '09e0281b-472e-420c-82b6-184d870353c9',
                'title' => 'Child Login Detail',
                'subject' => 'Child Login Detail',
                'body' => '<h2>Child Login Detail</h2>

<p>&nbsp;</p>

<p><strong>Username :</strong> [USER_NAME]<br />
<strong>Password&nbsp; : </strong>[PASSWORD]<br />
<strong>ChildID&nbsp; :</strong> [CHILD_ID]</p>',
                'slug' => 'child-login-detail',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-21 11:41:22',
                'updated_at' => '2020-12-21 11:44:31',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 12,
                'uuid' => 'e411ff52-978c-46ea-a8f6-54ba242c7405',
                'title' => 'Purhased Order',
                'subject' => 'Purchase Billing Details',
                'body' => '<p>Thank you for purchasing emock.Below are the details of purchased order.</p>',
                'slug' => 'purhased-order',
                'status' => 1,
                'project_type' => 0,
                'created_at' => '2020-12-02 13:37:38',
                'updated_at' => '2020-12-21 12:19:42',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}