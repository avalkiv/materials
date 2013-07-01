<?php

/**
 * Class ModuleMaterials
 */
class ModuleMaterials extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_materials';


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$intCategory = ($this->Input->get('category')) ? $this->Input->get('category') : 1;
		$arrMaterials = array();


		/**
		 * Database query
		 */
		$objMaterials 	= $this->Database->prepare("SELECT * FROM tl_materials WHERE pid=? ORDER BY title")->execute($intCategory);
		$objCategory  	= $this->Database->prepare("SELECT * FROM tl_materials_category WHERE id=?")->execute($intCategory);
		$objCategories  = $this->Database->execute("SELECT id, title FROM tl_materials_category ORDER BY title");
		
		while($objMaterials->next())
		{
			$arrMaterials[] = array
			(
				'title' = $objMaterials->title,
				'image' = $objMaterials->image,
				'src'   = $objMaterials->src
			);
		}

		while($objCategories->next())
		{
			$arrCategories[] = array
			(
				'id' 		= $objCategories->id,
				'title'		= $objCategories->title,
				'singleSRC' = $objCategories->singleSRC,
				'selected' 	= $blnSelected
			);
		}


		/**
		 * Registrate arrays in Template
		 */
		$this->Template->materials = $arrMaterials;
		$this->Template->categories = $arrCategories;
		$this->Template->categoryTitle = $objCategory->title;
		$this->Template->categoryImage = $objCategory->singleSRC;
	}
}
