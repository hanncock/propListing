<?php
require_once(__DIR__ .'/../Db.php');

class Listing extends Db {
    protected $dbstmt;
    protected $per_page = 10;
    protected $page_count;
    protected $start;
    protected $page_number;


    public function __construct() 
    {
        parent::__construct();
    }

    # get property count
    public function getCount($arg, $city, $location, $beds, $price) 
    {
        $typeVal = htmlspecialchars($arg);

        $clause = "WHERE featured = 1";

        if(!empty($arg)) 
        {
            $query_paramd = htmlspecialchars($arg);
            $clause .= " AND `type` = '$query_paramd'";
        }

        if(!empty($city))
        {
            $query_param = htmlspecialchars($city);
            $clause .= " AND county LIKE '%$query_param%'";
        }

        if(!empty($location))
        {
            $query_param1 = htmlspecialchars($location);
            $clause .= " AND address LIKE '%$query_param1%'";
        }

        if(!empty($beds))
        {
            $query_param2 = htmlspecialchars($beds);
            $clause .= " AND beds = $query_param2";
        }

        if(!empty($price))
        {
            $query_param3 = htmlspecialchars($price);
            $clause .= " AND price <= $query_param3";
        }

        $query = "SELECT * FROM `properties` $clause";
        $this->dbstmt = $this->dbhandler->prepare($query);

        $this->dbstmt->execute();
        $results = $this->dbstmt->fetchAll(PDO::FETCH_ASSOC);
        $count = count($results);

        if($count) 
        {
            return $response = array(
                'status' => true,
                'countVal' => $count
            );
        }
        else 
        {
            return $response = array(
                'status' => false,
                'countVal' => $count
            );
        }
    }


