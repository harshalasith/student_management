<?php
/**
 * @author      Harsha Lasith <avhlasith@gmail.com>
 * @copyright   Copyright (c) 2018
 */

/**
 * Class Student
 */
class Student extends Controller
{
    /**
     * @var mixed
     */
    private $studentModel;

    /**
     * @var mixed
     */
    private $subjectModel;

    /**
     * @var mixed
     */
    private $studentSubjectModel;

    /**
     * @var null
     */
    private $pageData = null;

    /**
     * Student constructor.
     */
    public function __construct()
    {
        try {
            parent::__construct();
            $this->studentModel = $this->loadModel('StudentModel');
            $this->subjectModel = $this->loadModel('SubjectModel');
            $this->studentSubjectModel = $this->loadModel('StudentSubjectModel');
        } catch (Exception $e) {
            $this->sessionHandler->setSessionData('messages', ['error' => ['exception' => $e->getMessage()]]);
        }
    }

    /**
     * Index action
     */
    public function index()
    {
        $students = null;
        $subjects = null;
        //load student model if exist
        if ($this->studentModel instanceof StudentModel) {
            $students = $this->studentModel->decorateStudentData();
        }

        //load subject model if exist
        if ($this->subjectModel instanceof SubjectModel) {
            $subjects = $this->subjectModel->load();
        }

        $this->pageData['students'] = $students;
        $this->pageData['subjects'] = $subjects;
        $this->pageData['messages'] = $this->sessionHandler->getSessionData('messages');
        $this->pageData['formdata'] = $this->sessionHandler->getSessionData('formdata');
        $this->sessionHandler->clearSessionData('messages');
        $this->sessionHandler->clearSessionData('formdata');
        //render index page
        $this->renderPage("student/index", $this->pageData);
    }

    /**
     * Add student data to database
     */
    public function addStudent()
    {
        $errors = null;
        $messages = [];
        try {
            if (isset($_POST["save_student_data"])) {
                $data = $_POST["student"];
                //set data to moddel
                $this->studentModel->setData($data);
                //validate data
                if ($this->studentModel->validate()) {
                    //save student data
                    $this->studentModel->addStudentData();
                    //clear data
                    $this->studentModel->clear();
                    $messages['success'][] = "Student saved successfully";
                } else {
                    $errors = $this->studentModel->getErrors();
                    $this->sessionHandler->setSessionData('formdata', $data);
                    $messages['error'] = $errors;
                }
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            $messages['error'] = $errors;
        }
        $this->sessionHandler->setSessionData('messages', $messages);
        header('location: ' . URL . 'student/index');
    }
}
