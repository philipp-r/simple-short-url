<?php
require_once( dirname( __FILE__ ) . '/user/config.php' );

// Short URL redirect
if ( !empty($_GET["s"]) ) {

  if( !preg_match("/^[a-zA-Z0-9]+$/", $_GET['s']) ){
    // error handling
    http_response_code(404);
    echo 'Error: Invalid short URL! <a href="'.YOURLS_SITE.'">Go to '.YOURLS_SITE.'</a>';
    die;
  }

  // connect to mysql db
  try{
    $db = new PDO('mysql:host='.YOURLS_DB_HOST.';dbname='.YOURLS_DB_NAME, YOURLS_DB_USER, YOURLS_DB_PASS);
  }
  catch(PDOException $e){
    // error handling
    http_response_code(503);
    echo 'Error: Cannot connect to database! <a href="'.YOURLS_SITE.'">Go to '.YOURLS_SITE.'</a>';
    die;
  }

  // get url from db
  $dbQuery = $db->prepare("SELECT * FROM `".YOURLS_DB_PREFIX."url` WHERE `keyword` = :keyword");
  $dbExecData = array(
    ":keyword" => $_GET["s"]
  );
  $dbQuery->execute($dbExecData);
  $dbD = $dbQuery->fetch(PDO::FETCH_ASSOC);

  if(!is_array($dbD)){
    // error handling
    http_response_code(404);
    echo 'Error: Short URL not found! <a href="'.YOURLS_SITE.'">Go to '.YOURLS_SITE.'</a>';
    die;
  }

  // redirect to the URL
  // $dbD['url']
  http_response_code(302);
  header("Location: ".$dbD['url']);
  echo 'Redirecting to: '.$dbD['url'];
  die;

}



// Homepage
else { ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex,nofollow">
	<title>URL Shortener</title>
  <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
</head>

<body role="document" class="">

		<nav class="navbar navbar-default navbar-static-top">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="reloadlink navbar-brand" href="<?php echo YOURLS_SITE; ?>">URL Shortener</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
				</ul>
			</div>
		</nav>
		<main>

    <section class="container">
    <h1>No more short URLs</h1>

		<div role="alert" class="alert alert-warning">
			<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
			You cannot create new short URLs with <?php echo YOURLS_SITE; ?>.  All existing links will stay available and are preserved.
		</div>
    </section>


			<footer class="container"><hr>
        <p>(c) <?php echo YOURLS_SITE; ?></p>
			</footer>

		</main>


</body>
</html>
<?php } ?>
