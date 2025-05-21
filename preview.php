<?php
    
    include 'includes/session.php';
    include 'includes/slugify.php';

    $output = array('error'=>false,'list'=>'');

    $sql = "SELECT * FROM positions";
    $query = $conn->query($sql);

    while($row = $query->fetch_assoc()){
        $position = slugify($row['description']);
        $pos_id = $row['id'];
        if(isset($_POST[$position])){
            if($row['max_vote'] > 1){
                if(count($_POST[$position]) > $row['max_vote']){
                    $output['error'] = true;
                    $output['message'][] = '<li>Anda hanya dapat memilih '.$row['max_vote'].' kandidat untuk '.$row['description'].'</li>';
                }
                else{
                    foreach($_POST[$position] as $key => $values){
                        $sql = "SELECT * FROM candidates WHERE id = '$values'";
                        $cmquery = $conn->query($sql);
                        $cmrow = $cmquery->fetch_assoc();
                        $output['list'] .= "
                            <div class='votelist'>
                                <p><b>".$row['description']."</b></p>
                                <p>".$cmrow['fullname']."</p>
                            </div>
                        ";
                    }

                }
                
            }
            else{
                $candidate = $_POST[$position];
                $sql = "SELECT * FROM candidates WHERE id = '$candidate'";
                $csquery = $conn->query($sql);
                $csrow = $csquery->fetch_assoc();
                $output['list'] .= "
                    <div class='votelist'>
                        <p><b>".$row['description']."</b></p>
                        <p>".$csrow['fullname']."</p>
                    </div>
                ";
            }

        }
        
    }

    echo json_encode($output);

?>