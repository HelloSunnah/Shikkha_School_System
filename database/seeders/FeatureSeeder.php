<?php

namespace Database\Seeders;

use App\Models\FeatureList;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $features=[
            ['name'=>'dashboard',
             'status'=>1
            ],
            ['name'=>'Online Admission',
              'status'=>1
            ],
            ['name'=>'Admission Request',
             'status'=>1
            ],

            ['name'=>'Class Show',
             'status'=>1 
            ],
            ['name'=>'Section Show',
              'status'=>1
            ],
            ['name'=>'Class Syllabus',
              'status'=>1
            ],
            ['name'=>'Subject Show',
              'status'=>1
            ],
            ['name'=>'Class Period',
              'status'=>1
            ],
            ['name'=>'Class Routine',
              'status'=>1
            ],
            ['name'=>'School RoutineShow',
             'status'=>1
            ],

            ['name'=>'Student Show',
             'status'=>1
            ],
            ['name'=>'Student Create',
             'status'=>1
            ],

            ['name'=>'Teacher Show',
             'status'=>1
            ],
            ['name'=>'Assign TeacherClass',
              'status'=>1
            ],

            ['name'=>'Staff List',
             'status'=>1
            ],
            ['name'=>'Staff Type',
             'status'=>1
            ],

            ['name'=>'Student Attendence Dashboard',
              'status'=>1
            ],
            ['name'=>'Student Attendence',
              'status'=>1
            ],
            ['name'=>'Student Attendence View',
              'status'=>1
            ],
            ['name'=>'Upload Attendance Student',
              'status'=>1
            ],
            ['name'=>'Get Attendance Student',
             'status'=>1
            ],
            ['name'=>'Custom Attendance Student',
             'status'=>1
            ],
            ['name'=>' Auto Attendance Student',
              'status'=>1
            ],

            ['name'=>'Teacher Attendance Dashboard',
              'status'=>1
            ],
            ['name'=>'Teacher Take Attendance',
              'status'=>1
            ],
            ['name'=>'Teacher View Attendance',
              'status'=>1
            ],

            ['name'=>'Staff Take Attendance',
             'status'=>1
            ],
            ['name'=>'Staff View Attendance',
             'status'=>1
            ],

            ['name'=>'Finance Dashboard',
             'status'=>1
            ],
            ['name'=>'Finance School Fees',
             'status'=>1
            ],
            ['name'=>'Finance Assign Fees',
             'status'=>1
            ],
            ['name'=>'Finance Collect Fees',
             'status'=>1
            ],
            ['name'=>'Finance Staff Salary',
             'status'=>1
            ],
            ['name'=>'Finance Teacher Salary',
             'status'=>1
            ],
            ['name'=>'Finance Bank Account',
             'status'=>1
            ],
            ['name'=>'Finance Expenses',
              'status'=>1
            ],
            ['name'=>'Finance Expenses List',
             'status'=>1
            ],
            ['name'=>'Finance Funds',
             'status'=>1
            ],
            ['name'=>'Finance Funds List',
             'status'=>1
            ],
            ['name'=>'Finance Accessories Receipt',
             'status'=>1
            ],
            ['name'=>'Finance Student Finance Status',
             'status'=>1
            ],

            ['name'=>'SMS Student',
             'status'=>1
            ],
            ['name'=>'SMS Teacher',
             'status'=>1
            ],
            ['name'=>'SMS Employee',
             'status'=>1
            ],
            ['name'=>'SMS Purchase',
             'status'=>1
            ],

            ['name'=>' Exam Terms',
             'status'=>1
            ],
            ['name'=>' Exam Routine Create',
             'status'=>1
            ],
            ['name'=>'Question Create',
             'status'=>1
            ],
            ['name'=>'Question Show',
             'status'=>1
            ],
            ['name'=>'Admit Card',
             'status'=>1
            ],
            ['name'=>'Sit Plan',
             'status'=>1
            ],

            ['name'=>'Result Upload',
             'status'=>1
            ],
            ['name'=>'Result SMS',
             'status'=>1
            ],
            ['name'=>'See Result',
             'status'=>1
            ],
            ['name'=>'Result Pdf',
             'status'=>1
            ],

            ['name'=>'Notice',
             'status'=>1
            ],

            ['name'=>'Borrower Info',
             'status'=>1
            ],
            ['name'=>'Book Info',
             'status'=>1
            ],

            ['name'=>'Role Show Info',
             'status'=>1
            ],
            ['name'=>'Role Permission',
             'status'=>1
            ],
            
            ['name'=>' Setting Class',
             'status'=>1
            ],
            ['name'=>' Setting Fingerprint Device',
             'status'=>1
            ],
            ['name'=>' Addons',
             'status'=>1
            ],
        ];
        foreach($features as $feature){
            FeatureList::insert([
                'name' =>  $feature['name'],
                'status'   =>  $feature['status']
            ]);
        }
    }
}
