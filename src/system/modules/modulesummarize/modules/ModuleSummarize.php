<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package   ModuleSummarize
 * @author    Christopher Bölter
 * @license   LGPL
 * @copyright cogizz - digital communications
 */

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Cogizz;

/**
 * Class ModuleSummarize
 *
 * Front end module "module summarize".
 * @copyright  Christopher Bölter 2013 Cogizz - digital communications
 * @author     Christopher Bölter <info@cogizz.de>
 * @package    ModuleSummarize
 */
class ModuleSummarize extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_summarize_default';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### MODULE SUMMARIZE ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		// Fallback template
		if (!strlen($this->module_summarize_template))
		{
			$this->module_summarize_template = $this->strTemplate;
		}

		$this->strTemplate = $this->module_summarize_template;

		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$arrModules = deserialize($this->module_summarize_modules);
		$arrBuffer = array();

		// load the frontend module
		foreach($arrModules as $module) {
			$arrBuffer[] = array(
				'pre_code' => $module['pre_code'],
				'module' => \Controller::getFrontendModule($module['module']),
				'after_code' => $module['after_code']
			);
		}

		$this->Template->arrModules = $arrBuffer;
	}
}