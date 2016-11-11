<?php
require_once "../afficher/afficher.php";
require_once "../php_sql_action.php";
$action = new DB_driver();
$categories = array("RI" => "Article dans des Revues Internationales",
    "CI" => "Article dans des Conférences Internationales",
    "RF" => "Article dans des Revues Françaises",
    "CF" => "Article dans des Conférences Françaises",
    "OS" => "Ouvrage Scientifique (Chapitre de Livre, ...)",
    "TD" => "Thèse de Doctorat",
    "BV" => "Brevet",
    "AP" => "Autre Production");
?>
<div class="row">  
    <?php
    foreach ($categories as $cle => $value) {
        ?>
        <div class="col-md-12 ">
            <table class='table  table-condensed table-bordered'>
                <tr style=' background-color: #D9E8F5;'>
                    <th colspan="2" style="text-align: left;"><h4><a href='../accueil/index.php?categorie=<?php echo $cle; ?>'> <?php echo $value; ?></a></h4></th>
                </tr>
                <tr>
                    <?php
                    $sql = 'select * from articles where categorie="' . $cle . '" and etat="Publié" order by id desc ;';
                    $nombre = $action->nombre_row($sql);
                    if ($nombre != 0) {
                        $resultat = $action->get_list($sql);
                        ?>
                        <td width="40%">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="../accueil/index.php?id_article=<?php echo $resultat[0]["id"] ?>"><img class="img-thumbnail img-responsive" src="../images/<?php echo $resultat[0]["photo"] ?>"/></a>
                                </div>
                                <div class="col-md-12">
                                    <a href="../accueil/index.php?id_article=<?php echo $resultat[0]["id"] ?>"><p class="attr2" style="text-align: justify;"><?php echo $resultat[0]["titre"] ?></p></a>
                                </div>
                                <div class="col-md-12">
                                    <p class="cont" style="text-align: justify;" ><?php echo substr($resultat[0]["resume"], 0, 200); ?>...</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <table  width="100%">
                                <?php
                                $i = 0;
                                foreach ($resultat as $ligne) {
                                    $i = $i + 1;
                                    if ($i == 1) {
                                        continue;
                                    };
                                    echo '<tr><td height="80px"><a href="../accueil/index.php?id_article=' . $ligne["id"] . '"><p class="liste" style="text-align: justify;">' . $ligne["titre"] . '</p></a></td></tr>';
                                    if ($i == 6) {
                                        break;
                                    }
                                }
                                ?>
                            </table>
                        </td>
                        <?php
                    }
                    ?>
                </tr>
            </table>
        </div>
        <?php
    }
    ?>
</div>
<div class="clearfix"></div>