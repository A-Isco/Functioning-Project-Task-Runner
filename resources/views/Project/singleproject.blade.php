<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/singleProject.css')}}">


</head>
<body>
<div class="nav-container">
        <div class="li">
                <div class="font-medium text-base text-gray-800">Welcome {{ Auth::user()->name }}</div>
            </div>
            <div class="li">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>      
    </div>
    <div class="container">
    <h1>Project Name : {{$project_id}}</h1>
    <div class="table-container">
    <table>
    <thead>
        <tr class="header">
        <th scope="col">Task id</th>
        <th scope="col">Type</th>
        <th scope="col">#occurrences</th>
        <th scope="col">Result</th>
        <th scope="col">Created At</th>
        <th scope="col">Started At</th>
        <th scope="col">Ended At</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tasks as $task)
        <tr>
        <td>{{$task->task_id}}</td>
        <td>{{$task->task_type}}</td>
        <td>{{($task->result !== 100 && $task->result !== 0 ) ? ($task->occurrences . "*") : ($task->occurrences)}}</td>
        
       
        <td><?php if($task->result == 100) echo "Pass"; if($task->result == 0 && $task->ended_at != null ) echo "Failed" ;  
              if($task->result !== 100 && $task->result !== 0) echo $task->result."%"    ?></td>
        <td>{{$task->created_at}}</td>
        <td>{{$task->started_at ?? '-'}}</td>
        <td>{{ $task->ended_at ?? '-' }}</td>   
        </tr>
    @endforeach

    </tbody>
    </table>


    </div>
    
    
    <a class="back-btn" href="{{route('projects.all')}}">Back</a>
    </div>
</body>
</html>


