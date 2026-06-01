<?php
// ============================================
// تكليفات PHP Bootcamp من الدرس 53 إلى 62
// =============================================

// ass 1
$num_one = -1;
$num_two = 2.5;
$let_one = "o";
$let_two = "z";
$str = "El%er0";
echo str_replace(["%", 0], [$let_two, $let_one], $str);
echo "<br>";

// ass 2
$str = "Orezle";
$str = strrev(strtolower($str));
echo ucfirst($str);
echo "<br>";


// ass  3
$str = 'aAa';
$num = 3;
$char = "_";
$str = strtolower($str);
$str .= $char;
echo str_repeat($str, $num);
echo "<br>";

// ass 4
$str = "<div><b>Elzero</b></div>";
echo str_replace(["<div>", "</div>"], "", $str);
echo "<br>";

// ass 5
$str = "Elzero Web School";
$e = "e";
$o = "O";
$four = 4;

echo substr_count($str, $e, $four);
echo "<br>";
echo substr_count($str, " "); //2
echo "<br>";

// ass 6
$chars = ["E", "l", "z", "e", "r", "o"];
echo implode($chars);
echo "<br>";

// ass 7
$chars = ["E", 1, 2, "l", "z", "E", "R", "o"];
$str = strtolower(implode($chars));
$str = str_replace("12", "", $str);
echo ucfirst($str);
echo "<br>";




// ============================================
// تكليفات PHP Bootcamp من الدرس 63 إلى 72
// =============================================


// ass 1
$friends = [
    "AG" => "Ahmed Gamal",
    "OM" => "Osama Mohamed",
    "MG" => "Mahmoud Gamal",
    "AS" => "Ahmed Samy",
    "FA" => "Farid Ahmed",
    "SM" => "Sayed Mohamed"
];
$friends = array_chunk(array_change_key_case($friends, CASE_LOWER), 2, true);
echo "<pre>";
print_r($friends);
echo "</pre>";
echo "<br>";

// ass 2
$codes = ["H", "C", "J"];
$means = ["HTML", "CSS", "JavaScript"];
echo "<pre>";
print_r(array_combine($codes, $means));
echo "</pre>";
echo "<br>";

// ass 3
$friends = [
    "Ahmed Gamal" => "AG",
    "Osama Mohamed" => "OM",
    "Mahmoud Gamal" => "MG",
    "Ahmed Samy" => "AS"
];
$friends = (array_flip(array_reverse($friends)));
echo "<pre>";
print_r(array_change_key_case($friends, CASE_LOWER));
echo "</pre>";
echo "<br>";

// ass 4
$nums = [10, 20, 30];
echo array_sum($nums) . "<br>";
echo (array_reduce($nums, function ($a, $b) {
    return $a + $b;
}));
echo "<br>";

// ass 5
$nums = [5, 10, 20, 5, 30, 40];
$num = array_filter($nums, function ($a) {
    return $a != 5;
});
echo (array_reduce($num, function ($a, $b) {
    return $a + $b;
}));
echo "<br>";

// ass 6
$chars = ["A", "B", "C", "D", "E"];
$char = "@@";
$zero = 0;
echo "<pre>";
print_r(array_merge($chars, array_fill($zero, count($chars), $char[$zero])));
echo "</pre>";
echo "<br>";


// ass 7
$names = ["Osama", "Ahmed", "Sayed", "Mahmoud", "Ali"];
next($names);
next($names);
echo current($names) . "<br>";
end($names);
echo current($names) . "<br>";
reset($names);
echo current($names) . "<br>";
end($names);
prev($names);
echo current($names) . "<br>";


// ass 8
$chars = ["A", "B", "C"];
// first
// $chars[count($chars)] = "D";
// echo "<pre>";
// print_r($chars);
// echo "</pre>";

// second
// $chars[4] = "D";
// echo "<pre>";
// print_r($chars);
// echo "</pre>";

// third
// $chars[end($chars)] = "D";
// echo "<pre>";
// print_r($chars);
// echo "</pre>";

// four
// array_push($chars, "D");
// echo "<pre>";
// print_r($chars);
// echo "</pre>";
echo "<br>";

// ass 9
$nums = [1, 2, 3, 4, 5, 6];
echo "<pre>";
print_r(array_slice($nums, 1, 3));
echo "</pre>";
echo "<br>";

