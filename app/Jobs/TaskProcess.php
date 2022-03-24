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

    /**
     * Create a new job instance.
     *
     * @return void
     */

    // $line ;

    public $task_id ;
    public $batch_id ;
    public $line ;
    public $task_type ;

   
    
    

    public function __construct($task_id,$batch_id,$line,$task_type)
    {
        
        // this->$line = $line ;
        $this->task_id = $task_id ; 
        $this->batch_id= $batch_id ; 
        $this->line= $line ; 
        $this->task_type= $task_type ; 
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
        
    public function handle()
    {
        $task_type = $this->task_type;

        // send started time to db
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
        
        // updating progress and occurrences line by line
        self::updateProgressToDb();

       // send finished time to db
        self::updateFinishedDateToDb();

    }


    public function failed(Throwable $exception)
    {
        // Send user notification of failure, etc...
    }








    private function lineCountToDb()
    {
        $taskID = $this->task_id ;
        $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
        $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + 1;
        Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
   }


   private function wordsCountToDb()
   {
       $taskID = $this->task_id ;
       $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
       $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + str_word_count($this->line);
       Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
  }

  private function charactersCountToDb()
  {
      $taskID = $this->task_id ;
      $cureent_occurence = Task::where('task_id', $taskID)->get('occurrences');
      $new_occurence = ($cureent_occurence[0]->{'occurrences'}) + strlen($this->line);
      Task::where('task_id', $taskID)->update(['occurrences' => $new_occurence]);
 }







 private function updateProgressToDb() {

    $taskID = $this->task_id ;
    $batch_id = $this->batch_id ;
    $batch = Bus::findBatch($batch_id);
    $progress = $batch->progress();
    
    Task::where('task_id', $taskID)->update(['result' => intval($progress)]);

 }

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

private function updateStartedDateToDb() {

    $taskID = $this->task_id ;
    $batch_id = $this->batch_id ;
    $batch = Bus::findBatch($batch_id); 
    $processedJobs = $batch->processedJobs();

    if($processedJobs == 1) {
        Task::where('task_id', $taskID)->update(['started_at' => Carbon::now() ]);
    }
}

// ----------- Don't need it , will handled in frontend if occ = 0 -> failed 
// private function checkFailedTasks() {
//     $taskID = $this->task_id ;
//     $number_of_occurence = Task::where('task_id', $taskID)->get('occurrences');
//     if($number_of_occurence == 0) {
//         Task::where('task_id', $taskID)->update(['ended_at' => Carbon::now() ]);
//     }

//    }








        
  }






