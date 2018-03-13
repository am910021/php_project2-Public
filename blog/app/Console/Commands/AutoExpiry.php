<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\User;

class AutoExpiry extends Command
{
    // 命令名稱
    protected $signature = 'User:AutoExpiry';
    
    // 說明文字
    protected $description = '自動刪除超過24小時未啟用的帳號';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // Console 執行的程式
    public function handle()
    {
        //測試用
         $log_file_path = storage_path('logs/delete_account.log');
//         $log_info = [
//             'date'=>date('Y-m-d H:i:s')
//         ];
//         $log_info_json = json_encode($log_info) . "\r\n";
//         File::append($log_file_path, $log_info_json);
        
        $query = [
            ['isActive',false],
            ['expiry_date','<',Carbon::now()]
            
            
        ];
        $users = User::where($query)->get();
        $format = '帳號 %s 到期日 %s 刪除日 %s';
        //echo sprintf($format, $num, $location);
        foreach ($users as $user){
            File::append($log_file_path, sprintf($format, $user->email, $user->expiry_date, Carbon::now()->toDateTimeString()). "\r\n");
            $user->delete();
        }
        //File::append($log_file_path, count($users)."\r\n");
    }
}