// ass 10
$mix = [1, 2, 3, "A", "B", "C", 7, 8, 9];
$nums = [4, 5, 6];
echo "<pre>";
$mix = array_merge(array_filter($mix, "is_numeric"), $nums);
print_r($mix);
echo "</pre>";
echo "<br>";

// ass 11
$arr = ["A", "B", "C", "D", "E"];
$cnt = 0;
foreach ($arr as $k => $v) {
    $cnt++;
}
echo $cnt;
echo "<br>";

// ass 12
$nums = [11, 2, 10, 7, 20, 50];
$cnt = 0;
foreach ($nums as $k => $v) {
    $cnt += $v;
}
echo $cnt;
echo "<br>";

// ass 13
$nums = [10, 100, -20, 50, 30];
$max = $nums[-1];
foreach ($nums as $v) {
    if ($max < $v) {
        $max = $v;
    }
}
echo $max;
echo "<br>";

// ass 14
$nums = [10, 100, -20, 50, 30];
$min = $nums[0];
foreach ($nums as $v) {
    if ($v < $min) {
        $min = $v;
    }
}
echo $min;
echo "<br>";

// ass 15
$chars = ["o", "r", "e", "z", "l", "E"];
echo implode(array_reverse($chars));
echo "<br>";

// ass 16
$mix = ["A", "C", "B", 1, 100, 3, 2, 6, 5, 7];
$res = array_filter($mix, "is_numeric");
$all = [];


foreach ($res as $num) {
    if ($num % 2 == 1) {
        $all[] = $num;
    }
}
sort($all);
echo "<pre>";
print_r($all);
echo "</pre>";
echo "<br>";

// ass 17
$nums = [1, 2, 3, 4, 5, 6];
foreach ($nums as $num) {
    $r = rand(0, count($nums) - 1);
    $temp = $nums[$num];
    $nums[$num] = $nums[$r];
    $nums[$r] = $temp;
}
echo "<pre>";
print_r($nums);
echo "</pre>";
echo "<br>";

// ass 18
$title = "E&z\$r0 W\$b Sch00&";

$title = str_replace("&", "l", $title);
$title = str_replace("0", "o", $title);
$title = str_replace("\$", "e", $title);
echo $title;
echo "<br>";



// ============================================
// تكليفات PHP Bootcamp من الدرس 73 إلى 81
// =============================================


// ass 1
echo rand(10, 20);
echo "<br>";

// ass 2
$friends = ["Osama", "Ahmed", "Sayed", "Ibrahim"];
echo $friends[rand(0, count($friends) - 1)];
echo "<br>";

// ass 3
$num1 = 11.5; // 11
$num2 = 9.4898; // 9.5
$num3 = -7.5; // -7
echo round($num1, 0, mode: PHP_ROUND_HALF_DOWN) . "<br>";
echo round($num2, 1) . "<br>";
echo round($num3, 0, PHP_ROUND_HALF_DOWN) . "<br>";


// ass 4
$arr = filter_list();
$temp = [];
foreach ($arr as $i) {
    $id = filter_id($i);
    $temp[$id] = $i;
}
echo "<pre>";
print_r($temp);
echo "</pre>";
echo "<br>";


// ass 5
$url1 = "http://www.elz ero.org";
$url2 = "http://¥elzero.org";
$url3 = "https://elzero.org";
$url4 = "https://elzero.o¥rg";
echo (filter_var($url1, FILTER_VALIDATE_URL)) ? " A Valid URL <br>" : "Not A Valid URL <br>";
echo (filter_var($url2, FILTER_VALIDATE_URL)) ? " A Valid URL <br>" : "Not A Valid URL <br>";
echo (filter_var($url3, FILTER_VALIDATE_URL)) ? " A Valid URL <br>" : "Not A Valid URL <br>";
echo (filter_var($url4, FILTER_VALIDATE_URL)) ? " A Valid URL <br>" : "Not A Valid URL <br>";

echo "<br>";


// ass 6
$url1 = "http://www.elz ero.org";
$url2 = "http://¥elzero.org";
$url3 = "https://elzero.org";
$url4 = "https://elzero.o¥rg";
echo (filter_var($url1, FILTER_SANITIZE_URL)) . "<br>";
echo (filter_var($url2, FILTER_SANITIZE_URL)) . "<br>";
echo (filter_var($url3, FILTER_SANITIZE_URL)) . "<br>";
echo (filter_var($url4, FILTER_SANITIZE_URL));
echo "<br>";

