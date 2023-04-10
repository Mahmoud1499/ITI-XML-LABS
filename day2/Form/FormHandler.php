<?php
class FormHandler
{
    public $filename;
    public $countData;

    public function __construct($filename)
    {
        $this->filename = $filename;
        // $this->filename = 'employees.xml';
    }
    public function loadXMLFile()
    {
        // Load existing XML file or create a new one if it doesn't exist
        if (file_exists($this->filename)) {
            $xml = simplexml_load_file($this->filename);
        } else {
            $xml = new SimpleXMLElement('<employees></employees>');
        }
        return $xml;
    }
    public function saveDataInXML()
    {
        // Retrieve form data
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];

        $xml = $this->loadXMLFile();

        // Add new employee data to XML
        $employee = $xml->addChild('employee');
        $employee->addChild('name', $name);
        $employee->addChild('phone', $phone)->addAttribute('type', 'mobile');
        $employee->addChild('address', $address);
        $employee->addChild('email', $email);

        // Save updated XML to file
        $xml->asXML($this->filename);
        echo "<p class='mt-4 text-center alert alert-success'>Employee data saved to $this->filename.</p>";
    }
    public function displayData($currentIndex)
    {
        $xml = $this->loadXMLFile();

        $employees = $xml->employees;
        $employees
            = json_decode(json_encode((array)$xml), TRUE);
        $this->countData = count($employees['employee']);



        $employee =
            $employees['employee'][$currentIndex];

        // var_dump($employee);
        return $employee;
    }
    public function getNextData($currentIndex)
    {
        if ($currentIndex + 1 < $this->countData) {
            $_SESSION["currentIndex"] += 1;
            $data = $this->displayData($currentIndex);
        } else {
            $_SESSION["currentIndex"] = 0;
        }
    }
    public function getPrevData($currentIndex)
    {
        if ($currentIndex  > 0) {
            $_SESSION["currentIndex"] -= 1;
            $data = $this->displayData($currentIndex);
        } else {
            $_SESSION["currentIndex"] = $this->countData - 1;
        }
    }

    public function updateData()
    {
        // Retrieve form data
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $currentIndex = $_POST['currentIndex'];

        $xml = $this->loadXMLFile();
        $employees
            = json_decode(json_encode((array)$xml), TRUE);
        // Update employee data in XML
        // $employee = $employees['employee'][$currentIndex];
        $employees = $xml->xpath('/employees/employee');

        var_dump($employees[$currentIndex]->name);
        $employee =   $employees[$currentIndex];

        $employee->name = $name;
        $employee->phone = $phone;
        $employee->address = $address;
        $employee->email = $email;

        // Save updated XML to file
        $xml->asXML($this->filename);
        echo "<p class='mt-4 text-center alert alert-success'>Employee data updated successfully.</p>";
    }

    public function searchByName($name)
    {
        $xml = $this->loadXMLFile();

        $employees = $xml->xpath("//employee[contains(name, '$name')]");
        $results = [];

        foreach ($employees as $employee) {
            $result = [
                'name' => (string) $employee->name,
                'phone' => (string) $employee->phone,
                'address' => (string) $employee->address,
                'email' => (string) $employee->email,
            ];
            $results[] = $result;
        }

        return $results;
    }
    public function deleteData($index)
    {
        $xml = $this->loadXMLFile();

        $employees = $xml->xpath('/employees/employee');
        // var_dump($employees[$index]);

        unset($employees[$index][0]);

        // Save updated XML to file
        $xml->asXML($this->filename);
        echo "<p class='mt-4 text-center alert alert-danger'>Employee data deleted from $this->filename.</p>";
    }
}
