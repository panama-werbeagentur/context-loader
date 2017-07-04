<?php

namespace Panama\ContextLoader\Configuration;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Ruben Pascal Abel <r.abel@panama.de>, Panama Werbeagentur GmbH
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Class ContextLoader
 *
 * @package Panama\ContextLoader
 */
class ContextConfigurationManager
{
    /**
     * @var string Path to the basic file, for all Contexts, relative to PATH_site
     */
    protected $basicConfigurationFile = 'typo3conf/AdditionalConfiguration/AllContext.php';

    /**
     * @var bool
     */
    protected $basicConfigurationFileInUse = false;

    /**
     * @var string Path to the environment config file, for all Contexts, relative to PATH_site
     */
    protected $environmentConfigurationFile = 'typo3conf/ext/context_loader/Configuration/AdditionalConfiguration/EnvironmentContext.php';

    /**
     * @var bool
     */
    protected $environmentConfigurationFileInUse = false;

    /**
     * @var string Absolute path to typo3conf directory
     */
    protected $pathAdditionalConfiguration = PATH_typo3conf . 'AdditionalConfiguration/';

    /**
     * @var string[]
     */
    protected $registeredContextConfigurationFiles = [];

    /**
     * @param string $contextPath Path to use, to load the context configuration file
     *
     * @return void
     */
    public function registerContextConfiguration(string $contextPath)
    {
        $this->registeredContextConfigurationFiles[] = sprintf(
            '%s%sContext.php',
            $this->pathAdditionalConfiguration,
            $contextPath
        );
        return $this;
    }

    public function useEnvironmentConfiguration()
    {
        if (!$this->environmentConfigurationFileInUse) {
            array_unshift($this->registeredContextConfigurationFiles, PATH_site . $this->environmentConfigurationFile);
            $this->environmentConfigurationFileInUse = true;
        }
        return $this;
    }

    public function useEnvConfiguration()
    {
        return $this->useEnvironmentConfiguration();
    }

    /**
     * Do make use of the basic file for all contexts
     *
     * @return $this
     */
    public function useBasicConfiguration()
    {
        if (!$this->basicConfigurationFileInUse) {
            array_push($this->registeredContextConfigurationFiles, PATH_site . $this->basicConfigurationFile);
            $this->basicConfigurationFileInUse = true;
        }
        return $this;
    }

    /**
     * Load all registered context configuration files and merge them into the TYPO3_CONF_VARS
     *
     * @return void
     */
    public function loadAndMergeConfiguration()
    {
        foreach ($this->registeredContextConfigurationFiles as $file) {
            if (file_exists($file)) {
                $contextConfig = require $file;
                if (is_array($contextConfig)) {
                    $this->exportConfiguration($contextConfig);
                }
            }
        }
    }

    /**
     * Exports the config array into the global config array
     *
     * @param array $contextConfig
     */
    protected function exportConfiguration(array $contextConfig)
    {
        ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TYPO3_CONF_VARS'], $contextConfig, true, false, true);
    }

}
