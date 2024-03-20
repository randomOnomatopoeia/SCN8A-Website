
<?php
  // create arrays for seizure type; create variable for array length
  // R variables: 
  //V1_SEVEREIDD= binary (0,1)
  //onset_age= continuous (age in months)
  //dev_sz= binary (0,1)
  //convulsive_sz= binary (0,1)
  //absence= binary (0,1)

  $host = 'scn8a-form-results.mysql.database.azure.com';
  $username = 'tmak';
  $password = 'R@nd0mPa5word';
  $db_name = 'formresults';
  $table_name = 'results';


  $LOF = ["c.417G>A","c.417G>C","c.417G>T","c.669G>C","c.669G>T", "c.1150G>A","c.1150G>C","c.2533T>C","c.2566A>G","c.2792G>A","c.2806G>A",
  "c.2890G>C","c.2930T>C","c.3652G>A","c.3922T>C","c.3926G>T","c.3955G>A","c.4351G>A","c.4798A>G","c.4832T>A","c.4865C>A","c.4948G>T",
  "c.4961T>A","c.5108C>A","c.5156C>G","c.5273T>C","c.5332G>C","c.5359A>C","c.5368G>A"];
  $GOF = ["c.667A>G","c.2300C>T","c.2519T>C","c.2537T>C","c.2549G>A","c.2952C>A","c.2952C>G","c.3979A>G","c.4423G>C",
  "c.4423G>A","c.4447G>A","c.4850G>A","c.5280G>C","c.5280G>A","c.5280G>T","c.5302A>G","c.5614C>T","c.5614C>G","c.5615G>T","c.5630A>G"];

  
  // real data?
  $real = isset($_POST["person"]) ? $_POST["person"]: '';

  // find value for mutation type
  $type = isset($_POST["type"] ) ? $_POST["type"]: '';
  
  // get mutation code
  $code = isset($_POST["code"]) ? $_POST["code"]:'';

  // get values from other questions 
  $V1_SEVEREIDD = isset($_POST['V1_SEVEREIDD']) ? $_POST['V1_SEVEREIDD']: '';
  //echo $V1_SEVEREIDD;
  $dev_sz = isset($_POST['dev_sz']) ? $_POST['dev_sz']: '';
  //echo $dev_sz;
  $onset_age = (empty($_POST['onset_age'])) ? 100 : $_POST['onset_age'];
  //echo $onset_age;

  // collects values from ST and makes them an array
  if(!empty($_POST['ST'])) {
    // convert ST to strings separated by comma
    $sz_list = implode(',', $_POST['ST']);
    // convert string into array for function
    $sz_list = explode(",", $sz_list);
    $length = count($sz_list);
      
  $convulsive_sz = runConvulsive(count($sz_list), $sz_list);
  $absence_sz = runAbsence(count($sz_list), $sz_list);
  //echo $convulsive_sz;
  //echo $absence_sz;

  } else {
    $convulsive_sz = 0; 
    $absence_sz = 0;
  }

 // runs program 
 putenv("R_LIBS=C:/Users/Tahlia/AppData/Local/R/win-library/4.3");
 $command = "cd C:\Program Files\R\R-4.3.2\bin && RScript.exe C:/Users/Tahlia/Documents/scn8a/sample.R $V1_SEVEREIDD $dev_sz $onset_age $convulsive_sz $absence_sz";
 $output = shell_exec($command);

//var_dump($output);
// creates $loss and $gain 
$loss = (float) substr($output,130,10); 
$gain = 1-$loss;
echo $loss;
  


  // insert data into database
  if ($real == 1) {
    //Establishes the connection
    $conn = mysqli_init();
    mysqli_real_connect($conn, $host, $username, $password, $db_name, 3306, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT);
    if ($stmt = mysqli_prepare($conn, "INSERT INTO results (MutationType, MutationCode, V1_SEVEREIDD, 
    dev_sz, onset_age, convulsive_sz, absence_sz) VALUE (?,?,?,?,?,?,?)")) {
      mysqli_stmt_bind_param($stmt, 'ssiiiii', $type, $code, $V1_SEVEREIDD, $dev_sz, $onset_age, $convulsive_sz, $absence_sz);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  } 
  




// redirect after collecting data for known codes or mutation types

  for ($i = 0; $i < count($LOF); $i++) {
    if ($code == ($LOF[$i])) {
      header('Location: LOF.php?LOF=1.0');
    }
  } 
  
  for ($i = 0; $i < count($GOF); $i++) {
    if ($code == ($GOF[$i])) {
      echo $gain;
      echo $i;
      //header("Location: GOF.php?gain=1.0");
    }
  }

  if ($type != 'Missense') {
    header('Location: LOF.php?LOF=' . $loss);
  } else if ($loss > .50) {
    header('Location: LOF.php?LOF=' . $loss);
  } else if ($gain > .50){
    echo $gain; 
    echo $loss;
    //header("Location: GOF.php?GOF=" . $gain);
  } else {
    header('Location = nonMissense.php');
  }
  
  // checks for absence or febrile and returns 0 or 1 for convulsive_sz()
  //convulsive: anything not ABS, FEB, or A-ABS
  function runConvulsive($varLength, $var) {
    
    for ($x = 0; $x < $varLength; $x++) {
      if ($var[$x] == "ABS" or $var[$x] == "FEB" or $var[$x] == "A-ABS") {
        $convulsive_sz = 0;
        return $convulsive_sz;
      } else {
        $convulsive_sz = 1;
      }
    }
    return $convulsive_sz;
  }

  // same as above but for absence()
  // ABS or A-ABS
  function runAbsence($varLength, $var) {
    for ($x = 0; $x < $varLength; $x++) {
      if ($var[$x] == "ABS" or $var[$x] == "A-ABS") {
        $absence = 1;
        return $absence;
      } else {
        $absence = 0;
      }
    }
    return $absence;
  }



?>