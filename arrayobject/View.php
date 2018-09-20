<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 27/01/2016
 * Time: 17:45
 */

namespace arrayObject;

class View extends ArrayObject
{

    const DEFAULT_TEMPLATE_FILE = 'default_template.php';
    protected $_templateFile;

    /**
     * Constructor
     */
    public function __construct(array $fields = array(), $templateFile = self::DEFAULT_TEMPLATE_FILE)
    {

        parent::__construct($fields, ArrayObject::ARRAY_AS_PROPS);

        $this->setTemplateFile($templateFile);
    }

    /**
     * Set the template file
     */
    public function setTemplateFile($templateFile)
    {
        if (!file_exists($templateFile) || !is_readable($templateFile)) {
            throw new InvalidArgumentException(‘The specified template file is invalid.’);
        }
        $this->_templateFile = $templateFile;
    }

    /**
     * Get the template file
     */
    public function getTemplateFile()
    {
       return $this->_templateFile;
    }

    /**
     * Reset the template file to the default one
     */
    public function resetTemplateFile()
    {
        $this->_templateFile = self::DEFAULT_TEMPLATE_FILE;
    }

    /**
     * Render the template file
     */
    public function render()
    {
        $fields = $this->getArrayCopy();
        extract($fields);
        include $this->_templateFile;
        return ob_get_clean();
    }
}



?>