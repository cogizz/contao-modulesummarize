<?php

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Cogizz;

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 *
 * PHP version 5
 * @copyright  Christopher Bölter 2013 Cogizz - digital communications
 * @author     Christopher Bölter <info@cogizz.de>
 * @package    ModuleSummarize
 * @license    LGPL
 */

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
				'module' => $this->getFrontendModule($module['module']),
				'after_code' => $module['after_code']
			);
		}

		$this->Template->arrModules = $arrBuffer;
	}
}

?>