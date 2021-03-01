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

        function getNote($note)
        {
            $sql = "SELECT * FROM notes WHERE id_note = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1, $note->getId_note());
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }

        function getNoteByUser($note)
        {
            $sql = "SELECT * FROM notes WHERE id_user = ? AND id_note = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1, $note->getId_user());
            $stm->bindValue(2, $note->getId_note());
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }

        function getNotesByUser($user)
        {
            $sql = "SELECT * FROM notes WHERE id_user = ?";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->bindValue(1, $user->getId_user());
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

        function getLastNote()
        {
            $sql = "SELECT * FROM notes ORDER BY id_note DESC LIMIT 1";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            $stm->execute();
            $ret = $stm->fetch(PDO::FETCH_OBJ);
            return $ret;
        }

        function alterNote($note)
        {
            //Complemento
                $up = "";
                if($note->getTitle() != NULL)
                {
                    $up .= "title = :title, ";
                }
                if($note->getDescription() != NULL)
                {
                    $up .= "description = :description, ";
                }
                if($note->getColor() != NULL)
                {
                    $up .= "color = :color, ";
                }
                if($note->getComplete() != NULL)
                {
                    $up .= "complete = :complete, ";
                }
                if($note->getDeadline() != NULL)
                {
                    $up .= "deadline = :deadline, ";
                }
                if($up === '')
                {
                    throw new \Exceptionm("Erro, parte da SQL de update malformada",500);
                }
                else
                {
                    $up = substr($up,0,-2);//Retira a virgula e o espaço (, ) do complemento
                }
            //Complemento
            $sql = "UPDATE notes SET {$up} WHERE id_note = :id_note AND id_user = :id_user";
            parent::getConnection();
            $stm = parent::$connec->prepare($sql);
            //Bind de complemento
                if($note->getTitle() != NULL)
                {
                    $stm->bindValue(':title', $note->getTitle());
                }
                if($note->getDescription() != NULL)
                {
                    $stm->bindValue(':description', $note->getDescription());
                }
                if($note->getColor() != NULL)
                {
                    $stm->bindValue(':color', $note->getColor());
                }
                if($note->getComplete() != NULL)
                {
                    $stm->bindValue(':complete', $note->getComplete());
                }
                if($note->getDeadline() != NULL)
                {
                    $stm->bindValue(':deadline', $note->getDeadline());
                }
            //Bind de complemento
            $stm->bindValue(':id_note', $note->getId_note());
            $stm->bindValue(':id_user', $note->getId_user());
            $ret = $stm->execute();
            return $ret;
        }
    }
?>