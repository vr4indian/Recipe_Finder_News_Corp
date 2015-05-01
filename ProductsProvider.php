<?php
class InpRecFind extends \Exception {}
/**
 * @version $Id$
 **/
class ProductsProvider
{
    private $productsArray; // array of items    
    public static function initFromCSV($csvFile)
    {
        if (!is_readable($csvFile['tmp_name']))
            throw new InpRecFind("Unreadable Ingredient csv file");
        
        $provider = new self;
        $fh = fopen($csvFile['tmp_name'], 'r');
                            
        if ($fh !== FALSE) 
		{
            
            while (($data = fgetcsv($fh, 1000, ",")) !== FALSE) 
			{
                try 
				{
                $obj = new stdClass();
                $obj->item = $data[0];
                $obj->amount = (int)$data[1];
                $obj->unit = $data[2];
  //              $obj->useBy = date('Y-m-d'.  strtotime($data[3]));
				$obj->useBy = DateTime::createFromFormat('d/m/Y', $data[3])->format('Y-m-d');
                $p = Product::initFromStdClass($obj);
                $provider->productsArray[] = $p;
				}
				catch (ValIng $e) 
				{
					echo "OOPs , something is incorrect in uploaded Ingredient csv File\n";
				}
			} 
        }
        return $provider;
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->productsArray;
    }
    
    public function isIngredientAvailable($ingredient, $cookingDate)
    {
        $item 	= $ingredient->getItem();
        $amount = $ingredient->getAmount();
        $unit 	= $ingredient->getUnit();

        foreach ($this->getProducts() as $product) 
		{
            if (
					$product->getItem() == $item && 
					$product->getAmount() >= $amount && 
					$product->getUnit() == $unit
				)
				
			{
                if (
						strtotime($product->getUseBy()) >= strtotime($cookingDate)
					)
								
				{
                    return $product->getUseBy();
                }
            }
        }

        return null;
    }

    public function areAllIngredientsAvailable($ingredients, $cookingDate = null)
    {
        if ($cookingDate == null) 
		{
            $cookingDate = date('Y-m-d');
        }
        $useByInfo = array();
        foreach ($ingredients as $ingredient) 
		{
            // Check one ingredient in all products.
            $foundInfo = $this->isIngredientAvailable($ingredient, $cookingDate);
			if(!$foundInfo) return null; // not found one return null, else continue for other ingredients.
            $useByInfo[] = $foundInfo;
			/*if(!empty($foundInfo)){
            $useByInfo[] = $foundInfo;   // found one add in info, else continue for other ingredients.
            } */           
        }
        // All ingredients checked, all found
        sort($useByInfo);
        return $useByInfo;
    }

   
    public function findClosetAvailableRecipe($recipesProvider, $cookingDate = null)
    {
        if ($cookingDate == null) 
		{
            $cookingDate = date('Y-m-d');
        }
        $availRecipes = array();
        foreach ($recipesProvider->getRecipes() as $recipe) 
		{
            $useByInfo = $this->areAllIngredientsAvailable($recipe->getIngredients(), $cookingDate);
            if (!empty($useByInfo)) 
			{
                $key = implode(',', $useByInfo);
                $availRecipes[$key] = $recipe->getName();
            }
        }

        return $this->pickClosetRecipeFromAvailable($availRecipes);
    }

    public function pickClosetRecipeFromAvailable($availRecipes)
    {
        if(empty($availRecipes)) return false;
        $keys = array_keys($availRecipes);
        sort($keys);
        $closestKey = $keys[0];
        return $availRecipes[$closestKey];
    }
}