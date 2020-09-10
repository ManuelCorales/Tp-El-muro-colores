<?php
    session_start();
    if(!isset($_SESSION['y'])){
        $_SESSION['y'] = 0;
    }
    if(!isset($_SESSION['x'])){
        $_SESSION['x'] = 0;
    }
    function traerFilasYColumnas($filas, $columnas){
        static $traerDatos = 'no entro';
        $filasYColumnas = array(
            "filas" => 0,
            "columnas" => 0,
        );
        if($traerDatos === 'no entro'){
            $traerDatos = "No los traigas más";
            $q = hacerQuery('SELECT MAX(y) FROM mapa');
            while ($row = $q->fetch()):
                $filasYColumnas["filas"] = $row['MAX(y)'] + 1;
            endwhile;
            $q = hacerQuery('SELECT MAX(x) FROM mapa');
            while ($row = $q->fetch()):
                $filasYColumnas["columnas"] = $row['MAX(x)'] + 1;
            endwhile;
            return $filasYColumnas;
        }
        $filasYColumnas["columnas"] = $columnas;
        $filasYColumnas["filas"] = $filas;      
        return $filasYColumnas;
    
        
    }
    function hacerQuery($query){
        try{
        $servername = "localhost";
        $username = "root";
        $password = "manu0712";
        $conn = new PDO("mysql:host=$servername;dbname=coloresdb", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $q = $conn->query($query);
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q;
        }
        catch(PDOException $e) {
            echo "Conección fallida: " . $e->getMessage();
        }
    }

    
    $colores = array(
        "#000000" => "0",
        "#1D2B53" => "1",
        "#7E2553" => "2",
        "#008751" => "3",
        "#AB5236" => "4",
        "#5F574F" => "5",
        "#C2C3C7" => "6",
        "#FFF1E8" => "7",
        "#FF004D" => "8",
        "#FFA300" => "9",
        "#FFEC27" => "10",
        "#00E436" => "11",
        "#29ADFF" => "12",
        "#83769C" => "13",
        "#FF77A8" => "14",
        "#FFCCAA" => "15",
    );
    $filas = 0;
    $columnas = 0;

    $filasYColumnas = traerFilasYColumnas($filas, $columnas);
    $filas = $filasYColumnas["filas"];
    $columnas = $filasYColumnas["columnas"];

    if(isset($_POST["color"])){
        $_SESSION["color"] = $_POST['color'];
    }
    if (isset($_POST['move'])) {
        switch($_POST['move']){
            case "D":
                $_SESSION["x"] = $_SESSION["x"] + 1;
                break;
            case "A":
                if($_SESSION["x"] > 0){
                    $_SESSION["x"]--;
                }    
                break;
            case "W":
                if($_SESSION["y"] < 0){
                    $_SESSION["y"]++;
                }
                break;
            case "S":
                $_SESSION["y"]--;
                break;
            case "X":
                foreach ($colores as $key => $val) {
                    if($_SESSION['color'] == $val){
                        hacerQuery("UPDATE mapa set color = '$key' WHERE X = $_SESSION[x] AND Y = -$_SESSION[y];");
                        break;
                    }
                }
                break;
        }



    } elseif (isset($_POST['color'])){
        $_POST['color'];
    }


    if(-$_SESSION["y"] > $filas - 1){
        $query = "";
        for($i = 0; $i < $columnas; $i++){
            $query = "INSERT INTO mapa (x, y)
            VALUES ($i, $filas); $query";
        }
        hacerQuery($query);
        $filas++;
        
    }
    if($_SESSION["x"] > $columnas - 1){
        $query = "";
        for($i = 0; $i < $filas; $i++){
            $query = "INSERT INTO mapa (x, y)
            VALUES ($columnas, $i); $query";
        }
        hacerQuery($query);
        $columnas++;
    }




?>

<html>
    <head>
    <meta charset="utf-8">
<style>

html, body {
	background-color: #444;
	color: white;
}

input[type=submit] {
	width: 32px;
	height: 32px;
}
td {
	padding: 2px;
	width: 8px;
	height: 8px;
	outline: 2px dotted transparent;

}

#moves, #colors, #datas {
	float: left;
	margin-left: 3em;
}

