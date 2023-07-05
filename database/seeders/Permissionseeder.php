<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Permissionseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'admin']);
        $permission=[
            ['name'=>'class list'],
            ['name'=>'class create'],
            ['name'=>'class update'],
            ['name'=>'class delete'],

            ['name'=>'student list'],
            ['name'=>'student create'],
            ['name'=>'student update'],
            ['name'=>'student delete'],

            ['name'=>'teacher list'],
            ['name'=>'teacher create'],
            ['name'=>'teacher update'],
            ['name'=>'teacher delete'],

            ['name'=>'finance list'],
            ['name'=>'finance create'],
            ['name'=>'finance update'],
            ['name'=>'finance delete'],

            ['name'=>'attendence manage'],
            ['name'=>'sms manage'],

     
            ['name'=>'exam create'],
            ['name'=>'exam update'],
            ['name'=>'exam delete'],
            ['name'=>'exam list'],
            
            ['name'=>'result list'],

            ['name'=>'result create'],
            ['name'=>'result update'],
            ['name'=>'result delete'],

            ['name'=>'library list'],
            ['name'=>'library create'],
            ['name'=>'library update'],
            ['name'=>'library delete'],

            ['name'=>'setting manage'],
            ['name'=>'addon manage'],

       
        ];
        foreach($permission as $item){
            Permission::create($item);
        }
        
        $role->syncPermissions(Permission::all());
        $school =School::first();
        $school->assignRole($role);
    }
}
