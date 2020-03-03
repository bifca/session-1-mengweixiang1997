<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});

Route::post('api', 'index/api');
Route::get('migrate', 'index/migrate');
Route::get('test', 'index/test');
Route::get('admin', 'index/admin');
Route::post('del', 'index/del');
Route::post('upload', 'index/upload');
Route::post('update', 'index/update');
Route::post('add', 'index/add');

