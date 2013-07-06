-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************


-- --------------------------------------------------------

--
-- Table `tl_module`
--

CREATE TABLE `tl_module` (
  `module_summarize_modules` blob NOT NULL,
  `module_summarize_template` varchar(64) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;