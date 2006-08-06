<?php

require_once 'PEAR/PackageFileManager.php';

$version = 'XXX';
$notes = <<<EOT
- fixed warning due to not checking with isset()
- return an error if a name placeholder name is used twice inside a single statement

open todo items:
- make MDB2_Schema loadable via MDB2_Driver_Common::loadModule() (Bug #8270)
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
$package->addMaintainer('ifeghali', 'developer', 'Igor Feghali', 'ifeghali@php.net');

$package->addDependency('php',     '4.2.0', 'ge',  'php', false);
$package->addDependency('PEAR',    '1.0b1', 'ge',  'pkg', false);
$package->addDependency('MDB2',    '2.2.0', 'ge',  'pkg', false);
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
