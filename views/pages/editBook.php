<?php
$link = isset($_GET['id']) ? 'index.php?action=editBook&id=' . $_GET['id'] : 'index.php?action=createBook';
?>
<form method="POST" action=<?= $link ?>>
    <label>
        Titre du livre :
        <input type="text" name="title" placeholder="Titre du livre">
    </label>
    <label>
        Description :
        <textarea name="description" placeholder="Description"></textarea>
    </label>
    <label>
        Url 
        <input type="text" name="url" placeholder="Image du livre">
    </label>
    <button type="submit">Ajouter</button>
</form>