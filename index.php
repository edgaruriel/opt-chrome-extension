<?php $items = include 'start.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Simple feed</title>

	<!-- Bootstrap CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		</head>
		<body>
			<h1 class="text-center">Welcome to the Simple Feed</h1>
			<div class="container">
				<div class="row">
					<?php foreach ($items as $item) : ?>
						<div class="">
							<article>
								<header>
									<h1><a href="findFeed.php?feedId=<?= $item["itemId"]  ?>"><?= $item["title"] ?></a></h1>
									<p>Author: <?= $item["author"] ?></p>
									<p>Date: <?= $item["date"] ?></p>
									<p><?= $item["description"] ?></p>
									<h2><?= $item["itemId"] ?></h2>
								</header>
							</article>
						</div>
					<?php endforeach ?>
				</div>
			</div>
			<!-- jQuery -->
			<script src="//code.jquery.com/jquery.js"></script>
			<!-- Bootstrap JavaScript -->
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
		</body>
		</html>