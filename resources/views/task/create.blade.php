<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
</head>
<body>
    <form method="POST" action="{{ route('task.store') }}">

        @csrf

        <label for="project-id">Project Id:</label><br>
        <input type="text" id="project-id"  name="project_id"><br><br>
        <label for="fname">Task Type:  
        </label><br>
        <label for="">
            <input type="radio" id="task_type" name="task_type" value="Count words" >
            Count Words
        </label>
        <label for="">
            <input type="radio" id="task_type" name="task_type" value="Count lines" >
            Count Lines
        </label>
        <label for="">
            <input type="radio" id="task_type" name="task_type" value="Count characters" >
            Count Characters
        </label><br><br>
        <label for="file">Input File :</label><br>
        <input type="file" name="file"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>