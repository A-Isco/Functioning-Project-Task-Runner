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
        <!-- <td>{{$task->result}}%</td> -->
       
        <td><?php if($task->result == 100) echo "Pass"; if($task->result == 0 && $task->ended_at != null ) echo "Failed" ;  
              if($task->result !== 100 && $task->result !== 0) echo $task->result."%"    ?></td>
        <td>{{$task->created_at}}</td>
        <td>{{$task->started_at ?? '-'}}</td>
        <!-- <td>{{$task->ended_at}}</td>    -->
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


<style>
  
     /* body {
      padding: 0px;
      margin: 0;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    .nav-container {
    display: flex;
    flex-direction: row;
    justify-content: right;
    padding: 5px;

}


.li {
    margin: 10px;
font-size: 20px;}

    .container {
        text-align: center;
    }

    .table-container {
        position: relative;
        display: flex;
        justify-content: center;
    

    }


   

    .back-btn {
        margin-top: 20px;
  background-color: #f44336;
  color: white;
  padding: 14px 25px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
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
    } */

     */

  



    /* @media only screen and (max-width: 768px) {
      table {
        width: 90%;
      }
    } */

  

     /* table {
      /* position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%); */
      /* border-collapse: collapse;
      width: 1500px; */
      /* height: 200px; */
      /* border: 1px solid #bdc3c7;
      box-shadow: 2px 2px 12px rgba(0, 0, 0, 0.2),
        -1px -1px 8px rgba(0, 0, 0, 0.2); */
       
    /* } */

</style>