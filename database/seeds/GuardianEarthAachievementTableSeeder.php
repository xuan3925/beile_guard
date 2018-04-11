<?php
/**
 * @author xueyu
 * php artisan db:seed --class=GuardianEarthAachievementTableSeeder
 */

use Illuminate\Database\Seeder;

use App\Models\GuardianEarthAchievement;

class GuardianEarthAachievementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'name'      => '志愿者',
                'module'    => GuardianEarthAchievement::JOIN,
                'condition' => 1,
                'intro'     => '参与守护活动即可点亮',
                'add_exp'   => 0,
                'sort'      => 1,
                'images_prefix' => 'zyz',
            ],
            [
                'name'      => '见习卫士',
                'module'    => GuardianEarthAchievement::EXP,
                'condition' => 20000,
                'intro'     => '守护值累积达到{num}即可点亮',
                'add_exp'   => 0,
                'sort'      => 2,
                'images_prefix' => 'jxws',
            ],
            [
                'name'      => '持之以恒',
                'module'    => GuardianEarthAchievement::LOGIN,
                'condition' => 7,
                'intro'     => '连续登陆{num}天即可点亮<br>守护值+666',
                'add_exp'   => 0,
                'sort'      => 3,
                'images_prefix' => 'czyh',
            ],
            [
                'name'      => '人气卫士',
                'module'    => GuardianEarthAchievement::SHARE,
                'condition' => 10,
                'intro'     => '分享达到{num}次即可点亮<br>守护值+6666',
                'add_exp'   => 0,
                'sort'      => 4,
                'images_prefix' => 'rqws',
            ],
            [
                'name'      => '保卫战士',
                'module'    => GuardianEarthAchievement::EXP,
                'condition' => 70000,
                'intro'     => '守护值累积达到{num}即可点亮<br>守护值+6666',
                'add_exp'   => 6666,
                'sort'      => 5,
                'images_prefix' => 'bwzs',
            ],
            [
                'name'      => '最强使者',
                'module'    => GuardianEarthAchievement::EXP,
                'condition' => 100000,
                'intro'     => '守护值累积达到{num}即可点亮',
                'add_exp'   => 0,
                'sort'      => 6,
                'images_prefix' => 'zqsz',
            ],
        ];

        foreach ($datas as $k => $data) 
        {
            GuardianEarthAchievement::create($data);
        }
    }
}
