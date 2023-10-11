<?php

class PropertiesContr extends Properties{

    private $propName;
    private $propType;
    private $listType;
    private $propDescription;
    private $propContact;
    private $propPrice;
    private $propSize;
    private $propLeaseType;
    private $propMonthlyPay;
    private $propStatus;
    private $propUnits;
    private $propAvailableUnits;
    private $propBeds;
    private $propBaths;
    private $propSqrfoot;
    private $image;

    public function __construct($values){
        $val = $values;
        $this -> propName = $val['propName'] ?? null;
        $this -> propType = $val['propType'] ?? null;
        $this -> listType = $val['listType'] ?? null;
        $this -> propDescription = $val['propDescription'] ?? null;
        $this -> propContact = $val['propContact'] ?? 0;
        $this -> propPrice = $val['propPrice'] ?? 0;
        $this -> propSize = $val['propSize'] ?? 0;
        $this -> propMonthlyPay = $val['propMonthlyPay'] ?? 0;
        $this -> propLeaseType = $val['propLeaseType'] ?? '-';
        $this -> propStatus = $val['propStatus'] ?? '-';
        $this -> propUnits = $val['propUnits'] ?? 0;
        $this -> propAvailableUnits = $val['propAvailableUnits'] ?? 0;
        $this -> propBeds = $val['propBeds'] ?? 0;
        $this -> propBaths = $val['propBaths'] ?? 0;
        $this -> propSqrfoot = $val['propSqrfoot'] ?? '-';
        $this -> image = $val['image'] ?? null;

    }

    function saveImage() {
      
        // $path = dirname(__FILE__)."/propImages";
        // $path = dirname()."propImages";
        // $path = getcwd();
        // $path = chdir('classes/Properties/propImages');
        $path = dirname('classes/Properties/propImages/');


        $base64_code = $this->image;

       
     
            if ( !empty($base64_code) && !empty($path) ) :
        
                $string_pieces = explode( ";base64,", $base64_code);
                $image_name = 'img_';
                $image_name = 'img_'.substr(md5(mt_rand()), 0, 7);
            
                $image_type_pieces = explode( "image/", $string_pieces[0]);
         
                $image_type = $image_type_pieces[1];
         
                $store_at = $path.'/propImages/'.$image_name.'.'.$image_type;
         
                $decoded_string = base64_decode( $string_pieces[1] );
         
                file_put_contents( $store_at, $decoded_string );
         
            endif;

            return $store_at;
           
        
    }


    public function addProperty(){

        $image_path = $this-> saveImage();

        // return $image_path;

        $res = $this->createProperty($this->propName,$this->propType,$this->propDescription,$this->propContact,$this->propPrice,$this->propSize,$this->propLeaseType,$this->propMonthlyPay,$this->propStatus,$this->propUnits,$this->propAvailableUnits,$this->propBeds,$this->propBaths,$this->propSqrfoot,$image_path,$this->listType);



        return $res;
    }

    public function delProperty($id){

        $res = $this->delProperties($id);

        return $res;

    }

    
}