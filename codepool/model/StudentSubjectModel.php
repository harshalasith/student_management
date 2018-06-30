<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class StudentSubjectModel
 */
class StudentSubjectModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $tableName = 'student_subject';

    /**
     * @var
     */
    private $studentId;

    /**
     * @var
     */
    private $subjectId;

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
     * @return array
     */
    public function initAttributes()
    {
        $this->attributes = [
            'student_id' => ['label' => 'Student Id', 'required' => true],
            'subject_id' => ['label' => 'Subject Id', 'required' => true]
        ];
    }

    /**
     * @return mixed
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param mixed $studentId
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return mixed
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    /**
     * @param mixed $subjectId
     */
    public function setSubjectId($subjectId)
    {
        $this->subjectId = $subjectId;
    }
  }
