<?php

namespace Library\Migrations\FileApi;

abstract class AbstractFileGenerator
{

    /** @var string The directory where the created file will be */
    protected $directory;

    /** @var Object The database variables */
    protected $dbVars;

    /** @var string The database name */
    protected $dbName;

    /**
     * Sets the create file directory
     *
     * @param $directory
     * @return $this
     */
    public function setDirectory($directory)
    {

        $this->directory = $directory;

        return $this;

    }

    /**
     * Sets the database name
     *
     * @param $dbName
     * @return $this
     */
    public function setDbName($dbName)
    {

        $this->dbName = $dbName;

        return $this;

    }

    /**
     * Sets the database variables
     *
     * @param $variables
     * @return $this
     */
    public function setDatabaseVariables($variables)
    {

        $this->dbVars = $variables;

        return $this;

    }

    /**
     * Creates a new file with the data provided
     *
     * @param $name
     * @param $data
     * @throws \Exception
     */
    public function create($name, $data)
    {

        $this->createDatabaseFolder();

        $newFileName = $this->directory . $this->dbName . '/' . $name;

        if(@file_put_contents($newFileName, $data))
        {

            return true;

        }
        else
        {

            throw new \Exception('Unable to create new schema file: ' . $name . ' in directory: ' . $this->directory);

        }

    }

    public function createDatabaseFolder()
    {

        $dir = $this->directory . $this->dbName;

        if(!is_dir($dir))
        {

            if(@mkdir($dir))
            {

                return true;

            }
            else
            {

                throw new \Exception('Unable to create database folder in schemas folder, check permissions...');

            }

        }

    }

}