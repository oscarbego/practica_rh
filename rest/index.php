<?php

require 'Slim/Slim.php';

$app = new Slim();

$app->get('/areas', 'getAreas');

$app->get('/add/cliente/:area/:cli', 'addCli');

$app->get('/add/celula/:cli/:cel', 'addCel');

$app->get('/clientes', 'getClientes');

$app->get('/:area/clientes', 'getClientesArea');



$app->get('/turnos', 'getTurnos');
$app->get('/celulas', 'getCelulas');

$app->get('/vista', 'getVista');



$app->get('/addRhEmployee/:idEmpl/:idCel/:idHorario', 'upDateRhEmployee');
$app->get('/rh_employee/:id', 'getRhEmployee');

$app->get('/rh_employees', 'getRhEmployees');

//$app->get('/rh_employees/:area', 'getRhEmployees');
//$app->get('/rh_employees/:area/:cli', 'getRhEmployees');
//$app->get('/rh_employees/:area/:cli/:cel', 'getRhEmployees');



$app->get('/employee/:id', 'getEmployee');


$app->get('/ver/:area/:cli/:turno', 'verAreaCliTurn');

$app->get('/ver/:area/:cli', 'verAreaCli');

$app->get('/ver/:area', 'verArea');


//$app->get('/add/area', 'addArea');



$app->get('/addProds', 'addProd');

$app->get('/wines', 'getWines');
$app->get('/wines/:id',	'getWine');
$app->get('/wines/search/:query', 'findByName');
$app->post('/wines', 'addWine');
$app->put('/wines/:id', 'updateWine');
$app->delete('/wines/:id',	'deleteWine');



$app->run();


