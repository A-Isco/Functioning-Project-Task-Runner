<?php

namespace App\Http\Controllers;

use App\Jobs\TaskProcess;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Carbon\Carbon ;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    // Get create task view
    public function create() {
        return view("task.create");
    }

    // Store task in db
    public function store(Request $request) {

        $project_id = $request->project_id ;
        $task_type = $request->task_type ; 
        $file = $request->file('file') ;

        // Form Validation 
        $request -> validate([
            "project_id" => "required | regex : /^(PRJ_[0-9A-Z]{6})$/ " ,
            "task_type" => "required" ,
            "file" => "required" 
        ]) ;
        

        // Store in Project table 
        self::storeProject($project_id) ;

        // Store in Task table 
        $task_id = self::storeTask($project_id , $task_type) ;

        //  Check Failed Task for empty file 
        self::checkForEmptyFile($file,$task_id) ;

        //  Invoke counting function 
        self::count($file,$task_id,$task_type) ;

        // redirect to all projects view
        return redirect()->route('projects.all') ;
    
    }

    



    //  fn to Store project in Project table 
    private function storeProject($project_id) {
        $project = Project::where('project_id',$project_id )->exists() ;
        if (!$project) {
        Project::create([
                 'project_id' => $project_id ,
                 'user_id' => Auth::user()->id ,
             ]);
        }

    }

    //  fn to Store task in Task table 
    private function storeTask($project_id , $task_type) {
        $task_id = Str::random(30);
        Task::create([
                    'project_id' => $project_id ,
                    'task_type' => $task_type ,
                     'task_id' => $task_id ,
                 ])  ;

                 return $task_id ;
    }

   //  fn to check if the file is empty 
   private function checkForEmptyFile($file,$task_id) {
    if ( 0 == filesize($file) )
    {
        Task::where('task_id', $task_id)->update(['ended_at' => Carbon::now() ]);
        Task::where('task_id', $task_id)->update(['started_at' => Carbon::now() ]);
    }
   }

  

    //  fn to count (Lines/Words/Characters)  depending on the task type
    private function count($file,$task_id,$task_type) {
        
        // open file
        $fh = fopen($file, "r");

        // dispatch the jobs batch
        $batch = Bus::batch([])->dispatch();

        // getting batch id
        $batch_id = $batch->id ;

        // looping through the file line by line
        while(($line=fgets($fh))!==false) {

            // adding jobs to the batch (each line represent a job)
            $batch->add(new TaskProcess($task_id,$batch_id,$line,$task_type) ) ;
            
        }

        // Closing file 
        fclose($fh) ;

        
    }

}










