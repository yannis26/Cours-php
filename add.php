<?php
require_once 'includes/header.php';
require_once 'includes/User.php';
require_once 'includes/UserManager.php';

$message = '';
$name = '';
$firstname = '';
$username = '';
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $firstname = trim($_POST['firstname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password']; // ne pas trim() un mot de passe, juste récupérer

    if (!empty($name) && !empty($firstname) && !empty($username) && !empty($email) && !empty($password)) {
        try {
            $userManager = new UserManager();
            $newUser = new User(null, $name, $firstname, $username, $email);
            $newUser->setPassword($password); // hash automatique
            $userId = $userManager->create($newUser);

            header("Location: index.php?message=Utilisateur ajouté avec succès");
            exit();
        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    } else {
        $message = "Veuillez remplir tous les champs";
    }
}
?>

<h2>Ajouter un Utilisateur</h2>

<?php if ($message): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" required>
    </div>

    <div class="form-group">
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>" required>
    </div>

    <div class="form-group">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($username) ?>" required>
    </div>

    <div class="form-group">
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
    </div>

    <div class="form-group">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="form-group">
        <input type="submit" value="Ajouter">
    </div>
</form>

<?php require_once 'includes/footer.php'; ?>