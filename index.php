<html>
 <head>
 <Title>Registration Form</Title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
 </head>
 <body>
<div class="container">
     <h1>Daftar Buku Tamu!</h1>
     <form method="post" action="index.php" enctype="multipart/form-data" >
      <div class="form-group">
        <label for="exampleInputEmail1">Nama</label>
        <input type="text" class="form-control" placeholder="Masukan Nama" name="nama">        
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">No HP</label>
        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="NO HP" name="tlp">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Berkunjung ke rumah</label>
        <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Kepala Keluarga" name="kpl">
      </div>
     
        <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
        <input type="submit" name="load_data" value="Load Data" class="btn btn-warning" />
    </form>
    <br>

    <?php
    $host = "registrasi.database.windows.net";
    $user = "saifudin";
    $pass = "Dirimu_1";
    $db = "registrasi";

    try {
        $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch(Exception $e) {
        echo "Failed: " . $e;
    }

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $date = date("Y-m-d");
            // Insert data
            $sql_insert = "INSERT INTO Registration (name, email, job, date) 
                        VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $job);
            $stmt->bindValue(4, $date);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }

        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>Nama Orang yang ber kunjung:</h2>";
                echo "<table class='table table-hover'>";
                echo "<tr><th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Job</th>";
                echo "<th>Date</th></tr>";
                foreach($registrants as $registrant) {
                    echo "<tr><td> ".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['job']."</td>";
                    echo "<td>".$registrant['date']."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>

</div>
 </body>
 </html>