<?php
namespace Database\Seeders;
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
                'id' => 1,
                'type' => 'reset_password',
                'subject' => 'Reset Password',
                'content' => '<div style=" padding:10px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                <h3 style=" font-size: 22px; font-family: Segoe, \'Segoe UI\', \'sans-serif\'; margin-top: 20px;color: #000000;">Reset Your Password</h3>
                <h3 style="font-size:18px;line-height: 25px;font-weight: normal;">
                Hi {{name}},
                </h3>
                <h3 style="font-size:18px;line-height: 25px;font-weight: normal;">
                We need to be sure it is you trying to reset password in to your {{app_name}} account.
                </h3>

                <p style="font-size:17px;line-height: 25px;font-weight: normal;margin-top: 40px;margin-bottom: 40px;color: #555;">Here is your authentication code:{{link}}</p>
                <p style="font-size:17px;line-height: 25px;font-weight: normal;margin-top: 40px;margin-bottom: 40px;color: #555;">Please keep in mind that you will also be asked to enter your 6-digit PIN.</p>
                </div>
                <div style=" padding:30px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                <div style="font-size: 15px; color: #555;">
                <p style="font-size: 15px; font-style: italic; font-weight: 600; margin-bottom: 0;">Cheers,</p>
                {{app_name}}
                </div>
                </div>',
                'info' => '{"name":"User full name","link":"Link for reset password","app_name":"Website name"}',
                'status' => 1,
                'created_at' => '2019-11-13 17:38:27',
                'updated_at' => '2021-01-06 09:43:28',
            ),
            1 =>
            array (
                'id' => 2,
                'type' => 'sign_up_confirmation',
                'subject' => 'Sign up Confirmation',
                'content' => '<div style=" padding:10px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                    <h3 style=" font-size: 22px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\'; margin-top: 20px;">Verify Your Email To Start Using {{app_name}}</h3>
                    <h3 style="font-size:18px;line-height: 25px;font-weight: normal;">
                    Hi  {{name}},
                    </h3>
                    <h3 style="font-size:18px;line-height: 25px;font-weight: normal;">
                    Thank you for signing up. Click the button below to verify your {{app_name}} account.
                    </h3>
                    <div style="margin: 40px 0; text-align:center;">
                    <a href="{{link}}" target="_blank" style="display: inline-block;padding: 12px 15px;font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif;font-size: 16px;color: #ffffff;text-decoration: none;border-radius: 6px;width: 150px;background-color:#e61a59;text-align: center;">Verify Email Address</a>
                    </div>
                    <p style="font-size:17px;line-height: 25px;font-weight: normal;margin-top: 40px;margin-bottom: 40px;color: #555;">If that doesnt work, copy and paste the following link in your browser: <a href="{{link}}" target="_blank">{{link}}</a></p>
                    <p style="font-size:17px;line-height: 25px;font-weight: normal;color: #555;">If you did not create an account, no further action is required.</p>
                    </div>
                    <div style=" padding:30px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                    <div style="margin-top: 30px;  font-size: 15px; color: #555;">
                    <p style="font-size: 15px; font-style: italic; font-weight: 600; margin-bottom: 0;">Cheers,</p>
                    {{app_name}}
                    </div>
                    </div>',
                'info' => '{"name":"User full name","link":"Link for Verify Email Address","app_name":"Website name"}',
                'status' => 1,
                'created_at' => '2019-12-03 18:28:21',
                'updated_at' => '2021-01-06 08:10:36',
            ),
            2 =>
            array (
                'id' => 3,
                'type' => 'user_liked',
                'subject' => 'User Liked You',
                'content' => '<div style=" padding:10px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                <h3 style=" font-size: 22px; font-family: Segoe, \'Segoe UI\', \'sans-serif\'; margin-top: 20px;color: #000000;">User Liked You</h3><h3 style="font-size:18px;line-height: 25px;font-weight: normal;">
                Hi {{name}},
                </h3>
                <p style="font-size: 17px; line-height: 25px; margin-top: 40px; margin-bottom: 40px; color: rgb(85, 85, 85);"><span style="font-weight: normal;">Please login your account to see user liked your : </span></p>
                <div style=" padding:30px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                <div style="font-size: 15px; color: #555;">
                <p style="font-size: 15px; font-style: italic; font-weight: 600; margin-bottom: 0;">Cheers,</p>
                {{app_name}}
                </div>
                </div>',
                'info' => '{"name":"User full name","app_name":"Website name"}',
                'status' => 1,
                'created_at' => '2020-02-28 07:34:55',
                'updated_at' => '2021-01-06 12:54:01',
            ),
            3 =>
            array (
                'id' => 4,
                'type' => 'send_password',
                'subject' => 'Account Password',
                'content' => '<div style=" padding:10px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                <h3 style=" font-size: 22px; font-family: Segoe, \'Segoe UI\', \'sans-serif\'; margin-top: 20px;color: #000000;">Account Password</h3><h3 style="font-size:18px;line-height: 25px;font-weight: normal;">
                Hi {{name}},
                </h3>
                <p style="font-size: 17px; line-height: 25px; margin-top: 40px; margin-bottom: 40px; color: rgb(85, 85, 85);"><span style="font-weight: normal;">To login your account, please use the following password: </span><b>{{password}}</b></p>
                <p style="font-size: 17px; line-height: 25px; margin-top: 40px; margin-bottom: 40px; color: rgb(85, 85, 85);"><span style="font-weight: normal;">Do not share this password with anyone. {{app_name}} takes your account security very seriously. {{app_name}} will never ask you to disclose your password.</span></p>
                </div>
                <div style=" padding:30px 30px 10px;  font-family: Segoe, \'Segoe UI\', \'sans-serif\';">
                <div style="font-size: 15px; color: #555;">
                <p style="font-size: 15px; font-style: italic; font-weight: 600; margin-bottom: 0;">Cheers,</p>
                {{app_name}}
                </div>
                </div>',
                'info' => '{"name":"User full name","app_name":"Website name","password":"Account Password"}',
                'status' => 1,
                'created_at' => '2020-02-28 07:34:55',
                'updated_at' => '2021-01-06 12:54:01',
            )
        ));
    }
}