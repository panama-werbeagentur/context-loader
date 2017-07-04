<?php

defined('TYPO3_MODE') || exit('Access denied.');

\Panama\ContextLoader\Loader\ContextLoader::getInstance()
    ->loadConfiguration()
    ->appendContextNameToSitenameInDevelopment();
