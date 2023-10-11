<?php

    class Properties extends Dbh{
        
        protected function createProperty($propName,$propType,$propDescription,$propContact,$propPrice,$propSize,$propLeaseType,$propMonthlyPay,$propStatus,$propUnits,$propAvailableUnits,$propBeds,$propBaths,$propSqrfoot,$image_path,$listType){

            $sql = "INSERT INTO properties(propName,propType,propDescription,propContact,propPrice,propSize,propLeaseType,propMonthlyPay,propStatus,propUnits,propAvailableUnits,propBeds,propBaths,propSqrfoot,image,listType)
            VALUES
            ('$propName','$propType','$propDescription',$propContact,$propPrice,'$propSize','$propLeaseType',$propMonthlyPay,'$propStatus',$propUnits,$propAvailableUnits,$propBeds,$propBaths,$propSqrfoot,'$image_path','$listType')";

        // return $sql;

            $stmt = $this->connect()->prepare($sql);

            if(!$stmt->execute()){
                $stmt = null;
                exit();
            }

            return 'success';

            $stmt = null;
        }

        protected function fetchProperties(?String $query_params){
            
            // $sql = print_r($query_params);

            // if(empty($query_params)){
            //     $sql = "SELECT * FROM  properties " ;
            // }else{
            //     $sql = "SELECT * FROM  properties where $query_params";
            // }

            $query_params ? $sql = "SELECT * FROM  properties where $query_params" : $sql = "SELECT * FROM  properties "  ;

            // return $sql;

            $stmt = $this->connect()->prepare($sql);
        
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $results;



        }

        protected function delProperties($query_params){
            
            // $sql = print_r($query_params);

            // if(empty($query_params)){
            //     $sql = "SELECT * FROM  properties " ;
            // }else{
                $sql = "SELECT * FROM  properties where $query_params";

                $stmt = $this->connect()->prepare($sql);
        
                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $fileName = explode('/',$results[0]['image']);



                $file  = $fileName[(count($fileName) - 1)];

                


                if(unlink("classes/Properties/propImages/".$file)){

                     "file named $file has been deleted successfully";

                     $sql = "DELETE FROM  properties where $query_params" ;//: $sql = "SELECT * FROM  properties "  ;

                    // return $sql;

                    $stmt = $this->connect()->prepare($sql);
                
                    if($stmt->execute()){

                        return 'success';

                    }

                }else{

                    
                    $sql = "DELETE * FROM  properties where $query_params" ;//: $sql = "SELECT * FROM  properties "  ;

                    // return $sql;

                    $stmt = $this->connect()->prepare($sql);
                
                    if($stmt->execute()){

                        return 'success';

                    };


                }

                // $fileName = print_r($fileName);

                // return $file;



                // if(unlink($file))
                // {
                //     echo "file named $file has been deleted successfully";
                // }
                // else
                // {
                //     echo "file is not deleted";
                // }

            // $data = "item2.txt";
            // $dir = "items";
            // while ($file = readdir($dirHandle)) {
            //     if ($file==$data) {
            //         unlink($dir.'/'.$file);
            //     }
            // }
            // // }

            // $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // return $results;

        }

    
    }

    // INSERT INTO properties(propName,propType,propDescription,propContact,propPrice,propSize,propLeaseType,propMonthlyPay,propStatus,propUnits,propAvailableUnits,propBeds,propBaths,propSqrfoot,image)VALUES ('test','test','tes',,,'','',,'',,,,,,'/home/hanno/Desktop/logo/property listing/db/classes/Properties/propImages/img_8dfc03d.png')
