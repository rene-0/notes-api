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

        function refreshToken($session)
        {
            $sql = "UPDATE session SET access_token = ?, access_token_expiry = ?, refresh_token = ?, refresh_token_expiry = ? WHERE id_user = ? AND id_session = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$session->getAccess_token());
            $stm->bindValue(2,$session->getAccess_token_expiry());
            $stm->bindValue(3,$session->getRefresh_token());
            $stm->bindValue(4,$session->getRefresh_token_expiry());
            $stm->bindValue(5,$session->getId_user());
            $stm->bindValue(6,$session->getId_session());
            $ret = $stm->execute();
            return $ret;
        }

        function checkSession($session)
        {
            $sql = "SELECT * FROM user u INNER JOIN session s ON(u.id_user = s.id_user) WHERE s.access_token = ? AND s.refresh_token = ? AND s.id_session = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$session->getAccess_token());
            $stm->bindValue(2,$session->getRefresh_token());
            $stm->bindValue(3,$session->getId_session());
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }

        function getSession($session)
        {
            $sql = "SELECT * FROM session WHERE id_session = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$session->getId_session());
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }
    }
?>