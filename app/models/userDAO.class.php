<?php
    namespace App\Models;
    use PDO;
    class UserDAO extends Connection
    {
        function createUser($user)
        {
            $sql = "INSERT INTO user (name,user,password,tries,active) VALUES (?,?,?,?,?)";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$user->getName());
            $stm->bindValue(2,$user->getUser());
            $stm->bindValue(3,$user->getPassword());
            $stm->bindValue(4,$user->getTries());
            $stm->bindValue(5,$user->getActive());
            $ret = $stm->execute();
            return $ret;
        }

        function getLastUser()
        {
            $sql = "SELECT * FROM user ORDER BY id_user DESC LIMIT 1";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }

        function testUser($user)
        {
            $sql = "SELECT user FROM user WHERE user = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$user->getUser());
            $stm->execute();
            $ret = $stm->fetchAll(PDO::FETCH_OBJ);
            return $ret;
        }

        function login($user)
        {
            $sql = "SELECT * FROM user WHERE user = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$user->getUser());
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }

        function addAttenpt($user)
        {
            $sql = "UPDATE user SET tries = (tries + 1) WHERE id_user = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1, $user->getUser());
            $ret = $stm->execute();
            return $ret;
        }

        function resetAttenpts($user)
        {
            $sql = "UPDATE user SET tries = 0 WHERE id_user = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1, $user->getUser());
            $ret = $stm->execute();
            return $ret;
        }
    }
?>