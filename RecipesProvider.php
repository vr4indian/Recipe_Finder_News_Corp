<?php
/**
  * @version $Id$
**/

class RecipesProvider
{
    private $recipesObjArr; // Array of class Recipe

    /**
     * @return Recipe[]
     */
    public function getRecipes()
    {
        return $this->recipesObjArr;
    }

    /**
     * @param $jsonFile
     * @return RecipesProvider
     */
    public static function initFromJson($jsonFile)
    {
        if (!is_readable($jsonFile['tmp_name'])) 
            throw new InpRecFind("OOps, System cannot read uploaded recipes json file. Verify format.");
        
        $provider = new self;
        $recipesJson = json_decode(file_get_contents($jsonFile['tmp_name']));

        if ($recipesJson === null) 
            throw new InpRecFind("OOps, System cannot parse uploaded recipes json file. Make sure it is in correct format.");
        
        foreach ($recipesJson as $objReceipt) {
            try {
            $ingredients = array();
            foreach ($objReceipt->ingredients as $ingredientObj) {
                try {
                $ingredients[] = Ingredient::initFromStdClass($ingredientObj);
            } catch (ValIng $e) {
                        echo "OOPs , something is not correct. check the recipe's ingredient on \n";
                    }
            }
            }catch (ValRec $e) {
                echo "OOPs , something is incorrect in recipe name\n";
            }
            $recipe = new Recipe($objReceipt->name);
            $provider->recipesObjArr[] = $recipe->setIngredients($ingredients);
        }
        return $provider;
    }

    /**
     * @return Recipes[]
     */
    public function getRecipeNameIngredients()
    {
        return $this->recipesObjArr;
    }

}
