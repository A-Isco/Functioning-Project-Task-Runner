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

    // Go to create task view
    public function create() {
        return view("task.create");
    }

    // Store task in db
    public function store(Request $request) {
        $project_id = $request->project_id ;
        $task_type = $request->task_type ; 
        $file = $request->file('file') ;


        
        // ----------- Validation -----------
        $request -> validate([
            "project_id" => "required | regex : /^(PRJ_[0-9A-Z]{6})$/ " ,
            "task_type" => "required" ,
            "file" => "required" 
        ]) ;
        

        // $file_uploaded = $request->file('file')->store('public');
   
        // ---------- store in Project table -----------------
        self::storeProject($project_id) ;

        // ----------------- store in Task table -----------------
        $task_id = self::storeTask($project_id , $task_type) ;

        // ----------------- Failed Task for empty file -----------------
        self::checkForEmptyFile($file,$task_id) ;

        // ----------------- Invoke count function -----------------
        self::count($file,$task_id,$task_type) ;

        return redirect()->route('projects.all') ;




        // $is_finished =  self::countLines($file,$task_id) ;
        // $batch_id =  self::count($file,$task_id,$task_type) ;
        // $batch = Bus::findBatch($batch_id); 
        // return  $batch  ;
        // return  $task_type  ;
        // return  $batch->{'fi'} ;
        // return  gettype($batch->{'finishedAt'}) ;
        // $value = Task::where('task_id', $taskID)->get('occurrences');
        // echo gettype($value[0]->{'occurrences'});
        // echo gettype(intval($progress))   ;
        // return  gettype($finished) ;
    
    }

    

    // ------------- fn to Store in Project table -------------
    private function storeProject($project_id) {
        $project = Project::where('project_id',$project_id )->exists() ;
        if (!$project) {
        Project::create([
                 'project_id' => $project_id ,
                 'user_id' => Auth::user()->id ,
             ]);
        }

    }

    // ------------- fn to Store in Task table -------------
    private function storeTask($project_id , $task_type) {
        $task_id = Str::random(30);
        Task::create([
                    'project_id' => $project_id ,
                    'task_type' => $task_type ,
                     'task_id' => $task_id ,
                 ])  ;

                 return $task_id ;
    }

   // ------------- fn to check if the file is empty -------------
   private function checkForEmptyFile($file,$task_id) {
    if ( 0 == filesize($file) )
    {
        Task::where('task_id', $task_id)->update(['ended_at' => Carbon::now() ]);
        Task::where('task_id', $task_id)->update(['started_at' => Carbon::now() ]);
        return " Failed Task .. Empty File" ;
    }
   }

   // ------------- fn to send failed task to db (not used) -------------
   private function sendFailedTaskToDb($task_id) {
    Task::where('task_id', $task_id)->update(['ended_at' => Carbon::now() ]);
    Task::where('task_id', $task_id)->update(['started_at' => Carbon::now() ]);
   }

    // ------------- read file line by line -------------
    private function count($file,$task_id,$task_type) {
        // $count_line = 0 ; 
        // Open file handler
        $fh = fopen($file, "r");

        $batch = Bus::batch([])->dispatch();
        $batch_id = $batch->id ;
        // Read line by line
        while(($line=fgets($fh))!==false) {

            $batch->add(new TaskProcess($task_id,$batch_id,$line,$task_type) ) ;
            // TaskProcess::dispatch($task_id) ;
            // $count_line ++ ;
            
        }
        // Close file handler
        
        fclose($fh) ;

        // $batch = Bus::findBatch($batch_id); 
        $project_id =  Task::where('task_id', $task_id)->first(['project_id'])->project_id ;
        // get(['project_id']);

        // return $batch->finished();
        // return  dd($project_id);

        // echo $count_line ;
    }

    // OG Copy of the fn
    // public function countLines($file) {
    //     $count_line = 0 ; 
    //     // Open file handler
    //     $fh = fopen($file, "r");
    //     // Read line by line
    //     while(($line=fgets($fh))!==false) {
    //         $count_line ++ ;
    //         // dispatch job (reading line and update progress and dbis a single job )
    //         // we will pass the line as a parameter to the job 
    //         // maybe we will need also to pas the task_id to be able to update that specefic task in the db
    //     }
    //     // Close file handler
    //     fclose($fh) ;

    //     echo $count_line ;
    // }

    // ------------- read file line by words -------------
    
    private function countWords($file) {
        $count_words = 0 ; 
        // Open file handler
        $fh = fopen($file, "r");
        // Read line by line
        while(($line=fgets($fh))!==false) {
            echo str_word_count($line);
            $count_words += str_word_count($line) ;
        }
        // Close file handler
        fclose($fh) ;
        echo $count_words ;

        // return $count_words  ;

        // pass the file to the task job
    }


}












      /* 
        $this->output->progressStart(countLne(file.txt));
        foreach ($users as $user) {
    print "$user->name\n";

    $this->output->progressAdvance();
}

$this->output->progressFinish();

        countLne() {
            for(parseLine())
            {
                countedLines ++
                updateprocesstodb(countedLines)
            }
        } -> parse lines
       sentprocesstodb() 
       
       */ 