<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Bus;
use Carbon\Carbon ;


class TaskProcess implements ShouldQueue
{
    use  Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  
    // properties
    public $task_id ;
    public $batch_id ;
    public $line ;
    public $task_type ;

    // constructor 
    public function __construct($task_id,$batch_id,$line,$task_type)
    {
        
        // this->$line = $line ;
        $this->task_id = $task_id ; 
        $this->batch_id= $batch_id ; 
        $this->line= $line ; 
        $this->task_type= $task_type ; 
        
    }

     // job handling method 
    public function handle()
    {
        $task_type = $this->task_type;

        // update starting time to db
        self::updateStartedDateToDb();

        // Checking for task type and invoke the suitable method

        if($task_type == "Count lines") {
            self::lineCountToDb() ;
        }
        
        if($task_type == "Count words") {
            self::wordsCountToDb() ;
        }

        if($task_type == "Count characters") {
            self::charactersCountToDb();
        }
        
        // update progress and occurrences line by line
        self::updateProgressToDb();

        // update project status
        self::updateProjectStatusToDb();

       // update finished time to db
        self::updateFinishedDateToDb();

    }


    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }

    // fn to update starting time to db
    private function updateStartedDateToDb() {

        $taskID = $this->task_id ;
        $batch_id = $this->batch_id ;
        $batch = Bus::findBatch($batch_id); 
        $processedJobs = $batch->processedJobs();
    
        if($processedJobs == 1) {
            Task::where('task_id', $taskID)->update(['started_at' => Carbon::now() ]);
        }
    }

    // fn to count lines and update occurrences in the db
    private function lineCountToDb()
    {
        $taskID = $this->task_id ;
        $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
        $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + 1;
        Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
   }

    // fn to count words and update occurrences in the db
   private function wordsCountToDb()
   {
       $taskID = $this->task_id ;
       $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
       $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + str_word_count($this->line);
       Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
  }

    // fn to count characters and update occurrences in the db
  private function charactersCountToDb()
  {
      $taskID = $this->task_id ;
      $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
      $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + strlen($this->line);
      Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
 }

    // fn to update progress and occurrences line by line
    private function updateProgressToDb() {

        $taskID = $this->task_id ;
        $batch_id = $this->batch_id ;
        $batch = Bus::findBatch($batch_id);
        $progress = $batch->progress();
        
        Task::where('task_id', $taskID)->update(['result' => intval($progress)]);

    }

     // fn to update project status
     private function updateProjectStatusToDb() {

        $taskID = $this->task_id ;

        $batch_id = $this->batch_id ;
        $batch = Bus::findBatch($batch_id); 
        $finished_at = $batch->{'finishedAt'} ;
        $progress = $batch->progress();

    
        // if the project is running
        if($progress !== 100 && $progress !== 0) {
            $project_id =  Task::where('task_id', $taskID)->first(['project_id'])->project_id ;
            Project::where('project_id', $project_id)->update(['running' => 'Yes' ]);
        }

        // if the project is not running
        if($progress == 100 ) {
            $project_id =  Task::where('task_id', $taskID)->first(['project_id'])->project_id ;
            Project::where('project_id', $project_id)->update(['running' => 'No' ]);
        }
        
    }


    // fn to update finished time to db
    private function updateFinishedDateToDb() {

        $taskID = $this->task_id ;
        $batch_id = $this->batch_id ;
        $batch = Bus::findBatch($batch_id); 
        $finished_at = $batch->{'finishedAt'} ;
        $progress = $batch->progress();

        if($progress == 100) {
            Task::where('task_id', $taskID)->update(['ended_at' => Carbon::now() ]);
        }
    }

   




        
}



