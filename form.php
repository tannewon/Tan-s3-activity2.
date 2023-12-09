<?php

function validate_message($message)
{
    // Function to check if the message is valid (must be at least 10 characters (after removing spaces)
    $trimmed_message = trim($message);
    if (strlen($trimmed_message) < 10) {
        return false;
    }
    return true;
}

function validate_username($username)
{
    // Function to check if the username is valid (contains only letters and numbers => Use function 'ctype_alnum()')
    return ctype_alnum($username);

}

function validate_email($email)
{
    // Function to check if email is valid (must contain '@' character)
    if (strpos($email, '@') === false) {
        return false;
    }
    return true;
}

$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";
$username = "";
$email = "";
$message = "";

$form_valid = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $message = strip_tags($_POST['message']);
    $terms = isset($_POST['terms']);

    if (empty($username)) {
        $user_error = "Please enter a username";
    } elseif (!validate_username($username)) {
        $user_error = "Username should contain only letters and numbers";
    }

    if (empty($email)) {
        $email_error = "Please enter an email";
    } elseif (!validate_email($email)) {
        $email_error = "Email must contain '@'";
    }

    if (empty($message)) {
        $message_error = "Message must be at least 10 characters long";
    } elseif (!validate_message($message)) {
        $message_error = "Message must be at least 10 characters long";
    }

    if (!$terms) {
        $terms_error = "You must accept the Terms of Service";
    }

    if (empty($user_error) && empty($email_error) && empty($message_error) && empty($terms_error)) {
        $form_valid = true;
    }
}

?>

<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
        <input type="text" class="form-control" placeholder="Enter Name" name="username" value="<?php echo htmlspecialchars($username); ?>">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"><?php echo htmlspecialchars($message); ?></textarea>
        <small class="form-text text-danger"> <?php echo $message_error; ?></small>
    </div>
    <div class="mb-3">
        <input type="checkbox" class="form-check-input" name="terms" id="terms" value="terms" <?php if ($terms) echo 'checked'; ?>> <label class="form-check-label" for="terms">I accept the Terms of Service</label>
        <small class="form-text text-danger"> <?php echo $terms_error; ?></small>
    </div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<hr>

<?php
if ($form_valid) :
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo htmlspecialchars($username); ?></p>
            <p><?php echo htmlspecialchars($email); ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo htmlspecialchars($message); ?></p>
        </div>
    </div>
<?php
endif;
?>