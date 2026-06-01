<?php
define("ln", "<br>");
define("el", "\n");


// ==================================================
// تكليفات PHP Bootcamp من الدرس 20 إلى 29
// ==================================================


// ass 1
echo 10 * 20 + 15 % 3 + 190 + 10 - 400 . ln;

// ass 2 
$a = "10";
// first method
echo (+$a) . ln;
echo gettype(+$a) . ln;

// second method
echo (int) $a . ln;
echo gettype((int) $a) . ln;

// third method
echo -(-$a) . ln;
echo gettype(-(-$a)) . ln;


// ass 3
$a = 10;
$b = 20;
echo (10 - 20) / 10 . ln;


// ass 4
$a = 10;
$b = 20;
$c = 15;

var_dump($a != $b); // True
var_dump($c >= $a); // True
var_dump($a <= $b); // True
var_dump($a < $b); // True
var_dump($a < $c); // True
var_dump($a <= $c); // True
var_dump(gettype($a) == gettype($b)); // True
var_dump(gettype($a) == gettype($b)); // True
var_dump(gettype((float) $a) != gettype($b)); // True
echo ln;


// ass 5
$points = 10;
$points += 3; //13
echo $points . ln;
$points -= 5;
echo $points . ln;

echo ln;

// ass 6
$a = "Elzero";
$b = "Web";
$c = "School";

// Method One
$d = "$a $b $c";
echo $d; // Elzero Web School
echo ln;
// Method Two
$d = "{$a} {$b} {$c}";
echo $d; // Elzero Web School
echo ln;

// Method Three
$d = $a . $b . $c;
echo $d; // Elzero Web School
echo ln;

// Method Four
$d = "";
$d .= $a;
$d .= $b;
$d .= $c;
echo $d; // Elzero Web School
echo ln;


// ass 7
$a = 10;
$b = 20;
echo $a + $b * $a + $b + $a * $a * $a; // 10000
echo ln;


// ass 8
// Code 1
if (!isset($k)) {
    echo "Custom error" . ln;
} else {
    $g = $k;
}

// Code 2
$f = @file("Not_A_File");

// Code 3
if (!file_exists($f)) {
    echo "custom error";
} else {
    include("Not_A_File");
}
echo ln;

// ==================================================
// تكليفات PHP Bootcamp من الدرس 30 إلى 36=======
// ==================================================

// ass 1
$a = 100;
$b = 200;
$c = 100;

if ($b > $a && $a === $c && $b === ($a + $c)) {
    echo "YES" . ln;
} else {
    echo "No" . ln;
}


// ass 2
// Test Case 1
$a = 100;
$b = 200;
$c = 300;
if ($a > $b)
    echo "A Is Larger Than B" . ln;

// Test Case 2
$a = 200;
$b = 100;
$c = 300;
if ($a > $c)
    echo "A Is Larger Than C" . ln;

// Test Case 3
$a = 200;
$b = 200;
$c = 100;
if ($a > $b || $a > $c)
    echo "A Is Not Larger Than B Or C" . ln;


// ass 3 
$name = "";
$admins = ["Osama", "Ahmed", "Sayed"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get name
    $name = $_POST['user'];
    echo "The Request Method Is Post And Username Is" . $name . ln;

    $found = false;
    $admin = "";
    // check is found or not
    for ($i = 0; $i < 3; $i++) {
        if ($admins[$i] == $name) {
            $found = true;
            $admin = $admins[$i];
            break;
        }
    }

    // print result of check
    if ($found) {
        echo "This Username Osama Is " . $admin . ln;
    } else {
        echo "This Username Osama Is " . $name . " Is Not Admin " . ln;
    }
}
?>
<form action="" method="POST">
    <input type="text" name="user">
    <input type="submit" value="Send">
</form>


<?php
//ass 4
$a = 30;
$b = 20;
$c = 10;

echo ($a + $b === $c) ? "A + B = C <br>" : (
    ($a + $c === $b) ? "A + C = B <br>" :
    (($b + $c === $a) ? "B + C = A <br>" : "The End <br>"));


