<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="background-color: #ffcc00;">
        <form action="<?= $_SERVER['PHP_SELF']?>" method="post" >
          <fieldset>
            <legend><b>Donnez votre avis sur PHP 8 ! </b></legend>
            <b>Nom : &nbsp;<input type="text" name="nom" width="60" /> <br>
            Mail : &nbsp;<input type="text" name="mail" width="60" /> <br>
            Vos commentaires sur le site</b><br>
            <textarea name="comment" rows="10" cols="50"></textarea> <br>
            <input type="submit" value="Envoyer " name="envoi" />
            <input type="submit" value="Afficher les avis" name="affiche" />
          </fieldset>
        </form>
        <?php
      $date= time();
      //ENREGISTREMENT
      if(isset($_POST['envoi'])) {
        if(isset($_POST['nom']) && isset($_POST['mail']) && isset($_POST['comment'])) {
          echo "<h2>",$_POST['nom']," merci de votre avis </h2> ";
          if(file_exists("livre2.txt") ) {
            if($id_file=fopen("livre2.txt","a")) {
              flock($id_file,2);
              fwrite($id_file,$_POST['nom'].":".$_POST['mail'].":".$date.":".$_POST['comment']."\n");
              flock($id_file,3);
              fclose($id_file);
            }
            else{ 
              echo "fichier inaccessible";
            }
          }
          else {
            $id_file=fopen("livre2.txt","w");
            fwrite($id_file,$$_POST['nom'].":".$$_POST['mail'].":".$date.":".$$_POST['comment']."\n");
            fclose($id_file);
          }
        }
      }
      //LECTURE DES DONNES
      if(isset($_POST['affiche'])) {
        if($id_file=fopen("livre2.txt","r")) {
          echo "<table border=\"2\"> <tbody>";
          $i=0;
          while($tab=fgetcsv($id_file,200,":") ) {
            $tab5[$i]=$tab;
            $i++;
          }
          $tab5=array_reverse($tab5);
          echo "<hr />";
          for($i=0;$i<5;$i++) {
            echo "<tr> <td>",$i+1 ,": de: ".$tab5[$i][0]." </td> <td> <ahref=\"mailto:".$tab5[$i][1]." \" > ".$tab5[$i][1]."</a></td><td>le: ",date("d/m/y H:i:s", $tab5[$i][2])," </td></tr>";
            echo "<tr > <td colspan=\" 3 \">", stripslashes($tab5[$i][3]),"</td> </tr> ";
          }
          fclose($id_file);
        }
        echo "</tbody></table> ";
      }
      else {
        echo "<h2>Donnez votre avis puis cliquez sur 'envoyer' !</h2> ";
      }
    ?>
</body>
</html>
