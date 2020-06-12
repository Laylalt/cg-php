<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style.css">
</head>
<body>

    <?php
        require_once('../../func.php');
        $x = check();
        if(isset($x) && $x == 0){
            $conn = connect();
            head();
            $print = "<p><a href='http://localhost/admin/library_admin.php?acc=3'><--Go back</a></p>";
            echo $print;
        //--------------------------------------------------------------------------------------------------------------------------------------
            if(isset($_POST["title"]) && isset($_POST["dewey_code"]) && isset($_POST["copy_number"]) && isset($_POST["availability"])){
                $title = $_POST["title"];
                $dewey_code = $_POST["dewey_code"];
                $copy_number = $_POST["copy_number"];
                $availability = $_POST["availability"];
                $sql = "INSERT INTO books (title, dewey_code, availability, copy_number) VALUES('$title','$dewey_code','$availability','$copy_number')";
                if($conn->query($sql) === TRUE){
                    echo "New book added";
                    $sql = "SELECT * FROM books ORDER BY id_isbn DESC LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        // output data of each row		
                        $tabla = "<table border =2px>";
                        $tabla .= "<tr><td>ISBN</td><td>Title</td><td>Dewey Code</td>";
                        $tabla .= "<td>Number of copies</td><td>Available copies</td></tr>";//header row
                        $row = $result->fetch_assoc();
                        $tabla .= "<tr>";
                        $tabla .= "<td>" . $row["id_isbn"] . "</td>";
                        $tabla .= "<td>" . $row["title"] . "</td>";
                        $tabla .= "<td>" . $row["dewey_code"] . "</td>";
                        $tabla .= "<td>" . $row["copy_number"] . "</td>";
                        $tabla .= "<td>" . $row["availability"] . "</td>";
                        $tabla .= "</tr>";
                        $tabla .= "</table>";
                        echo $tabla;
                        } else {
                            echo "0 results";
                        }
                }else{
                    echo "Error updating data";
                }
            }else{
                echo "failed to receive data";
            }
        }else{
?>
            <p>you don't have authorization to acces this page, please <a href="http://localhost/">log in</a></p> 
 <?php
            }
        
?>
</body>
</html>