<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class SubjectModel
 */
class SubjectModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $tableName = 'subject';
    /**
     * @var
     */
    private $subject;

    /**
     * SubjectModel constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->initAttributes();
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return array
     */
    public function initAttributes()
    {
        $this->attributes = [
            'subject' => ['label' => 'Subject', 'required' => true],
            'subject_id' => ['label' => 'Subject Id', 'required' => true]
        ];
    }
}
