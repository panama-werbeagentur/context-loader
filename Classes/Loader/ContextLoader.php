<?php

namespace Panama\ContextLoader\Loader;

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

use Panama\ContextLoader\Configuration\ContextConfigurationManager;
use TYPO3\CMS\Core\Core\ApplicationContext;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ContextLoader
 *
 * @package Panama\ContextLoader
 */
class ContextLoader
{
    /**
     * @var \Panama\ContextLoader\Loader\ContextLoader
     */
    protected static $instance = null;

    /**
     * The application context
     *
     * @var \TYPO3\CMS\Core\Core\ApplicationContext
     */
    protected $applicationContext;

    /**
     * Our context configuration loader class
     *
     * @var \Panama\ContextLoader\Configuration\ContextConfigurationManager
     */
    protected $configurationManager;

    /**
     * Is the configuration already loaded?
     *
     * @var bool
     */
    protected static $configurationLoaded = false;

    /**
     * Disable direct creation of this object.
     *
     * @var \TYPO3\CMS\Core\Core\ApplicationContext Application context
     */
    protected function __construct(ApplicationContext $applicationContext)
    {
        $this->applicationContext = $applicationContext;
        $this->configurationManager = new ContextConfigurationManager();
    }

    /**
     * Disable direct cloning of this object.
     */
    protected function __clone()
    {
    }

    /**
     * Return 'this' as singleton
     *
     * @return \Panama\ContextLoader\Loader\ContextLoader
     * @internal This is not a public API method, do not use in own extensions
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            $applicationContext = GeneralUtility::getApplicationContext() ?: Bootstrap::getInstance()->getApplicationContext();
            self::$instance = new static($applicationContext);
        }
        return static::$instance;
    }

    /**
     * Load and populate the context configurations
     *
     * @return $this
     */
    public function loadConfiguration()
    {
        if (!self::$configurationLoaded) {
            $this->registerContextConfiguration();

            // TODO: Optimize this out of the function to a public api
            $this->configurationManager
                ->useEnvironmentConfiguration()
                ->useBasicConfiguration()
                ->loadAndMergeConfiguration();

            self::$configurationLoaded = true;
        }
        return $this;
    }

    /**
     * Register all stacked context configurations
     *
     * @param \TYPO3\CMS\Core\Core\ApplicationContext|null $applicationContext Internal, for passing the sub-contexts
     *
     * @return $this
     */
    protected function registerContextConfiguration(ApplicationContext $applicationContext = null)
    {
        if (!isset($applicationContext)) {
            $applicationContext = $this->applicationContext;
        }
        if ($parentContext = $applicationContext->getParent()) {
            $this->registerContextConfiguration($parentContext);
        }
        $this->configurationManager->registerContextConfiguration((string)$applicationContext);

        return $this;
    }

    /**
     * Appends the context name to the sitename string
     *
     * @return $this
     */
    public function appendContextNameToSitename()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = sprintf(
            '%s [%s]',
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'],
            (string)$this->applicationContext
        );
        return $this;
    }

    /**
     * Appends the context name to the sitename string
     *
     * @return $this
     */
    public function appendContextNameToSitenameInDevelopment()
    {
        if ($this->applicationContext->isDevelopment()) {
            $this->appendContextNameToSitename();
        }
        return $this;
    }

}
