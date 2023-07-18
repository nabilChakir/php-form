<?php
function update_form($label_id, $is_displayed, $input_name)
{
    // Ouverture fichier formulaire.html en tant que document DOM
    $dom = new DOMDocument();
    $dom->loadHTMLFile("formulaire.html");
    $label = $dom->getElementById($label_id);
    ($is_displayed) ? $text = "true" : $text = "none"; 
    if ($label) {
        $label->setAttribute("style", "display: $text");
        // MAJ de la valeur de l'élément correspondant (uniquement pour les inputs de type text) permettant de maintenir  
        // la valeur du champ soumise précédemment en cas d'échec de la soumission du formulaire.
        $inputs = $dom->getElementsByTagName("input");
        foreach ($inputs as $input) {
            if ($input->getAttribute("name") === $input_name && $input_name != 'fileToUpload' && $input_name != 'recorded') {
                $input->setAttribute("value", $_POST[$input_name]);
                break;
            }
        }
    }
    $dom->saveHTMLFile("formulaire.html");
}
function clean_form()
{
    $dom = new DOMDocument();
    $dom->loadHTMLFile("formulaire.html");
    $inputs = $dom->getElementsByTagName("input");
    
    foreach ($inputs as $input) {
        if ($input->getAttribute("type") != "radio") {
            $input->setAttribute("value", "");
        }
    }
    $dom->saveHTMLFile("formulaire.html");
}
function chain_url($file, $values_array, $sanitized_filename) 
{
    $url = $file . "?";
    foreach ($values_array as $key => $value) {
        $url .= $key . "=" . $value . "&";
    }
    return $url . "fileToUpload=" . $sanitized_filename;   
}
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Importation des variables
    require 'variables.php';

    // SANITISATION
    $result = filter_input_array(INPUT_POST, $sanitization_options);

    // VALIDATION
    $errors_number = 0;
    foreach ($result as $key => $value) {
        $options = array(
            'options' => array(
                'regexp' => $regex[$key]
            )
        );
        $is_validated = filter_var($value, $validation_options[$key], $options);
        ($is_validated != false) ? $is_validated = true : $errors_number++;
        update_form("label_" . $key, !$is_validated, $key);
    }

    // Traitement à part du fichier chargé (sanitisation + validation)
    $target_dir = "uploads/";
    $sanitized_path;
    $temp_name;
    $sanitized_filename;
    
    if (isset($_FILES['fileToUpload'])) {
        // $sanitized_filename ne contient que le nom (sanitisé) du fichier, pas le chemin complet du fichier temporaire sur le serveur
        $sanitized_filename = filter_var($_FILES['fileToUpload']['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sanitized_path = $target_dir . $sanitized_filename;
        $temp_name = $_FILES['fileToUpload']['tmp_name']; // Emplacement temporaire du fichier (nom du fichier inclus) téléchargé sur le serveur
        $regex = '/^[^\.\\\\]+\.(jpeg|jpg|ico|png)$/i';

        if (!preg_match($regex, $sanitized_filename) || file_exists($sanitized_path)) {
            update_form("label_fileToUpload", true, "fileToUpload");
            $errors_number++;
        } else {
            update_form("label_fileToUpload", false, "fileToUpload");
        }
    } 

    // Redirections
    if ($errors_number == 0) {

        if (file_exists($sanitized_path)) {
            update_form("label_fileToUpload", true, "fileToUpload");
            goto flag;
        } else {
            move_uploaded_file($temp_name, $sanitized_path);
        }
        
        clean_form();
        $url = chain_url("thankyou.php", $result, $sanitized_filename); 
        header("Location: " . $url);
    } else {
        flag:
        header("Location: formulaire.html");
    }

}

?>