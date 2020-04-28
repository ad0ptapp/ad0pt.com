<?php
require_once("../inc/db.php");
$state_info = array(
"AL"=>true,
"AK"=>true,
"AZ"=>true,
"AR"=>true,
"CA"=>true,
"CO"=>true,
"CT"=>true,
"DE"=>true,
"DC"=>true,
"FL"=>true,
"GA"=>true,
"HI"=>true,
"ID"=>true,
"IL"=>true,
"IN"=>true,
"IA"=>true,
"KS"=>true,
"KY"=>true,
"LA"=>true,
"ME"=>true,
"MD"=>true,
"MA"=>true,
"MI"=>true,
"MN"=>true,
"MS"=>true,
"MO"=>true,
"MT"=>true,
"NE"=>true,
"NV"=>true,
"NH"=>true,
"NJ"=>true,
"NM"=>true,
"NY"=>true,
"NC"=>true,
"ND"=>true,
"OH"=>true,
"OK"=>true,
"OR"=>true,
"PA"=>true,
"RI"=>true,
"SC"=>true,
"SD"=>true,
"TN"=>true,
"TX"=>true,
"UT"=>true,
"VT"=>true,
"VA"=>true,
"WA"=>true,
"WV"=>true,
"WI"=>true,
"WY"=>true,
);

class Profile
{
    private $user_id = 0;
    private $full_name = "";
    private $state = "";
    private $city  = "";
    private $post_code = "";
    private $country = "";
    private $phone_number = "";
    public  $errno = -1;

    /**
     * @param string $full_name
     * @return bool
     */
    public function setFullName(string $full_name): bool
    {
        if($full_name == "")
            return false;
        $this->full_name = $full_name;
        return true;
    }

    /**
     * @param string $state
     * @return bool
     */
    public function setState(string $state): bool
    {
        if($state == "" || !$this->validateState($state))
            return false;
        $this->state = $state;
        return true;
    }

    /**
     * @param string $city
     * @return bool
     */
    public function setCity(string $city): bool
    {
        if($city == "")
            return false;
        $this->city = $city;
        return true;
    }

    /**
     * @param string $post_code
     * @return bool
     */
    public function setPostCode(string $post_code): bool
    {
        if($post_code == "")
            return false;
        $this->post_code = $post_code;
        return true;
    }

    /**
     * @param string $country
     * @return bool
     */
    public function setCountry(string $country): bool
    {
        if($country == "")
            return false;
        $this->country = $country;
        return true;
    }

    /**
     * @param string $phone_number
     * @return bool
     */
    public function setPhoneNumber(string $phone_number): bool
    {
        if($phone_number == "")
            return false;
        $this->phone_number = $phone_number;
        return true;
    }

    /**
     * Loads profile with user_id from database
     * @param int $user_id
     */
    public function __construct(int $user_id)
    {
        if($user_id != -1) {
            global $db;
            $this->user_id = $user_id;
            if ($stmt = $db->prepare('SELECT `full_name`, `country`, `state`, `city`, `postcode`, `phone_number` FROM `user_info` WHERE `user_id`=?')) {
                $stmt->bind_param("i", $user_id);
                $stmt->bind_result(
                    $this->full_name,
                    $this->country,
                    $this->state,
                    $this->city,
                    $this->post_code,
                    $this->phone_number
                );
                if ($stmt->execute()) {
                    $stmt->fetch();
                } else {
                    $this->errno = $stmt->errno;
                }
                $stmt->close();
            } else {
                $this->errno = $db->errno;
            }
            if ($this->errno != -1) {
                error_log("Error loading profile from database for $user_id: $this->errno", 3, "PHP_errors.log");
            }
        }
    }

    public function __toString()
    {
        return json_encode(array("full_name"=>$this->full_name, "state"=>$this->state, "city"=>$this->city, "post_code",$this->post_code, "country"=>$this->country, "phone_number"=>$this->phone_number));
    }

    public function is_valid(): bool {
        return is_numeric($this->user_id) && is_string($this->country) && is_string($this->full_name) && is_string($this->state) && is_string($this->city) && is_string($this->post_code) && is_string($this->phone_number)
            && $this->country != "" && $this->full_name != "" && $this->state != "" && $this->city != "" && $this->post_code != "" && $this->phone_number != "" && $this->validateState($this->getState());
    }

    public function save(): bool {
        global $db;
        if(!$this->is_valid()) {
            $this->errno = -1;
            return false;
        }
        if($stmt = $db->prepare('INSERT INTO `user_info` (`user_id`, `full_name`, `country`, `state`, `city`, `postcode`, `phone_number`) VALUES (?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE `full_name`=VALUES(`full_name`),`country`=VALUES(`country`),`state`=VALUES(`state`),`city`=VALUES(`city`),`postcode`=VALUES(`postcode`),`phone_number`=VALUES(`phone_number`)')) {
            $stmt->bind_param("issssss", $this->user_id, $this->full_name, $this->country, $this->state, $this->city, $this->post_code, $this->phone_number);
            if($stmt->execute()) {
                return true;
            } else {
                $this->errno = $stmt->errno;
            }
        } else {
            $this->errno = $db->errno;
        }
        return false;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id != null ? $this->user_id : -1;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->full_name != null ? $this->full_name : "";
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state != null ? $this->state : "";
    }

    public function validateState(string $state): bool
    {
        global $state_info;
        return isset($state_info[$state]);
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city != null ? $this->city : "";
    }

    /**
     * @return string
     */
    public function getPostCode(): string
    {
        return $this->post_code != null ? $this->post_code : "";
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country != null ? $this->post_code : "";
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phone_number != null ? $this->phone_number : "";
    }

    /**
     * @return int
     */
    public function getErrno(): int
    {
        return $this->errno;
    }
}