<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task 1 Result</title>
    <link href="Task1.css" rel="stylesheet" />
</head>

<body>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $country = $_POST['country'];

        // Function to fetch data using cURL
        function fetchData($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            curl_close($ch);
            return json_decode($result, true);
        }

        // API requests
        $agePrediction = fetchData("https://api.agify.io/?name=" . urlencode($name));
        $randomAdvice = fetchData("https://api.adviceslip.com/advice");
        $randomDogImage = fetchData("https://dog.ceo/api/breeds/image/random");
        $randomJoke = fetchData("https://v2.jokeapi.dev/joke/Any");

    }
    ?>

    <div class='result'>
        <div class='result-row' style="text-align:center">
            <h2>Your Funny Predictions </h2>
        </div>
        <div class='result-row' style="text-align:center">
            <h4>User's Name:  <?php echo $name; ?></h4>
        </div>
        <div class='result-row'>
        <h4><strong>Predicted Age:</strong> <?php echo $agePrediction['age'] ?? 'Unknown' ?><h4>
        </div>
        <div class='result-row'>
            <h4><strong>Random Advice:</strong> <?php echo $randomAdvice['slip']['advice'] ?? 'No advice available' ?>
            </h4>
        </div>
        <div class='result-row'>
            <h4><strong>Random Joke:</strong>
                <?php echo $randomJoke['joke'] ?? $randomJoke['setup'] . " - " . $randomJoke['delivery'] ?? 'No joke available' ?>
            </h4>
        </div>
        <div class='result-row'><strong>Random Dog Image:</strong><br><img src=<?php echo $randomDogImage['message'] ?? '' ?> alt='Random Dog' style='max-width:200px; border-radius:10px; max-height: 150px'></div>
        <div class='result-row button-row'><button onclick=history.back()>Back</button></div>
    </div>

</body>

</html>