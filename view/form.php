<?php include('header.php');?>
</head>
<body>
	<div class="container form">
		<div class="col-md-4 col-md-offset-4">
			<h1 class="text-center">Find a Recipe</h1>
			<form enctype='multipart/form-data' action="" method="POST">
				<label for="ingredients">Upload  ingredients [ csv file ] here:</label>
                                <input required type='file' name='Ingredient'>
                                <br>
				<label for="ingredients">Upload  recipe [ json file ]  here:</label>
                                <input required type='file' name='recipe'>
                                <br>
				<div class="btn-group">
					<button type="submit" name='submit' class="btn btn-success">Submit</button>
				</div>
			</form>
                        <h4 class="text-center"><?php if(!empty($err)) echo $err;?></h4>
		</div>
<?php include('results.php');?>
<?php include('footer.php');?>