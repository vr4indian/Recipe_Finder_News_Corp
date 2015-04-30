<?php
$err;
if (isset($_POST['submit'])) 
{
   
	 /* validate file extension / type */
    if ($_FILES['Ingredient']['type'] != 'application/vnd.ms-excel' || $_FILES['recipe']['type'] != 'application/octet-stream') 
	{
	/* Need to keep separate validation message so that user knows what is wrong rather then keep guessing
	Pending 
	*/
        $err = "Please upload proper file format";
		
    } else 
	{
        $recipeName = "";
        try 
		{
            include_once 'Autoload.php';
			/* read uploaded files */
            $Ingredient = $_FILES['Ingredient'];
            $recipe 	= $_FILES['recipe'];
            $cookingDate = date('Y-m-d');	
			$recipes = RecipesProvider::initFromJson($recipe);
            $products = ProductsProvider::initFromCSV($Ingredient);
            $recipeName = $products->findClosetAvailableRecipe($recipes, $cookingDate);			
        }
        catch (ValIng $e) 
		{

            $recipeName =  $e->getMessage() . "\n";
        }
        catch (ValRec $e) 
		{

            $recipeName =  $e->getMessage() . "\n";
            
        } catch (InpRecFind $e) 
		{            
			 $recipeName =  $e->getMessage() . "\n";          
		}
}
}
include('view/form.php');