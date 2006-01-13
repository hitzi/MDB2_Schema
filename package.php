<?php

require_once 'PEAR/PackageFileManager.php';

$version = '0.4.2';
$notes = <<<EOT
- added ability to dump sql instead of commiting it to the database in the example
- fix for bug in handling of boolean default values (bug #6397)
- default to notnull = false in the schema parser
- several fixes for database alterations (thx Matthias)
- default for autoincrement can be '0' or 0 in the parser
- set default 0 for autoincrement columns when reverse engineering a schema
- expect MDB2_ERROR_ALREADY_EXISTS when creating a database (bug #6481)

open todo items:
- better handling for NULL values in the xml schema format
EOT;

$description =<<<EOT
PEAR::MDB2_Schema enables users to maintain RDBMS independant schema
files in XML that can be used to create, alter and drop database entities
and insert data into a database. Reverse engineering database schemas from
existing databases is also supported. The format is compatible with both
PEAR::MDB and Metabase.
EOT;

$package = new PEAR_PackageFileManager();

$result = $package->setOptions(
    array(
        'package'           => 'MDB2_Schema',
        'summary'           => 'XML based database schema manager',
        'description'       => $description,
        'version'           => $version,
        'state'             => 'beta',
        'license'           => 'BSD License',
        'filelistgenerator' => 'cvs',
        'ignore'            => array('package.php', 'package.xml'),
        'notes'             => $notes,
        'changelogoldtonew' => false,
        'simpleoutput'      => true,
        'baseinstalldir'    => '/',
        'packagedirectory'  => './',
        'dir_roles'         => array(
            'docs' => 'doc',
             'examples' => 'doc',
             'tests' => 'test',
        ),
    )
);

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}

$package->addMaintainer('lsmith', 'lead', 'Lukas Kahwe Smith', 'smith@pooteeweet.org');

$package->addDependency('php',     '4.2.0', 'ge',  'php', false);
$package->addDependency('PEAR',    '1.0b1', 'ge',  'pkg', false);
$package->addDependency('MDB2', '2.0.0RC1', 'ge',  'pkg', false);
$package->addDependency('XML_Parser', true, 'has', 'pkg', false);
$package->addDependency('XML_DTD',    true, 'has', 'pkg', true);

$package->addglobalreplacement('package-info', '@package_version@', 'version');

if (isset($_GET['make']) || (isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'make')) {
    $result = $package->writePackageFile();
} else {
    $result = $package->debugPackageFile();
}

if (PEAR::isError($result)) {
    echo $result->getMessage();
    die();
}
