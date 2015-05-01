<?php
/**
  * @version $Id$
**/
/**
 * Class Product
 *
 * Product is Ingredient with a due date, to avoid confusion with an ingredient, I use product here.
 */
class Product extends Ingredient
{
    protected $useBy;

    public static function initFromStdClass($std)
    {
        $instance = new self;
        $instance->item 		= $std->item;
        $instance->amount	 	= $std->amount; 
        $instance->unit		 	= $std->unit;
        $instance->useBy 		= $std->useBy; 
        return $instance;
    }

    public function getUseBy()
    {
        return $this->useBy;
    }
}