.col0 { color: #000000; background: #000000; }
.bor0 { outline: dotted 2px #000000;}
.col1 { color: #1D2B53; background: #1D2B53; }
.bor1 { outline: dotted 2px #1D2B53;}
.col2 { color: #7E2553; background: #7E2553; }
.bor2 { outline: dotted 2px #7E2553;}
.col3 { color: #008751; background: #008751; }
.bor3 { outline: dotted 2px #008751;}
.col4 { color: #AB5236; background: #AB5236; }
.bor4 { outline: dotted 2px #AB5236;}
.col5 { color: #5F574F; background: #5F574F; }
.bor5 { outline: dotted 2px #5F574F;}
.col6 { color: #C2C3C7; background: #C2C3C7; }
.bor6 { outline: dotted 2px #C2C3C7;}
.col7 { color: #FFF1E8; background: #FFF1E8; }
.bor7 { outline: dotted 2px #FFF1E8;}
.col8, #plcol { color: #FF004D; background: #FF004D; }
.bor8 { outline: dotted 2px #FF004D;}
.col9 { color: #FFA300; background: #FFA300; }
.bor9 { outline: dotted 2px #FFA300;}
.col10 { color: #FFEC27; background: #FFEC27; }
.bor10 { outline: dotted 2px #FFEC27;}
.col11 { color: #00E436; background: #00E436; }
.bor11 { outline: dotted 2px #00E436;}
.col12 { color: #29ADFF; background: #29ADFF; }
.bor12 { outline: dotted 2px #29ADFF;}
.col13 { color: #83769C; background: #83769C; }
.bor13 { outline: dotted 2px #83769C;}
.col14 { color: #FF77A8; background: #FF77A8; }
.bor14 { outline: dotted 2px #FF77A8;}
.col15 { color: #FFCCAA; background: #FFCCAA; }
.bor15 { outline: dotted 2px #FFCCAA;}

</style>

</head>
<body>
<?php
    $columnasColores = hacerQuery('SELECT x, y, color FROM mapa ORDER BY y ASC, x asc');
    $y = 0;
    

    echo '<table>';
    echo '<tbody>';

    echo '<tr>';

    while ($row = $columnasColores->fetch()):
        $color = $row["color"];
        if ($row["y"] != $y){
            echo '</tr>';
            echo '<tr>';
        }

        $x = $row["x"];
        $y = $row["y"];
        if($x == $_SESSION['x'] && $y == -$_SESSION['y']){
            echo "<td class='col$colores[$color] bor$_SESSION[color]'/>";
        } else {   
            echo "<td class='col$colores[$color]' />";
        }
    endwhile;
    echo '</tbody>';
    echo '</table>';
?>
<form method="post" action="">

<div id="moves">
<h3> move </h3>
	<table>
		<tbody><tr>
			<td></td>
			<td><input type="submit" name="move" value="W"></td>
			<td></td>
		</tr>
		<tr>
			<td><input type="submit" name="move" value="A"></td>
            <td><?php 
                echo "<input type='submit' name='move' value='X' class='col$_SESSION[color]'>"
            ?></td>
			<td><input type="submit" name="move" value="D"></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" name="move" value="S"></td>
			<td></td>
		</tr>
	</tbody></table>
</div>

<div id="colors">
	<h3> color </h3>
	<table>
	<tbody><tr><td><input type="submit" name="color" class="col0" value="0"></td>
<td><input type="submit" name="color" class="col1" value="1"></td>
<td><input type="submit" name="color" class="col2" value="2"></td>
<td><input type="submit" name="color" class="col3" value="3"></td>
</tr><tr></tr><tr><td><input type="submit" name="color" class="col4" value="4"></td>
<td><input type="submit" name="color" class="col5" value="5"></td>
<td><input type="submit" name="color" class="col6" value="6"></td>
<td><input type="submit" name="color" class="col7" value="7"></td>
</tr><tr></tr><tr><td><input type="submit" name="color" class="col8" value="8"></td>
<td><input type="submit" name="color" class="col9" value="9"></td>
<td><input type="submit" name="color" class="col10" value="10"></td>
<td><input type="submit" name="color" class="col11" value="11"></td>
</tr><tr></tr><tr><td><input type="submit" name="color" class="col12" value="12"></td>
<td><input type="submit" name="color" class="col13" value="13"></td>
<td><input type="submit" name="color" class="col14" value="14"></td>
<td><input type="submit" name="color" class="col15" value="15"></td>
</tr><tr>		</tr>
	</tbody></table>
</div>

        </form>
    </body>
</html>