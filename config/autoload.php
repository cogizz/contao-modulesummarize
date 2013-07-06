<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Modulesummarize
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Cogizz',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'Cogizz\ModuleSummarize' => 'system/modules/modulesummarize/modules/ModuleSummarize.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_summarize_default' => 'system/modules/modulesummarize/templates',
	'mod_summarize_plain'   => 'system/modules/modulesummarize/templates',
));