    public function getAll($keyword, $type, $min_price, $max_price, $page, $status, $featured)
    {
        try {
            # get all properties
            if($page !== null) {
                $this->page_number = filter_var($page, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
                // echo ;
                if(!is_numeric($this->page_number)) {
                    die($this->page_number."Invalid page number");
                }
            }
            else
            {
                $this->page_number = 1;
            }

            $this->start = ($this->page_number - 1) * $this->per_page;

            // $limitVal = htmlspecialchars($limit);
            // $startVal = htmlspecialchars($start);

            $clause = "WHERE name != ''";

            if($keyword) 
            {
                $query_keyword = htmlspecialchars(strip_tags($keyword));
                $clause .= "  AND `name` LIKE '%$query_keyword%'  OR `type` LIKE '%$query_keyword%' OR `town` LIKE '%$query_keyword%' OR `street` LIKE '%$query_keyword%' OR `county` LIKE '%$query_keyword%'";
            }

            if($type)
            {
                $query_type = htmlspecialchars(strip_tags($type));
                $clause .= " AND `type` = '$query_type'";
            }

            if($status)
            {
                $query_status = htmlspecialchars(strip_tags($status));
                $clause .= " AND `status` = '$query_status'";
            }

            if($featured)
            {
                $query_featured = htmlspecialchars(strip_tags($featured));
                $clause .= " AND `featured` = '$query_featured'";
            }

            if($min_price)
            {
                $query_minprice = filter_var($min_price, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
                if(!is_numeric($query_minprice)) {
                    die("Invalid min price");
                }
                $clause .= " AND `rent_amount` >= $query_minprice";
            }

            if($max_price)
            {
                $query_maxprice = filter_var($max_price, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
                if(!is_numeric($query_maxprice)) {
                    die("Invalid max price");
                }
                $clause .= " AND `rent_amount` <= $query_maxprice";
            }
            $query = " SELECT properties.*,
                        (SELECT GROUP_CONCAT(`property_files`.`src`) FROM `property_files` WHERE `property_files`.`prop_id` = `properties`.`id` GROUP BY (`properties`.`id`)) as images
                        FROM `properties` $clause ORDER BY `inserted_at` DESC LIMIT $this->start, $this->per_page
                    ";
            // $query = "SELECT * FROM 
            //     (SELECT * FROM `properties` $clause ORDER BY `inserted_at` DESC LIMIT $this->start, $this->per_page) p
            //     LEFT JOIN (SELECT `src`, `prop_id` FROM `property_files` GROUP BY `prop_id`) pf ON p.id = pf.prop_id";
            $this->dbstmt = $this->dbhandler->prepare($query);

            $this->dbstmt->execute();
            $properties = $this->dbstmt->fetchAll(PDO::FETCH_ASSOC);

            $response = array(
                'status' => true,
                'records' => $properties,
                'count' => count($properties),
                'total_pages' => ceil(count($properties) / $this->per_page), // 'query' => $query
            );
            return $response;
        }
        catch (PDOException $e) {
            throw $e;
        }
    }


    public function getOneById(String $id) 
    {
        # get a single property given the id
        $query = "SELECT properties.*,
        (SELECT GROUP_CONCAT(`property_files`.`src`) FROM `property_files` WHERE `property_files`.`prop_id` = `properties`.`id` GROUP BY (`properties`.`id`)) as images
        FROM `properties` WHERE `id` =:id";
        $this->dbstmt = $this->dbhandler->prepare($query);
        // $this->dbstmt->bindParam(':typeVal', htmlspecialchars($type));
        $this->dbstmt->bindParam(':id', htmlspecialchars($id));

        $this->dbstmt->execute();
        $property = $this->dbstmt->fetch(PDO::FETCH_ASSOC);

        if(count($property)) 
        {
            $response = array(
                'status' => true,
                'records' => $property
            );
            return $response;
        }
        else {
            $response = array(
                'status' => false,
                'records' => 'No properties found!'
            );
            return $response;
        }
    }


    public function addListing($arr1, $paths):array 
    {   
        # try insert
        try
        {
            $featured;
            if(isset($arr1['featured']) && $arr1['featured'] == "0")
            {
                $featured = 0;
            }
            else
            {
                $featured = 1;
            }
            # begin a transaction
            $this->dbhandler->beginTransaction();
                # add a single property
                $query = "INSERT INTO `properties`(`name`, `type`, `town`, `street`, `county`, `bedcount`, `bathrooms`, `unit_count`, `rent_amount`, `featured`, `description`)
                    VALUES(:name, :type, :town, 
                    :street, :county, :bedcount, 
                    :bathrooms, :unit_count, :rent_amount, 
                    :featured, :description)
                ";

                $this->dbstmt = $this->dbhandler->prepare($query);

                $this->dbstmt->bindParam(':name', htmlspecialchars(strip_tags($arr1['name'])));
                $this->dbstmt->bindParam(':type', htmlspecialchars(strip_tags($arr1['type'])));
                $this->dbstmt->bindParam(':town', htmlspecialchars(strip_tags($arr1['town'])));
                $this->dbstmt->bindParam(':street', htmlspecialchars(strip_tags($arr1['street'])));
                $this->dbstmt->bindParam(':county', htmlspecialchars(strip_tags($arr1['county'])));//htmlspecialchars($path);//store path to uploaded images
                $this->dbstmt->bindParam(':bedcount', htmlspecialchars(strip_tags($arr1['bedcount'])));
                $this->dbstmt->bindParam(':bathrooms', htmlspecialchars(strip_tags($arr1['bathrooms'])));
                $this->dbstmt->bindParam(':unit_count', htmlspecialchars(strip_tags($arr1['unitcount'])));
                $this->dbstmt->bindParam(':rent_amount', htmlspecialchars(strip_tags($arr1['rent'])));
                $this->dbstmt->bindParam(':description', htmlspecialchars(strip_tags($arr1['description'])));
                $this->dbstmt->bindParam(':featured', htmlspecialchars(strip_tags($featured)));

                $this->dbstmt->execute();

                # property file data preparation and insert begins
                $last_id = $this->dbhandler->lastInsertId();

                $query_two = "INSERT INTO `property_files`(`prop_id`, `src`)
                    VALUES($last_id, :src)
                ";

                $this->dbstmt2 = $this->dbhandler->prepare($query_two);
                $this->dbstmt2->bindParam('src', $path);

                // execute recursively for all property images
                foreach($paths as $path) {
                    $this->dbstmt2->execute();
                }
            # now make changes on the table
            $this->dbhandler->commit();

            $response = array(
                'status' => true,
                'message' => $arr1['name'].' Property added successfully '
            );

            return $response;

        }
        catch(PDOException $e)
        {
            # rollback incase of an exception
            $this->dbhandler->rollback();
            throw $e;
        }// end of try-catc
    }
    

    public function updateOne(String $var)
    {
        # update property by uid
    }

    public function deleteOneById(String $arg)
    {
        # delete property by uid
        $id = htmlspecialchars(stripcslashes($arg));

        #check if propety exist
        $exists = $this->getOneById($id);

        if($exists['status']) 
        {
            $query = "DELETE FROM `properties` WHERE `id`=:id";
            $this->dbstmt = $this->dbhandler->prepare($query);
            $this->dbstmt->bindParam(':id', $id);

            if($this->dbstmt->execute()) 
            {
                return $response = array(
                    'status' => true,
                    'message' => "Property Deleted Successfully!"
                );
            }
            else 
            {
                return $response = array(
                    'status' => false,
                    'message' => "Server Error. Please try again later!"
                );
            }
        }
        else 
        {
            return $response = array(
                'status' => false,
                'message' => "Selected Property doesn't exit. Please check your internet connection and try again!"
            );
        }

    }

    public function markDeletedById(String $arg)
    {
        # delete property by uid
        $id = htmlspecialchars(stripcslashes($arg));

        #timestamp
        $current_timestamp = new DateTime('now', new DateTimeZone('Africa/Nairobi'));
        $localDateFormat = $current_timestamp->format("Y-m-d H:i:s");

        #check if propety exist
        $exists = $this->getOneById($id);

        if($exists['status']) 
        {
            $query = "UPDATE `properties` SET `status`='inactive', `updated_at`=:val WHERE `id`=:id";
            $this->dbstmt = $this->dbhandler->prepare($query);
            // $this->dbstmt->bindParam(':parm', 'NO');
            $this->dbstmt->bindParam(':val', $localDateFormat);
            $this->dbstmt->bindParam(':id', $id);

            if($this->dbstmt->execute()) 
            {
                return $response = array(
                    'status' => true,
                    'message' => "Property unpublished Successfully!"
                );
            }
            else 
            {
                return $response = array(
                    'status' => false,
                    'message' => "Server Error. Please try again later!"
                );
            }
        }
        else 
        {
            return $response = array(
                'status' => false,
                'message' => "Selected Property is already unpublished."
            );
        }

    }
}
?>