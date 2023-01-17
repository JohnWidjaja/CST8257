<?php
class Student {
    private $studentId;
    private $name;
    private $phone;
    
    public function __construct($studentId, $name, $phone)
    {
        $this->studentId = $studentId;
        $this->name = $name;
        $this->phone = $phone;
    }
    
    public function getStudentId() {
        return $this->studentId;
    }

    public function getName() {
        return $this->name;
    }

    public function getPhone() {
        return $this->phone;
    }

}

