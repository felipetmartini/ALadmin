<?php
require 'steamauth/steamauth.php';
if (!isset($_SESSION['authed'])) { header("Location: steamauth/logout.php?noadmin");die; }
echo $_POST['id'];
$json = json_decode(file_get_contents("todo.json"),true);
foreach ($json['todo'] as $key => $value) {
    echo $key."<br>".var_dump($value)."<br>";
    if (in_array("\"id\":".$id, $value)) {
        unset($json['todo'][$key]);
    }
}
$json['todo'] = json_encode($json['todo']);
echo "<table><tr><td>Title</td><td style='width: 20%;'>Author</td><td style='width: 20%;'></td></tr>";
foreach ($json['todo'] as $value) {
    echo "<tr><td>".$value['title']."</td><td style='width: 20%;'>".$value['author']."</td><td><a href='javascript:deleteTodo(\"".$value['id']."\");'><span class='icon ion-checkmark-round'></span></a></td></tr>";
}
echo "</table>";
?>