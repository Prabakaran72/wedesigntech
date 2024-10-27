<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 1</title>
    <link href="Task1.css" rel="stylesheet" />
</head>

<body>
    <div class="card">
        <form action="Task1result.php" method="Post">
        <div class="row">
            <lable class="card-label">User Name</lable>
            <input class="card-field" type="text" id="name" name="name" required/>
        </div>    
        <div class="row">
            <lable class="card-label">Email</lable>
            <input class="card-field" type="email" id="email" name="email" required/>
        </div>    
        <div class="row">
            <lable class="card-label">Date of birth</lable>
            <input class="card-field" type="text" id="dob" name="dob" required/>
        </div>    
        <div class="row">
            <lable class="card-label">Country</lable>
            <input class="card-field" type="text" id="country" name="country" required/>
        </div>    
        <div class="row">
            <button>Submit</button>
        </div>
        </form>
    </div>
</body>
</html>