function getClientesArea($area)
{
        $sql = 'select * from rh_tristone.clientes where areas_id = ' . $area;
        try {
                $db = getConnection();
                $stmt = $db->query($sql);  
                $clientes = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($clientes);
        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
}

function getRhEmployee($id)
{
        $sql = 'select * from rh_tristone.employees 
                                where id_empresa = "' . $id . '"';
        try {
                $db = getConnection();
                $stmt = $db->query($sql);  
                $emp = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($emp);
        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
}

function getRhEmployees()
{
        $sql = 'select * from rh_tristone.vw_relacion_emp';
        try {
                $db = getConnection();
                $stmt = $db->query($sql);  
                $emp = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($emp);
        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
}


//$app->get('/add/celula/:cli/:cel', 'addCel');
function addCel($cel, $cli)
{	 
	       //INSERT INTO `rh_tristone`.`celulas` (`celula`, `clientes_id`) VALUES ('test', '28');
	 $sql = "INSERT INTO `rh_tristone`.`celulas` (`celula`, `clientes_id`) VALUES ('". $cel ."', '". $cli ."');";

        try {
		
				$db = getConnection();	
				$stmt = $db->prepare($sql);  
				$stmt->execute();
				$db = null;
				echo '{"msg":"Save Ok"}';

        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() . ' ' . $sql . ' }}'; 
        }  
}


function addCli($area, $cli)
{	 
	 $sql = "INSERT INTO `rh_tristone`.`clientes` (`cliente`, `areas_id`) VALUES ('". $cli ."', '". $area ."');";

        try {
		
				$db = getConnection();	
				$stmt = $db->prepare($sql);  
				$stmt->execute();
				$db = null;
				echo '{"msg":"Save Ok"}';

        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }  
}


function addRhEmployee($idEmpl, $idCel, $idHorario)
{
 
	 $memo = isset($_GET['memo']) ? $_GET['memo'] : "";

	 //      INSERT INTO `emp_hr_cel` (`celulas_id`, `horarios_id`, `employees_id`, `memo`) VALUES ('1', '1', '28', 'Sr. Oso');
	 $sql = "INSERT INTO `emp_hr_cel` (`celulas_id`, `horarios_id`, `employees_id`, `memo`) VALUES ('" . $idCel . "', '" . $idHorario . "', '" . $idEmpl . "', '" . $memo . "');";

        try {
		
				$db = getConnection();	
				$stmt = $db->prepare($sql);  
				$stmt->execute();
				$db = null;
				echo '{"msg":"Save Ok"}';

        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }  
}


function deleteRhEmployee($idEmpl)
{
	$sql = "delete from `emp_hr_cel` where  `employees_id` = '" . $idEmpl . "';";

        try {
		
				$db = getConnection();	
				$stmt = $db->prepare($sql);  
				$stmt->execute();
				$db = null;
				echo '{"msg":"Delete Ok"}';

        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        } 
}

function upDateRhEmployee($idEmpl, $idCel, $idHorario)
{
	echo "[";
	deleteRhEmployee($idEmpl);
	echo ", ";
	addRhEmployee($idEmpl, $idCel, $idHorario);
	echo "]";
}




function getEmployee($id)
{
        $sql = 'select * from rh_tristone.employees 
                                where id_empresa = "' . $id . '"';
        try {
                $db = getConnection();
                $stmt = $db->query($sql);  
                $emp = $stmt->fetchAll(PDO::FETCH_OBJ);
                $db = null;
                echo json_encode($emp);
        } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}'; 
        }
}


function getAreas()
{
	$sql = "select * from areas";
	
	
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$areas = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($areas);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function getClientes()
{
	$sql = "select * from clientes";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$clientes = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($clientes);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function getTurnos()
{
	$sql = "select * from turno";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$turno = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($turno);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function getCelulas()
{
	$sql = "select * from celulas";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$celulas = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($celulas);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}




function getVista()
{
	$sql = "select * from rh_tristone.vw_areas_cros_celula";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$celulas = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($celulas);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function verArea($area)
{
	//distinct
	//select * from rh_tristone2.clientes
	$sql = 'select * from 
				rh_tristone.clientes
				where areas_id = "' . $area . '"';
	//echo $sql;

	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$areas = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($areas);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function verAreaCliTurn($area, $cli, $turno)
{
	$sql = 'select * from 
				rh_tristone.vw_areas_cros_celula 
				where idArea = "' . $area . '" and 
				idTurno = "' . $turno . '" and idCliente = "' . $cli . '"
				';
	//echo $sql;

	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$celulas = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($celulas);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function verAreaCli($area, $cli)
{
	//select distinct celula from 	
	$sql = 'select distinct idCelula, celula from 
				rh_tristone.vw_areas_cros_celula 
				where idArea = "' . $area . '" and 
				idCliente = "' . $cli . '"
				';
	//echo $sql;

	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$celulas = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo json_encode($celulas);

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}







function addProd2() {
	
	$n = $_GET['n'];
	$p = $_GET['p'];
	$sql = "INSERT INTO `productos` (`nombre`, `precio`) VALUES ( '$n', '$p');";
	

	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$db = null;
		echo json_encode(1); 

	} catch(PDOException $e) {
		
		echo json_encode(0); 
	}
}




function addProd() {
	
	$n = $_GET['n'];
	$p = $_GET['p'];
	$sql = "INSERT INTO `productos` (`nombre`, `precio`) VALUES ( '$n', '$p');";
	

	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->execute();
		$db = null;
		echo json_encode(1); 

	} catch(PDOException $e) {
		
		echo json_encode(0); 
	}
}


function getEnepe() {
	$sql = "SELECT
  `tbl_dias`.`nombre` AS `dia`,
  `tbl_recintos`.`nombre` AS `recinto`,
  `tbl_horarios`.`nombre` AS `horario`,
  `tbl_tipos_contribucion`.`nombre` AS `tipo`,
  `tbl_congresistas`.`nombre` AS `autor`,
  `tbl_congresistas`.`apaterno`,
  `tbl_congresistas`.`amaterno`,
  `tbl_sedes`.`nombre` AS `sede`,
  `tbl_contribuciones`.`titulo` AS `titulo`,
  `tbl_contribuciones`.`ncn`
FROM
  `tbl_contribuciones`
  INNER JOIN `tbl_modulo_contribuciones`
    ON `tbl_modulo_contribuciones`.`contribucion` = `tbl_contribuciones`.`ncn`
  INNER JOIN `tbl_modulos` ON `tbl_modulo_contribuciones`.`modulo` =
    `tbl_modulos`.`nmd`
  INNER JOIN `tbl_recintos` ON `tbl_modulos`.`recinto` = `tbl_recintos`.`nrs`
  INNER JOIN `tbl_dias` ON `tbl_modulos`.`dia` = `tbl_dias`.`nda`
  INNER JOIN `tbl_horarios` ON `tbl_modulos`.`horario` = `tbl_horarios`.`nhr`
  INNER JOIN `tbl_sedes` ON `tbl_sedes`.`nsd` = `tbl_recintos`.`sede`
  INNER JOIN `tbl_congresistas` ON `tbl_congresistas`.`ncn` =
    `tbl_contribuciones`.`ncn`
  INNER JOIN `tbl_tipos_contribucion` ON `tbl_contribuciones`.`tpc` =
    `tbl_tipos_contribucion`.`tpc`
    
    where `tbl_tipos_contribucion`.`nombre` = 'Ponencia ENEPE'
    	
    ;";


    //$sql = "select * from comie.vwdatosactividades limit 20;";

	try {
		$db = getConnection();
		//$db->setAttribute(PDO::MYSQL_ATTR_MAX_BUFFER_SIZE, 1024 * 1024 * 10);
		//$stmt = $db->query($sql);  
		
		$stmt = $db->prepare($sql);  
		//$stmt->bindParam("id", $id);
		$stmt->execute();
		
		//$actividades = $stmt->fetchAll(PDO::FETCH_OBJ);
		//$actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
		

		//$actividades = mb_check_encoding($actividades, 'UTF-8') ? $actividades : utf8_encode($actividades);

		//while ($actividades = $stmt->fetch(PDO::FETCH_ASSOC)) {
    	//	echo $actividades['dia'];
 		//}

		
		
		$myfile = fopen("enepe.json", "w") or die("Unable to open file!");
		//$txt = "John Doe\n";
		//fwrite($myfile, $txt);
		//$txt = "Jane Doe\n";
		//fwrite($myfile, $txt);
		//fclose($myfile);		 
		

		
		
		//echo "[";
		fwrite($myfile, "[");

		$arr = $stmt->fetch(PDO::FETCH_OBJ);
		//echo json_encode($arr);
		fwrite($myfile, json_encode($arr));

		while ($arr = $stmt->fetch(PDO::FETCH_OBJ)) { 
    		
    		//echo "," . json_encode($arr);
    		//utf8_decode(string) htmlspecialchars($datos) htmlentities($str, null, "UTF-8");
    		if(json_encode($arr) != "")
    			fwrite($myfile, "," . utf8_encode(json_encode($arr)));
    			//fwrite($myfile, "," . json_encode($arr, null, "UTF-8"));
		}

		//echo "]";
		fwrite($myfile, "]");

		
		
		fclose($myfile);



		$myfile = fopen("enepe.json", "r") or die("Unable to open file!");
		echo fread($myfile, filesize("enepe.json"));
		fclose($myfile);

		$db = null;

		//echo json_encode($actividades);

		

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function getActividades() {
	$sql = "SELECT
  `tbl_dias`.`nombre` AS `dia`,
  `tbl_recintos`.`nombre` AS `recinto`,
  `tbl_horarios`.`nombre` AS `horario`,
  `tbl_tipos_contribucion`.`nombre` AS `tipo`,
  `tbl_congresistas`.`nombre` AS `autor`,
  `tbl_congresistas`.`apaterno`,
  `tbl_congresistas`.`amaterno`,
  `tbl_sedes`.`nombre` AS `sede`,
  `tbl_contribuciones`.`titulo` AS `titulo`,
  `tbl_contribuciones`.`ncn`
FROM
  `tbl_contribuciones`
  INNER JOIN `tbl_modulo_contribuciones`
    ON `tbl_modulo_contribuciones`.`contribucion` = `tbl_contribuciones`.`ncn`
  INNER JOIN `tbl_modulos` ON `tbl_modulo_contribuciones`.`modulo` =
    `tbl_modulos`.`nmd`
  INNER JOIN `tbl_recintos` ON `tbl_modulos`.`recinto` = `tbl_recintos`.`nrs`
  INNER JOIN `tbl_dias` ON `tbl_modulos`.`dia` = `tbl_dias`.`nda`
  INNER JOIN `tbl_horarios` ON `tbl_modulos`.`horario` = `tbl_horarios`.`nhr`
  INNER JOIN `tbl_sedes` ON `tbl_sedes`.`nsd` = `tbl_recintos`.`sede`
  INNER JOIN `tbl_congresistas` ON `tbl_congresistas`.`ncn` =
    `tbl_contribuciones`.`ncn`
  INNER JOIN `tbl_tipos_contribucion` ON `tbl_contribuciones`.`tpc` =
    `tbl_tipos_contribucion`.`tpc`
    
    where `tbl_dias`.`nombre` like '%Miercoles%'; 
    or
    
    `tbl_dias`.`nombre` like 'Jueves%' or
    
    `tbl_dias`.`nombre` like 'Viernes%'
    ;";


    //$sql = "select * from comie.vwdatosactividades limit 20;";

	try {
		$db = getConnection();
		//$db->setAttribute(PDO::MYSQL_ATTR_MAX_BUFFER_SIZE, 1024 * 1024 * 10);
		//$stmt = $db->query($sql);  
		
		$stmt = $db->prepare($sql);  
		//$stmt->bindParam("id", $id);
		$stmt->execute();
		
		//$actividades = $stmt->fetchAll(PDO::FETCH_OBJ);
		//$actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
		

		//$actividades = mb_check_encoding($actividades, 'UTF-8') ? $actividades : utf8_encode($actividades);

		//while ($actividades = $stmt->fetch(PDO::FETCH_ASSOC)) {
    	//	echo $actividades['dia'];
 		//}

		
		
		$myfile = fopen("newfile.json", "w") or die("Unable to open file!");
		//$txt = "John Doe\n";
		//fwrite($myfile, $txt);
		//$txt = "Jane Doe\n";
		//fwrite($myfile, $txt);
		//fclose($myfile);		 
		

		
		
		//echo "[";
		fwrite($myfile, "[");

		$arr = $stmt->fetch(PDO::FETCH_OBJ);
		//echo json_encode($arr);
		fwrite($myfile, json_encode($arr));

		while ($arr = $stmt->fetch(PDO::FETCH_OBJ)) { 
    		
    		//echo "," . json_encode($arr);
    		if(json_encode($arr) != "")
    			fwrite($myfile, "," . utf8_encode(json_encode($arr)));
    			//fwrite($myfile, "," . json_encode($arr));
		}

		//echo "]";
		fwrite($myfile, "]");

		
		
		fclose($myfile);


		$myfile = fopen("newfile.json", "r") or die("Unable to open file!");
		echo fread($myfile, filesize("newfile.json"));
		fclose($myfile);

		$db = null;

		//echo json_encode($actividades);

		

	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}




function getWines() {
	$sql = "select * FROM wine ORDER BY name";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"wine": ' . json_encode($wines) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getWine($id) {
	$sql = "SELECT * FROM wine WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$wine = $stmt->fetchObject();  
		$db = null;
		echo json_encode($wine); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function addWine() {
	error_log('addWine\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$wine = json_decode($request->getBody());
	$sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("name", $wine->name);
		$stmt->bindParam("grapes", $wine->grapes);
		$stmt->bindParam("country", $wine->country);
		$stmt->bindParam("region", $wine->region);
		$stmt->bindParam("year", $wine->year);
		$stmt->bindParam("description", $wine->description);
		$stmt->execute();
		$wine->id = $db->lastInsertId();
		$db = null;
		echo json_encode($wine); 
	} catch(PDOException $e) {
		error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateWine($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$wine = json_decode($body);
	$sql = "UPDATE wine SET name=:name, grapes=:grapes, country=:country, region=:region, year=:year, description=:description WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("name", $wine->name);
		$stmt->bindParam("grapes", $wine->grapes);
		$stmt->bindParam("country", $wine->country);
		$stmt->bindParam("region", $wine->region);
		$stmt->bindParam("year", $wine->year);
		$stmt->bindParam("description", $wine->description);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($wine); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function deleteWine($id) {
	$sql = "DELETE FROM wine WHERE id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function findByName($query) {
	$sql = "SELECT * FROM wine WHERE UPPER(name) LIKE :query ORDER BY name";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$wines = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"wine": ' . json_encode($wines) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getConnection() {
	
	
	$dbuser="root";
	$dbpass="root";
	$dbname="rh_tristone";
	$dbhost="localhost";
	
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname; charset=utf8", $dbuser, $dbpass);	
	
	$dbh->exec("set names utf8");
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
	//$dbh->setAttribute(PDO::MYSQL_ATTR_MAX_BUFFER_SIZE=>16777216);
	
	
	return $dbh;
}

?>