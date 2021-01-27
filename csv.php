<?php 

class csv extends mysqli{
    private $stutas = false;
    public function __construct()
    {
        parent::__construct("localhost", "root", "", "csv");
        if($this->connect_errno){
            echo "Fail to connect to Database". $this->connect_errno;
        }
    }

    public function import($file){
        $flag = true;
        $file = fopen($file, "r");
        while(($row = fgetcsv($file)) !== false){
            //csv file first row(header) skip 
            if($flag) {
                $flag = false; 
                continue; 
            }

            //image import from url/link and save image within a loacl folder
            $img_url = $row[3];
            $my_dec = "image/";
            $filename = basename($img_url);
            $complate_loc = $my_dec.$filename;
            file_put_contents($complate_loc, file_get_contents($img_url));

            //data insert into database
            $q = "INSERT INTO persons(LastName, FirstName, img) VALUES('$row[1]', '$row[2]', '".$filename."')";
            if($this->query($q)){
                $this->stutas = true;
            }else{
                $this->stutas = false;
            }
        }

        if($this->stutas){
            echo "Sueccss";
        }else{
            echo $this->error;
        }
    }

    public function export(){
        $this->stutas = false;
        $q = " SELECT * FROM persons";
        $run = $this->query($q);
        if($run->num_rows>0){
            $fileName = "csv_". uniqid().".csv";
            $file = fopen("Files/".$fileName, "w");
            while($row = $run->fetch_array(MYSQLI_NUM)){
                if(fputcsv($file, $row)){
                    $this->stutas = true; 
                }else{
                    $this->stutas = false;
                }
            }
            if($this->stutas){
                echo "Sueccssfully exported";
            }else{
                echo $this->error;
            }
        }
    }
}