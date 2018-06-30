<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class Student
 */
class StudentModel extends AbstractModel
{
    /**
     * @var string
     */
    protected $tableName = "student";

    /**
     * Student Id
     * @var Integer
     */
    private $studentId;

    /**
     * Student first name
     * @var String
     */
    private $firstName;

    /**
     * Student last name
     * @var String
     */
    private $lastName;

    /**
     * selected subjects
     * @var null/array
     */
    private $subjects = null;

    /**
     * StudentModel constructor.
     * @throws Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->initAttributes();
    }

    /**
     * @param int $studentId
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return String
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param String $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param String $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return null
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * @param null $subjects
     */
    public function setSubjects($subjects)
    {
        $this->subjects = $subjects;
    }

    /**
     * @return array
     */
    public function initAttributes()
    {
        $this->attributes = [
            'first_name' => ['label' => 'First Name', 'required' => true],
            'last_name' => ['label' => 'Last Name', 'required' => true],
            'subjects' => ['label' => 'Subjects', 'required' => false]
        ];
    }

    /**
     * Get all student data
     * @return mixed
     */
    public function getAllStudentData()
    {
        $sql = "select st.student_id, st.first_name, st.last_name, sb.subject_id, sb.subject 
                    from student as st
                    inner join student_subject as ss on st.student_id = ss.student_id
                    inner join subject as sb on sb.subject_id = ss.subject_id order by st.student_id desc ";
        $query = $this->connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Add student data
     */
    public function addStudentData()
    {
        try {
            $this->connection->beginTransaction();
            $this->addStudent();
            $this->addStudentSubjects();
            $this->connection->commit();
        } catch (PDOExecption $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    /**
     * @return array
     */
    public function getAllSubjects()
    {
        $sql = "SELECT subject_id, subject FROM subject";
        $query = $this->connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Add Student data
     */
    public function addStudent()
    {
        $studentId = $this->save();
        $this->setStudentId($studentId);
    }

    /**
     * Save student subjects
     */
    public function addStudentSubjects()
    {
        $studentSubjectModel = new StudentSubjectModel();
        foreach ($this->subjects as $subjectId) {
            $studentSubjectModel->setData(['student_id' => $this->studentId, 'subject_id' => $subjectId]);
            $studentSubjectModel->save();
        }
    }

    /**
     * @return array
     */
    public function decorateStudentData() {
        $studentData = $this->getAllStudentData();
        $decoratedData = [];
        foreach ($studentData as $student) {
            if(!isset($decoratedData[$student->student_id])) {
                $decoratedData[$student->student_id] = ['first_name' => $student->first_name, 'last_name' => $student->last_name, 'subject' => $student->subject];

            } else {
                $decoratedData[$student->student_id]['subject'] .= ', '.$student->subject;
            }
        }
        return $decoratedData;
    }
}
