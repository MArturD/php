<?php
function redirect($path)
{
    header("Location: $path");
}

function connection()
{
    $pdo = new PDO("mysql:host=localhost;dbname=qwert", "root", "");
    return $pdo;
}

function get_user(){
//    $pdo = connection();
//    $sql = "SELECT * FROM login_table";
//    $statement = $pdo->prepare($sql);
//    $statement->execute();
//    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $pdo = new PDO("mysql:host=localhost;dbname=qwert", "root", "");
    $statement = $pdo->query("SELECT * FROM `login_table`");
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_authentication()
{
    if (is_logged_in()) {
        return $_SESSION['user'];
    }
    return false;
}

function creat_user($email, $password)
{
    $pdo = connection();
    $sql = "SELECT * FROM login_table WHERE email=:email";
    $statement = $pdo->prepare($sql);
    $statement->execute(["email" => $email]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if (!empty($user)) {
        $_SESSION["danger"] = "Этот эл. адрес уже занят другим пользователем.";
        redirect("page_register.php");
        exit;
    }
    $sql = "INSERT INTO  login_table (email,password) VALUES (:email,:password)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        "email" => $email,
        "password" => $password,
    ]);

    $_SESSION["success"] = "Регистрация успешна";
    redirect("page_login.php");
    exit;
}

function login($email, $password)
{
    $pdo = connection();
    $sql = "SELECT * FROM login_table WHERE email=:email AND password=:password";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        "email" => $email,
        "password" => $password,
    ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($email != $user["email"] || $password != $user["password"]) {

        $_SESSION["error"] = "Не верный логин или пароль";
        redirect("page_login.php");
//        header("Location: page_login.php");
    } else {
        redirect("page_profile.php");
//        header("Location: page_profile.php");
    }
    $_SESSION['user'] = $user;
}

function is_logged_in(){
    if (empty($_SESSION['user'])) {
        header("Location: page_login.php");
        exit;
    }
    return $_SESSION['user'];
}

function is_admin(){
    if (is_logged_in()){
        if ( get_user_authentication()['role'] === 'admin'){
            return true;
        }
        return false;
    }
}
function is_equal($user,$this_user){
    if ($user['id']=== $this_user['id']){
        return true;
    }
    return false;
}