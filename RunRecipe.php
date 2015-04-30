<?php
$err;
if (isset($_POST['submit'])) 
{
   
	 
    if ($_FILES['Ingredient']['type'] != 'application/vnd.ms-excel' || $_FILES['recipe']['type'] != 'application/octet-stream') 
	{
	/* Need to keep separate validation message so that user knows what is wrong rather then keep guessing
	Pending 
	*/
        $err = "Please upload proper file format";
		
    } else 
	{
        $recipeName = "";
        try {
            include_once 'Autoload.php';

            $Ingredient = $_FILES['Ingredient'];
            $recipe 	= $_FILES['recipe'];
            $cookingDate = date('Y-m-d');			           
        }
         catch (RecipeException $e) 
		 {            
            $recipeName =  $e->getMessage() . "\n";
        }
    }
}
include('view/form.php');