// ============================================
// تكليفات PHP Bootcamp من الدرس 82 إلى 91
// =============================================

// ass 1
echo round(disk_total_space("/") / 1024 / 1024 / 1024 / 1024, 2) . " TR<br>";
echo "<br>";


// ass 2
$size = filesize("/media/atwaa/F868AE7F68AE3BEE/practicecss/VideoEdting/#13 Logical Operators in c++.wmv");
$mb = round($size / 1024 / 1024, 2);
$kb = round($size / 1024, 2);
echo "Size In Megabyte Is $mb MB<br>";
echo "Size In Kilobyte Is $kb KB<br>";



//ass 3
$parent = "Programming";
$child = "Programming/PHP";
if (!is_dir($parent)) {
    mkdir($parent, 0711, true);
}
if (!is_dir($child)) {
    mkdir($child, 0711, true);
}

if (is_dir($child)) {
    rmdir($child);
    echo "Directory Programming/PHP Removed. <br>";
}
if (is_dir($parent)) {
    rmdir($parent);
    echo "Directory Programming/PHP Removed. <br>";
}

// ass 4

echo "<br>";



// ============================================
//تكليفات PHP Bootcamp من الدرس 92 إلى 97    
// =============================================



// ass 1
date_default_timezone_set("Asia/Riyadh");
echo date_default_timezone_get() . "<br>";
$date = new DateTime("now");
echo date_format($date, "D, d M y - h:i:s a ") . "<br>";
echo date_format($date, "l, d F Y - h:i:s a ") . "<br>";
echo "<br>";

// ass 2
$date = "2005-10-02 15:15:15";
date_default_timezone_set("Africa/Cairo");
echo date_default_timezone_get() . "<br>";
$datee = date_create($date);
echo date_format($datee, "Y, F, l, H:i:s") . "<br>";
echo "<br>";


// ass 3
date_default_timezone_set("Africa/Cairo");
$date = "1990-10-01";
$date1 = date_create($date, timezone_open("Africa/Cairo"));
$date2 = date_create("now", timezone_open("Africa/Cairo"));
$diff = $date2->getTimestamp() - $date1->getTimestamp();
$res = round($diff / 60 / 60 / 24, 1, PHP_ROUND_HALF_UP);
$year = floor($diff / 60 / 60 / 24 / 30 / 12);
echo "From Epoch Time Till $date Is Approximately  {$res} day<br>";
echo "From Epoch Time Till $date Is Approximately  {$year} Years<br>";
echo "<br>";



// ass 4
date_default_timezone_set("Africa/Cairo");
$date = "1990-10-01";
$date1 = date_create($date, timezone_open("Africa/Cairo"));
$date2 = date_create("now", timezone_open("Africa/Cairo"));
$diff = date_diff($date1, $date2);
$res = $diff->days;
$year = $diff->y;
echo "From Epoch Time Till $date Is Approximately  {$res} day<br>";
echo "From Epoch Time Till $date Is Approximately  {$year} Years<br>";
echo "<br>";

// ass 5
echo time() . "<br>";
$second = date_create("now", timezone_open("Africa/Cairo"));
echo "<pre>";
print_r(getdate()[0]);
echo "</pre>";
$third = date_create("now", timezone_open("Africa/Cairo"));
echo $third->getTimestamp() . "<br>";
echo "<br>";



// ============================================
//تكليفات PHP Bootcamp من الدرس 98 إلى 105  
// =============================================


// ass 1
$cookie1 = "color";
$cookie2 = "layout";
$cookie3 = "font";
setcookie($cookie1, "red", time() + (86400 * 65), "/");
setcookie($cookie2, "boxed", time() + (86400 * 65), "/");
setcookie($cookie3, "swat", time() + (86400 * 65), "/");
echo "<br>";


// ass 2
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";
echo "<br>";
echo "Your Color Is $cookie1 And Your Font Is $cookie3 <br>";
echo "<br>";

// ass 3
setcookie($cookie2, "", time() + (0 * 0), "/");
echo "<br>";

// ass 4
setcookie($cookie1, "red", 0, "/");
setcookie($cookie3, "swat", 0, "/");
echo "<br>";
?>