<?php
use core\Session;

$session = Session::inst();
$errors = $session->getVar('errors', []);

?>

<h1>Edit task</h1>
<form role="form" method="post" action="/main/edit?id=<?php echo $id?>">
    <div class="form-group">
        <label for="inputName">Name</label>
        <div class="display-block"><?php echo htmlspecialchars($name); ?></div>
    </div>
    <div class="form-group">
        <label for="inputEmail" style="display: block">Email</label>
        <div class="display-block"><?php echo htmlspecialchars($email); ?></div>
    </div>
    <div class="form-group <?php echo empty($errors['text']) ? '' : 'has-error'?>">
        <label for="textareaText">Text *</label>
        <textarea class="form-control" name="task[text]" id="textareaText" rows="5" placeholder="Enter text"><?php echo htmlspecialchars($text)?></textarea>
        <span class="text-danger"><?php echo empty($errors['text']) ? '' : $errors['text']?></span>
    </div>
    <div class="checkbox">
        <label>
            <input type="hidden" name="task[status]" value="0">
            <input type="checkbox" name="task[status]" value="1" <?php echo $status ? 'checked="checked"' : ''?>> Completed
        </label>
    </div>
    <button type="submit" class="btn btn-default">Save</button>
</form>

<?php
$session->unsetVar('errors');
?>
