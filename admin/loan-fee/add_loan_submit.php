<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('../../func.php');
        $x = check();
        if(isset($x) && $x == 0){
            head();
            $conn = connect();
            //set variables to add
            if (isset($_GET["acc"])){
                $opcion = explode("-",$_GET["acc"]);
                $id_students = $opcion[0];
                $id_isbn = $opcion[1];
                $id_admin_out = $_SESSION["id"];
                $date_out = date("Y-m-d");
                $date_sin = date('Y-m-d', strtotime("+7 days"));
                $sql = "INSERT INTO loans(id_students, id_isbn, id_admin_out, date_out, date_sin) VALUES($id_students, $id_isbn, $id_admin_out, '$date_out', '$date_sin');";
                if($conn->query($sql) === TRUE){
                    echo "<div class = 'W'>New loan added</div>";
                    $sql = "SELECT id_students, id_isbn, id_admin_out, date_out, date_sin FROM loans WHERE active = 1 AND id_students = $id_students AND id_isbn = $id_isbn AND date_out = '$date_out' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row		
                        $tabla = "<table>";
                        $tabla .= "<tr><th>Borrow date</th><th>Return date</th><th>Id student</th>";
                        $tabla .= "<th>ISBN</th><th>Id admn</th></tr>";//header row
                        $row = $result->fetch_assoc();
                        $tabla .= "<tr>";
                        $tabla .= "<td>" . $row["date_out"] . "</td>";
                        $tabla .= "<td>" . $row["date_sin"] . "</td>";
                        $tabla .= "<td>" . $row["id_students"] . "</td>";
                        $tabla .= "<td>" . $row["id_isbn"] . "</td>";
                        $tabla .= "<td>" . $row["id_admin_out"] . "</td>";
                        $tabla .= "</tr>";
                        $tabla .= "</table>";
                        echo $tabla;
                        } else {
                            echo "0 results";
                        }
                        $conn->close();
                }else{
                    echo "Error updating data";
                }
            }else{
                echo "What are you doing here?";
            }
            
        }else{
            echo "<p>you don't have authorization to acces this page, please <a href='http://localhost/'>log in</a></p>";
        }
    ?>
</body>
</html>