// ass 5
$name = "Osama";
$age = 40;
$country = "Egypt";
echo ($age > 18) ? "The Age Is Good To Go<br>" .
    ((gettype($name) === "string") ?
        "The Name Is Good To Go<br>" .
        (($country === "Egypt") ?
            "The Country Is Good To Go<br>" : "")
        : "") :
    "";

// ass 6
$genre = "Hack And Slash";
switch ($genre) {
    case "RPG":
        echo "I Recommend Ys Games";
        break;
    case "Hack And Slash":
        echo "I Recommend Castlevania Games";
        break;
    case "FPS":
        echo "I Recommend Uncharted Games";
        break;
    case "Platform":
        echo "I Recommend Megaman Games";
        break;
    case "Puzzle":
        echo "I Recommend Megaman Games";
        break;
    default:
        echo "I Recommend Shadow Of Mordor And Shadow Of War";
}
echo ln;


// ass 7
$num_one = 23;
$num_two = 5;
$op = "+";

switch ($op) {
    case "+":
        echo $num_one + $num_two;
        break;
    case "-":
        echo $num_one - $num_two;
        break;
    case '/':
        echo $num_one / $num_two;
        break;
    case "*":
        echo $num_one * $num_two;
        break;
    default:
        echo "Unknown Operation";
}
echo ln;

// ass 8
$day = "Sat";
if ($day == "Sat" || $dat == "Sun" || $day == "Mon") {
    echo "We Are Open All The Day";
} else if ($day == "Tue" || $day == "Wed") {
    echo "We Are Open From 08:12";
} else if ($day == "Thu" || $day == "Fri") {
    echo "We Are Closed";
} else {
    echo "Unknown Day";
}

echo ln;

// ==================================================
// تكليفات PHP Bootcamp من الدرس 37 إلى 42      
// ==================================================

// ass 1
$index = 10;
while ($index > 0) {
    echo $index-- . ln;
}
echo ln;

// ass 2
$index = 0;
while ($index <= 20) {
    if ($index % 2 == 0 && $index != 0) {
        echo $index . ln;
    }
    $index++;
}


// ass 3 
$num = 2;
$sum = 1;
while ($num < 520) {
    echo $sum . ln;
    $sum = $sum * 2 + 2;
    $num *= 2;
}
echo ln;


// ass 4
$start = 10;
$end = 0;
$stop = 3;

for ($i = $start; $i >= $end; $i--) {
    if ($i >= 10) {
        echo $i . ln;
    } else if ($i < 10 && $i >= 3) {
        echo '0' . $i . ln;
    }
}


// ass 5
$start = 0;
$mix = [1, 2, 3, "A", "B", "C", 4];
for ($i = $start + 1; $i < 7; $i++) {
    if (is_numeric($mix[$i])) {
        echo $mix[$i] . ln;
    }
}

// ass 6
$money = ["Ahmed" => 100, "Sayed" => 150, "Osama" => 100, "Maher" => 250];
foreach ($money as $key => $value) {
    echo "The Name Is {$key} And I Need {$value} Pound From Him" . ln;
}

// ass 7 
$cnt_num = 0;
$mix = [1, 2, "A", "B", "C", 3, 4];
foreach ($mix as $key => $value) {
    if (is_numeric($value)) {
        $cnt_num++;
        echo $mix[$key] . ln;
    }
}
$mod = count($mix) - $cnt_num;
echo "{$cnt_num} Preinted" . ln;
echo "{$mod} Letters Ignored" . ln;

// ass 8
$nums = [1, 13, 12, 20, 51, 17, 30];
foreach ($nums as $key => $value) {
    if ($value % 2 == 0) {
        echo $value / 2 . ln;
    }
}

// ass 9 
$help_num = 3;
$nums = [4, 5, 6, 1, 2, 3];
$names = ["Ahmed", "Sayed", "Osama", "Mahmoud", "Gamal"];

foreach ($names as $key => $value) {
    if ($value == "Sayed" || $value == "Osama") {
        echo $value . ln;
    }
}
echo ln;
// ass 10
$help_num = 4;
$nums = [2, 4, 5, 6, 10];
foreach ($nums as $key => $value) {
    $res = $nums[$help_num - $key];
    echo "$value + $res  = " . ($value + $res) . ln;
}
echo ln;


