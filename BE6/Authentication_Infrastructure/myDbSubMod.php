<?php
    ini_set("display_errors", "On");
    ERROR_REPORTING(E_ALL);
    session_start();

    require_once './inc/DbH.inc.php';
    require_once './inc/DbP.inc.php';
    require_once './inc/Authentication.inc.php';
    $db = DbH::getDbH();

    require_once './inc/Sellable.inc.php';
    require_once './inc/Television.inc.php';

    if (!Authentication::isAuthenticated()) {  // am I logged on?
            header("Location: ./index.php"); // if not, go away!
        }

    $inch = $_POST['tvs'];
    $tvno = $_POST['tvno'];

    $sql = "select inch, stocklevel";
    $sql .= " from tvs";
    $sql .= " where inch = :inch";
    try {
        $q = $db->prepare($sql);
        $q->bindValue(':inch', $inch);
        $q->execute();
        $row = $q->fetch();
        $tv = new Television($row['inch'], $row['stocklevel']);
    } catch(PDOException $e) {
        printf("<p>%s</p>\n", $e->getMessage());
    }
    $tv->sellItems($tvno);

    $sql = 'update tvs';
    $sql .= ' set stocklevel = :stocklevel';
    $sql .= ' where inch = :inch';
    try {
      $q = $db->prepare($sql);
      $q->bindValue(':stocklevel', $tv->getStockLevel());
      $q->bindValue(':inch', $tv->getScreenSize());
      $q->execute();
    } catch(PDOException $e) {
      die("Posting failed. Call a friend.<br/>".$e->getMessage());
    }
    header('Location: ./index.php?code=0');
