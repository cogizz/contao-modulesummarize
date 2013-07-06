<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['modulesummarize'] = '{title_legend},name,headline,type;{config_legend},module_summarize_modules,module_summarize_template;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['module_summarize_modules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['module_summarize_modules'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'eval'                    => array(
		'mandatory'=>true,
		'tl_class' => 'long',
		'columnFields' => array(
			'pre_code' => array
			(
				'label'                 => &$GLOBALS['TL_LANG']['tl_module']['pre_code'],
				'exclude'               => true,
				'inputType'             => 'text',
				'eval' 			=> array('style' => 'width:180px','allowHtml' => true, 'decodeEntities' => false)
			),
			'module' => array
			(
				'label'                 => &$GLOBALS['TL_LANG']['tl_module']['module'],
				'exclude'               => true,
				'inputType'             => 'select',
				'options_callback'      => array('tl_module_module_summarize', 'loadModuleSummarizeOptions'),
				'eval' 			=> array('style' => 'width:230px', 'chosen'=>true)
			),
			'after_code' => array
			(
				'label'                 => &$GLOBALS['TL_LANG']['tl_module']['after_code'],
				'exclude'               => true,
				'inputType'             => 'text',
				'eval' 			=> array('style' => 'width:180px','allowHtml' => true, 'decodeEntities' => false)
			),
		)
	)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['module_summarize_template'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['module_summarize_template'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('mod_summarize_'),
	'eval'                    => array(
		'tl_class'=>'m12 w50'
	)
);


/**
 * Class tl_module_module_summarize
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Christopher Bölter 2013 Cogizz - digital communications
 * @author     Christopher Bölter <info@cogizz.de>
 * @package    ModuleSummarize
 */
class tl_module_module_summarize extends Backend
{

	/**
	 * Return all module summarize templates as array
	 * @param DataContainer
	 * @return array
	 */
	public function getModuleSummarizeTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('mod_summarize_', $intPid);
	}

	/**
	 * load the frontend module for the current theme based on pid oder module id
	 * @return array
	 */
	public function loadModuleSummarizeOptions() {
		$intPid = $this->Input->get('pid') ? $this->Input->get('pid') : $this->getPidIdFromModule($this->Input->get('id'));

		$objModule = $this->Database->prepare("SELECT id, name FROM tl_module Where pid = ?")->execute($intPid);
		$arrModule = array();

		while($objModule->next())
			$arrModule[$objModule->id] = $objModule->name;

		return $arrModule;
	}

	/**
	 * get the theme id by the module id
	 * @param $intModule
	 * @return int
	 */
	public function getPidIdFromModule($intModule) {
		return $this->Database->prepare("SELECT pid FROM tl_module Where id = ?")->execute($intModule)->pid;
	}
}

?>