// ==================================================
// تكليفات PHP Bootcamp من الدرس 43 إلى  52     
// ==================================================

// ass 1
function greeting($name, $gender = "Male")
{
    if (func_num_args() == 1) {
        echo "Hello " . $name . ln;
        return;
    }
    if ($gender == "Male") {
        echo "Hello MR " . $name . ln;
    } else {
        echo "Hello Miss " . $name . ln;
    }
}
echo greeting("Osama", "Male"); // Hello Mr Osama
echo greeting("Eman", "Female"); // Hello Miss Eman
echo greeting("Sameh"); // Hello Sameh
echo ln;
// ass 2
function get_arguments(...$num)
{
    foreach ($num as $key => $value) {
        echo $value . " ";
    }
    echo ln;
}
echo get_arguments("Hello", "Elzero", "Web", "School"); // Hello Elzero Web School
echo get_arguments("I", "Love", "PHP"); // I Love PHP

// ass 3
function sum_all(...$nums)
{
    $sum = 0;
    foreach ($nums as $key => $value) {
        if ($value === 5) {
            continue;
        } elseif ($value === 10) {
            $value = 20;
        }
        $sum += $value;
    }
    return $sum;
}
echo sum_all(10, 12, 5, 6, 6, 10); // 64
echo ln;
echo sum_all(5, 10, 5, 10); // 40
echo ln;
echo ln;

// ass 4
function multiply(...$nums)
{
    $res = 1;
    foreach ($nums as $key => $value) {
        if (is_numeric($value)) {
            $value = (int) ($value);
            $res *= $value;
        }
    }
    return $res;
}
echo multiply(10, 20); // 200
echo ln;
echo multiply("A", 10, 30); // 300
echo ln;
echo multiply(100.5, 10, "B"); // 1000
echo ln;
echo ln;

// ass 5
function check_status($a, $b, $c)
{

    $age = 0;
    $nam = "";
    $bb = false;

    foreach ([$a, $b, $c] as $v) {
        if (is_numeric($v)) {
            $age = $v;
        } else if (is_string($v)) {
            $nam = $v;
        } elseif (is_bool($v)) {
            $bb = $v;
        }
    }

    $check = ($bb) ? "Available For Hire" : "Not Available For Hire";
    return "Hello $nam, Your Age Is $age,You Are $check" . ln;
}

echo ln;
echo check_status("Osama", 38, true); // "Hello Osama, Your Age Is 38, You Are Available For Hire"
echo ln;
echo check_status(38, "Osama", true); // "Hello Osama, Your Age Is 38, You Are Available For Hire"
echo ln;
echo check_status(true, 38, "Osama"); // "Hello Osama, Your Age Is 38, You Are Available For Hire"
echo ln;
echo check_status(false, "Osama", 38); // "Hello Osama, Your Age Is 38, You Are Not Available For Hire"
echo ln;
echo ln;


// ass 6
function calculate($a, $b, $c = "a")
{
    $op = $c[0];
    $res = 0;
    switch ($op) {
        case 'a':
            $res = $a + $b;
            break;
        case 's':
            $res = $a - $b;
            break;
        case 'm':
            $res = $a * $b;
            break;
        case 'd':
            $res = $a / $b;
            break;
    }
    return $res;
}
echo ln;
echo calculate(10, 20); // 30
echo ln;
echo calculate(10, 20, "a"); // 30
echo ln;
echo calculate(10, 20, "s"); // -10
echo ln;
echo calculate(10, 20, "subtract"); // -10
echo ln;
echo calculate(10, 20, "multiply"); // 200
echo ln;
echo calculate(10, 20, "m"); // 200
echo ln;


// ass 7 
function calculatee(int $num_one, int $num_two)
{
    return $num_one + $num_two;
}

echo calculatee(20, 10); // 30
echo ln;
echo gettype((double) calculatee(20, 10)); // Double
echo ln;


// ass 8
$message = "Hello";

${$message} = function ($name) use ($message) {
    return "$message $name";
};

echo $Hello("Osama"); // Hello Osama
echo ln;


// ass 9
$greet = function ($name) {
    return "Greetings";
};
echo $greet("osama");
echo ln;
?>