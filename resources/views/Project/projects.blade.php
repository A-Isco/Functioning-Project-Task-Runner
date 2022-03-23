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
    <h1>All Projects</h1>
    @foreach ($projects as $project)

    <h3>{{$project->project_id}}</h3>
    <h4>{{$project->running}}</h4>
    <a href="{{route('projects.single',$project->project_id)}}">Project page</a>
    <hr>
    @endforeach
    {{$projects->render()}}
    
</body>
</html>



