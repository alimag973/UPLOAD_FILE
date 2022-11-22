
<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $data = array_map('trim', $_POST);
    $errors = [];

    if (empty($data['lastname'])) {
        $errors[] = 'Your lastname is required';
    }
    if (empty($data['firstname'])) {
        $errors[] = 'Your firstname is required';
    }
    if (empty($data['age'])) {
        $errors[] = 'Your age is required';
    }        

    if (isset($_FILES['avatar'])) {        
        $uploadDir = 'public/uploads/';
        $uploadFile = $uploadDir . uniqid() . "_" . basename($_FILES['avatar']['name']);
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $extension_ok = ['jpg', 'png', 'webp', 'gif'];
        $maxFileSize = 1000000;
        if ( (!in_array($extension, $extension_ok ))){
            $errors[] = 'Only Jpg, Png and Webp files extensions are accepted !';
        }
        if ($_FILES['avatar']['error'] !== 0)
        {
            $errors[] = "You should check your file !";
        }
        if ( !empty($_FILES['avatar']['tmp_name']) && file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize)
        {
            $errors[] = "Your file shouldn't exceed 1M !";
        }
    } else {
        $errors[] = 'You should send an image !';
    }
    if (!empty($errors)) {
        echo implode($errors);
    } else {
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        echo $_POST['firstname'] . PHP_EOL . $_POST['lastname'] . PHP_EOL . $_POST['age'] . PHP_EOL;
        if (isset($uploadFile)){
        echo '<img src="' . $uploadFile . '">';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driver License</title>
</head>
<body>
    <h1>DRIVER LICENSE</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="lastname">
            <label for="lastname">Lastname :</label>
            <input type="text" id="lastname" name="lastname" value="<?= $data['lastname'] ?? '' ?>" >
        </div>
        <div class="firstname">
            <label for="firstname">Firstname :</label>
            <input type="text" id="firstname" name="firstname" value="<?= $data['firstname'] ?? '' ?>" >
        </div>
        <div class="age">
            <label for="age">Age :</label>
            <input type="int" id="age" name="age" value="<?= $data['age'] ?? '' ?>" >
        </div>
        <div class="image">
            <label for="imageUpload">Upload your image</label>
            <input type="file" name="avatar" id="imageUpload" />
        </div>
        <div class="button">
            <button name="send">Send</button>
        </div>
    </form>
</body>
</html>