<?php
namespace App\Traits;

trait AdminPermission {
    public function checkRequestPermission()
    {
        if (
            empty(auth()->user()->permission['permission']['result']['list']) && \Route::is('result.teacher.create.show.all')
        ) {
            return redirect()->route('teacher.dashboard');
        }
    }
}
?>