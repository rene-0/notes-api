<?php
    namespace App\Models;
    use PDO;
    class NoteDAO extends Connection
    {
        function getNotes()
        {
            $sql = "SELECT * FROM notes";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->execute();
            $ret = $stm->fetchAll(PDO::FETCH_OBJ);
            return $ret;
        }

        function createNote($note)
        {
            $sql = "INSERT INTO notes (title,description, deadline, color, creation, modification, complete, id_user) VALUES (?,?,?,?,?,?,?,?)";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1,$note->getTitle());
            $stm->bindValue(2,$note->getDescription());
            $stm->bindValue(3,$note->getDeadline());
            $stm->bindValue(4,$note->getColor());
            $stm->bindValue(5,$note->getCreation());
            $stm->bindValue(6,$note->getModification());
            $stm->bindValue(7,$note->getComplete());
            $stm->bindValue(8,$note->getId_user());
            $ret = $stm->execute();
            return $ret;
        }
    }
?>