<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOF</title>
    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="home.html" rel="home" type="text/html" />
    <link href="survey.html" rel="survey" type="text/html" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Jost:wght@200&display=swap" rel="stylesheet">
</head>

<header>
    <h1>Loss of Function Variant</h1>
</header>
<nav>
    <ul>
        <li><a href="home.html">About</a></li>
        <li><a href="survey.html">Survey</a></li>
    </ul>
</nav>

<body> 
    <section class="likelihood">
        <h3>Prediction</h3>
        <p>Your patient's likelihood of possessing a loss of function variant is <?php $LOF = $_GET['LOF']; echo $LOF;?>. Therefore, your patient is believed to have a loss of function variant with <?php 
            if ($LOF > .9) {
                echo "very high";
            } else if ($LOF > .8){
                echo "high";
            } else if ($LOF > .7) {
                echo "some";
            } else {
                echo "low";
            }
            ?> confidence.</p>
        <div class="prediction">
            <p></p>
        </div>
    </section>
    <section class="explanation">
        <h3>Loss of Function</h3>
        <p> Your patient is predicted to possess a loss of function variant. Loss of function variants include those that are truncating (i.e. terminations, indels, splice, etc) or
            missense variants that exhibit conventional loss of function characteristics in electrophysiological tests
            (i.e. [list some characteristics]). Patients with these variants are expected to have later seizure onset
            (>10 months), if seizures present themselves, and tend to have absence seizures as their primary seizure
            type. Additionally, patients with loss of function variants are expected to have intellectual and
            developmental disability ranging from mild to severe IDD. Treatment of these patients should not
            include sodium channel blockers when seizures are present, as sodium channel blockers are expected to
            exacerbate symptoms by further inhibiting the function of Na<sub>v</sub>1.6</p>
    </section>
</body>



</html>