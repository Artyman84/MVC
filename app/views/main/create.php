<?php
use core\Session;

$session = Session::inst();
$errors = $session->getVar('errors', []);
$data = $session->getVar('data', []);

?>

<h1>Create task</h1>
<form role="form" method="post" action="/main/create">
    <div class="form-group <?php echo empty($errors['name']) ? '' : 'has-error'?>">
        <label for="inputName">Name *</label>
        <input type="text" name="task[name]" class="form-control" id="inputName" value="<?php echo isset($data['name']) ? htmlspecialchars($data['name']) : ''?>" placeholder="Enter name">
        <span class="text-danger"><?php echo empty($errors['name']) ? '' : $errors['name']?></span>
    </div>
    <div class="form-group <?php echo empty($errors['email']) ? '' : 'has-error'?>">
        <label for="inputEmail">Email *</label>
        <input type="email" name="task[email]" class="form-control" id="inputEmail" value="<?php echo isset($data['email']) ? htmlspecialchars($data['email']) : ''?>" placeholder="Enter email">
        <span class="text-danger"><?php echo empty($errors['email']) ? '' : $errors['email']?></span>
    </div>
    <div class="form-group <?php echo empty($errors['text']) ? '' : 'has-error'?>">
        <label for="textareaText">Text *</label>
        <textarea class="form-control" name="task[text]" id="textareaText" rows="5" placeholder="Enter text"><?php echo isset($data['text']) ? nl2br(htmlspecialchars($data['text'])) : ''?></textarea>
        <span class="text-danger"><?php echo empty($errors['text']) ? '' : $errors['text']?></span>
    </div>
    <button type="submit" class="btn btn-default">Save</button>
</form>

<?php
$session->unsetVar('errors');
$session->unsetVar('data');
?>
