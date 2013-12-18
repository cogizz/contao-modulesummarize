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
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['modulesummarize'] = '{title_legend},name,type;{config_legend},module_summarize_modules,module_summarize_template;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['module_summarize_modules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['module_summarize_modules'],
	'exclude'                 => true,
	'inputType'               => 'multiColumnWizard',
	'sql'											=> "blob NOT NULL",
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
	'sql'											=> "varchar(64) NOT NULL default ''",
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

		if (\Input::get('act') == 'overrideAll')
		{
			$intPid = \Input::get('id');
		}

		return \Controller::getTemplateGroup('mod_summarize_', $intPid);
	}

	/**
	 * load the frontend module for the current theme based on pid oder module id
	 * @return array
	 */
	public function loadModuleSummarizeOptions() {
		$intPid =\Input::get('pid') ? \Input::get('pid') : tl_module_module_summarize::getPidIdFromModule($this->Input->get('id'));

		$objDatabase = \Database::getInstance();
		$objModule = $objDatabase->prepare("SELECT id, name FROM tl_module Where pid = ?")->execute($intPid);
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
		$objDatabase = \Database::getInstance();
		return $objDatabase->prepare("SELECT pid FROM tl_module Where id = ?")->execute($intModule)->pid;
	}
}