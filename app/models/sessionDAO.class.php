<?php
    namespace App\Models;
    use PDO;
    class SessionDAO extends Connection
    {
        function createSession($session)
        {
            $sql = "INSERT INTO session (access_token,access_token_expiry,refresh_token,refresh_token_expiry,id_user) VALUES (?,?,?,?,?)";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$session->getAccess_token());
            $stm->bindValue(2,$session->getAccess_token_expiry());
            $stm->bindValue(3,$session->getRefresh_token());
            $stm->bindValue(4,$session->getRefresh_token_expiry());
            $stm->bindValue(5,$session->getId_user());
            $ret = $stm->execute();
            return $ret;
        }

        function getLastSession()
        {
            $sql = "SELECT * FROM session ORDER BY id_user DESC LIMIT 1";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }
    }
?>