<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOF</title>
    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link href="home.html" rel="home" type="text/html" />
    <link href="survey.html" rel="survey" type="text/html" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Jost:wght@200&display=swap" rel="stylesheet">
</head>

<header>
    <h1>Gain of Function Variant</h1>
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
        <p>Your patient's likelihood of possessing a gain of function variant is <?php $GOF = $_GET['GOF']; echo $GOF;?>. Therefore, your patient is believed to have a gain of function variant with
            <?php            if ($GOF > .9) {
                echo "very high";
            } else if ($GOF > .8){
                echo "high";
            } else if ($GOF > .7) {
                echo "some";
            } else {
                echo "low";
            }?> confidence.</p>
        <div class="prediction">
            <p></p>
        </div>
    </section> 
    <section class="explanation">
        <h3>Gain of Function</h3>
        <p>Gain of function variants are missense variants that result in the Na<sub>v</sub>1.6 sodium-channel failing to close
            completely, causing a “leaky current” and excess sodium ion accumulation, leading to seizures. Patients
            with these variants are expected to have early seizure onset (birth-10 months), with convulsive or motor
            seizures as their primary seizure type and tend to have multiple seizure types. Patients with a GOF
            variant exhibit a wide spectrum of severities with different hallmark symptoms and effective treatment
            options and outcomes.</p>
    </section>
</body>



</html>

