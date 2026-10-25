
<!DOCTYPE html>
<html>
<head>
    <title>Posted Data</title>
</head>
<body>

    <h3>Posted data:</h3>

    <?php

    //foreach ($_POST as $key => $value)
    //    echo "($key) => ($value)<br/>";



    //2. Ubah file “processData.php” agar menambahkan file “validate.inc” dan melakukan validasi surname:

    //require 'validate.inc';

    //if (validateName($_POST, 'surname'))
        echo 'Data OK!';
    //else
    //    echo 'Data invalid!';



    //5. Ubah file “processData.php” agar dapat menampilkan detil pesan error:

    //require 'validate.inc';

    //$errors = array();

    //validateName($errors, $_POST, 'surname');

    //if ($errors)
    //{
    //    echo 'Errors:<br/>';

    //    foreach ($errors as $field => $error)
    //        echo "$field $error<br/>";
    //}
    //else
    //{
    //    echo 'Data OK!';
    //}



    $errors = array();

    if (isset($_POST['surname'])) {
        require 'validate.inc';
        validateName($errors, $_POST, 'surname');

        if ($errors) {
            echo '<h1>Invalid, correct the following errors:</h1>';

            foreach ($errors as $field => $error) {
                echo "$field $error<br>";
            }

            // Tampilkan kembali form jika ada error
            include 'form.inc';
        } else {
            echo 'Form submitted successfully with no errors';
        }
    } else {
        // Tampilkan form kosong jika belum disubmit
        include 'form.inc';
    }


    ?>

</body>
</html>
