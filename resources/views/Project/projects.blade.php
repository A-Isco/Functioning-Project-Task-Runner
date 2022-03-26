<?php 

    use App\Models\Task;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  	<!--Bootstrap 3.4.1-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  
  
  
  <div class="container">
          <h1>All Projects</h1>

        <div class="table-container">
        <table>
          <thead>
            <tr class="header">
              <th>Project</th>
              <th>Tasks type</th>
              <th>Recent 5 tasks</th>
              <th>Running</th>
              <th>Link</th>
            </tr>
          </thead>
          <tbody>
          @foreach ($projects as $project)
            <tr>
              <td rowspan="3">{{$project->project_id}}</td>
              <td>Count Words</td>
              <td>
                <!-- ----------- C-Lines Words ----------------- -->

                <?php $last5_count_words = Task::where('project_id', $project->project_id)->where('task_type', 'Count words')
                    ->orderBy('created_at', 'DESC')->take(5)->get();  ?>

                @foreach ($last5_count_words as $task)
                
                <div class=<?php if($task->result == 100) echo "green-dot" ; 
                if($task->result == 0 && $task->ended_at != null) echo "red-dot" ;
                if($task->result !== 100 && $task->result !== 0) echo "blue-dot"; // running
                if($task->started_at == null) echo "yellow-dot" ; // didn't start yet
                ?>></div> 
              
                @endforeach
              </td>
              <td rowspan="3">{{$project->running}}</td>
              <td rowspan="3"><a href="{{route('projects.single',$project->project_id)}}">Project page</a></td>
            </tr>
            <tr>
              <td>Count Lines</td>
              <td>
              
            <!-- ----------- C-Lines Tasks ----------------- -->
                    
            <?php $last5_count_lines = Task::where('project_id', $project->project_id)->where('task_type', 'Count lines')
                        ->orderBy('created_at', 'DESC')->take(5)->get();  ?>

                    @foreach ($last5_count_lines as $task)
                    
                    <div class=<?php if($task->result == 100) echo "green-dot" ; 
                    if($task->result == 0 && $task->ended_at != null) echo "red-dot" ;
                    if($task->result !== 100 && $task->result !== 0) echo "blue-dot"; // running
                    if($task->started_at == null) echo "yellow-dot" ; // didn't start yet
                    ?>></div> 
                  
                    @endforeach
              </td>
            </tr>
            <tr>
              <td>Count Characters</td>
              <td>
                   <!-- ----------- C-Lines Characters ----------------- -->
                <?php $last5_count_characters = Task::where('project_id', $project->project_id)->where('task_type', 'Count characters')
                    ->orderBy('created_at', 'DESC')->take(5)->get();  ?>

                @foreach ($last5_count_characters as $task)
                
                <div class=<?php if($task->result == 100) echo "green-dot" ; 
                if($task->result == 0 && $task->ended_at != null) echo "red-dot" ;
                if($task->result !== 100 && $task->result !== 0) echo "blue-dot"; // running
                if($task->started_at == null) echo "yellow-dot" ; // didn't start yet
                ?>></div> 
              
                @endforeach

              </td>
            </tr>
            

            @endforeach

          </tbody>
        </table>
        </div>

        <br>
      
        {{$projects->render()}}
        </div>

    
</body>
</html>




<style>

.container {
        text-align: center;
    }

.table-container {
        position: relative;
        display: flex;
        justify-content: center;

    
    }

    table {
      width: 80%;
      font-size: 18px;
      font-weight: bold;
    
    }

    tr {
      transition: all 0.2s ease-in;
      cursor: pointer;
      
    }

    th,
    td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }

    .header {
      background-color: #16a085;
      color: #fff;
    }

    tr:hover {
      background-color: #f5f5f5;
      color: black;
      transform: scale(1.02);
      box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2),
        -1px -1px 8px rgba(0, 0, 0, 0.2);
    }





    .green-dot {
  height: 16px;
  width: 16px;
  background-color: green;
  border-radius: 50%;
  display: inline-block;
}

.red-dot {
  height: 16px;
  width: 16px;
  background-color: red;
  border-radius: 50%;
  display: inline-block;

  
}

.yellow-dot {
  height: 16px;
  width: 16px;
  background-color: yellow;
  border-radius: 50%;
  display: inline-block;
 
}
.blue-dot {
  height: 16px;
  width: 16px;
  background-color: blue;
  border-radius: 50%;
  display: inline-block;
 
}


/* .loader {
  border: 16px solid #f3f3f3; 
  border-top: 16px solid #3498db; 
  border-radius: 50%;
  width: 15px;
  height: 15px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
} */




</style>



