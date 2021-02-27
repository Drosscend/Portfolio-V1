<?php
ini_set('display_error', true);

define('RECAPTCHA_SITE', '6Lfu_j4aAAAAANMdCPbAT3dw05HrG1b0akpyPFA0');
define('RECAPTCHA_SECRET', '6Lfu_j4aAAAAAJGGqCV9fMtygfMLcq0xTZRaIwGC');

$error = $success = null;
$fields = [];
if (isset($_POST['contact'])) {
    $fields = array_filter($_POST, function ($el) {
        return is_string($el);
    });

    if (empty($fields['g-recaptcha-response'])) {
        $error = 'Une erreur est survenue, merci de réessayer';
    } else {
        $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'secret' => RECAPTCHA_SECRET,
                'response' => (string)$fields['g-recaptcha-response'],
                'remoteip' => $_SERVER['REMOTE_ADDR']
            ]),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        if (!$data->success or $data->action !== "contact" or $data->score < 0.7) {
            $error = 'Une erreur est survenue, merci de réessayer.';
        } elseif (empty($fields['name'])
            or empty($fields['email'])
            or empty($fields['text'])) {
            $error = 'Merci de remplir tous les champs.';
        } elseif (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
            $error = 'Cet email ne semble pas être valide.';
        } else {
            $name = $_POST['name'];
            $visitor_email = $_POST['email'];
            $message = $_POST['text'];

            $email_from = 'kevin@kevin-dev.me';

            $email_subject = "Formulaire kevin-dev.me";

            $email_body = "Nouveau message reçu:\n" .
                "Nom du visiteur: $name\n" .
                "Email du visiteur: $visitor_email\n" .
                "Message du visiteur: $message\n";

            $to = "kevin.veronesipro@gmail.com";

            $headers = "From: $email_from \r\n";
            $headers .= "Reply-To: $visitor_email \r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            mail($to, $email_subject, $email_body, $headers);

            $fields = [];

            $success = 'Message envoyé !';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="author" content="Kévin Véronési"/>
    <meta name="theme-color" content="#FFD152"/>

    <!-- Metadata -->
    <title>Kévin Véronési</title>
    <meta name="description"
          content="Sur ce site vous pouvez retrouver des informations à propos de moi comme mon CV, mes différents projets, mes passions et un espace pour me contacter."/>
    <meta name="keywords" content="Kévin Véronési, kevin-dev, kevin veronesi CV , kevin veronesi portfolio"/>
    <link rel="canonical" href="https://kevin-dev.me"/>
    <meta name="twitter:title" content="Kévin Véronési"/>
    <meta property="og:title" content="Kévin Véronési"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://kevin-dev.me"/>
    <meta property="og:description"
          content="Sur ce site vous pouvez retrouver des informations à propos de moi comme mon CV, mes différents projets, mes passions et un espace pour me contacter."/>
    <meta property="og:image" content="/data/img/logo.jpg"/>
    <meta property="og:site_name" content="Kevin-dev"/>

    <!-- Favicon && Apple Icons -->
    <link rel="icon" type="image/png" href="/data/img/logo.jpg"/>
    <link rel="apple-touch-icon" href="/data/img/logo.jpg" type="image/png"/>

    <!-- css -->
    <link rel="stylesheet" href="/data/css/normalize.css"/>
    <link rel="stylesheet" href="/data/css/base.css"/>
    <link rel="stylesheet" href="/data/css/style.css"/>
    <link rel="stylesheet" href="/data/css/reponsive.css"/>

</head>

<body>
<header>
    <nav class="topnav" id="Topnav">
        <a href="#home" onclick="navbar()" title="Accueil">Accueil</a>
        <a href="#about" onclick="navbar()" title="About">A propos de moi</a>
        <a href="#portfolio" onclick="navbar()" title="Portfolio">Portfolio</a>
        <a href="#compétences" onclick="navbar()" title="Compétence">Compétences</a>
        <a href="#contact" onclick="navbar()" title="Contact">Contact</a>
        <a href="javascript:void(0);" onclick="navbar()" class="btn-mobile" title="Navigation">
            <i class="fas fa-bars"></i>    
        </a>
    </nav>
</header>

<!-- home -->
<div id="home" class="section-Accueil">
    <div class="container">
        <h1>Kévin Véronési</h1>
        <h2>Bienvenue sur mon site</h2>
        <p>
            Sur ce site vous pouvez retrouver des informations à propos
            de moi comme mon CV, mes différents projets, mes passions et
            un espace pour me contacter.
        </p>
        <p class="down"><a href="#about" class="link">En savoir plus ...</a></p>
    </div>
</div>

<!-- À propos de moi -->
<div id="about" class="section">
    <div class="container">
        <div>
            <h1>À propos de moi</h1>
        </div>
        <div class="about-section">
            <div>
                <p>
                    Je m'appelle Kévin Véronési, j'ai 18 ans et je suis actuellement en 1re année de DUT informatique.
                    <br>
                    J'ai découvert il y a quelques années le développement web avec l'HTML5 le CSS3 et le JavaScript,
                    cela a été une véritable passion de voir mon projet s'afficher au fur et à mesure que les lignes de
                    codes s'ajoutent,
                    n'hésitez pas à me <a href="#contact" class="link">contacter</a> pour plus de renseignements :D
                </p>
                <p>
                    Mes loisirs sont le cinéma, la musique, les jeux vidéo indépendants, les sorties entre amis, et bien
                    sûr l'informatique.
                </p>
                <p>
                    J'ai pour but de travailler dans la programmation de site internet ou d'applications et
                    pourquoi pas travailler dans une startup plus tard.
                </p>
                <a class="button cvpdf" href="/data/Véronési_Kévin_CV.pdf" target="_blank" title="CV">Mon cv en PDF</a>
            </div>
            <div>
                <img src="/data/img/logo.jpg" alt="Une photo de moi">
            </div>

        </div>
    </div>
</div>

<!-- portfolio -->
<div id="portfolio" class="section">
    <div class="container">
        <div>
            <h1>Quelques projets :</h1>
        </div>
        <div>
            <p>
                Tous mes projets sont disponibles sur github :
                <a class="link" href="https://github.com/Drosscend" target="_blank" title="Github">ici</a>
            </p>
        </div>
        <div class="portfolio-content">
            <div>
                <h4>Violet</h4>
                <p>
                    Violet (ヴァイオレット) est un bot Discord
                    catégorisé dans l'économie
                </p>
                <a class="link" href="https://github.com/Drosscend/Violet" target="_blank" title="Violet Bot">Violet
                </a>
            </div>
            <div>
                <h4>Yui</h4>
                <p>
                    Un bot pour vous aider dans la gestion de votre serveur.
                </p>
                <a class="link" href="https://github.com/Drosscend/Yui" target="_blank" title="Yui">Yui</a>
            </div>
            <div>
                <h4>Platform-Game</h4>
                <p>
                    Un jeu de Plateforme créé grâce a l'outil Construct. (Aucun des graphismes n'ai fait par moi mais
                    par
                    <a class="link" href="https://kenney.nl/assets/abstract-platformer" target="_blank">kenney</a>
                    )
                </p>
                <a class="link" href="https://github.com/Drosscend/Platform-Game" target="_blank"
                   title="Jeu de platfome">Code Source
                </a>
                <br>
                <a class="link" href="/Projets/PlatformGames_Construct/index.html" target="_blank"
                   title="Jeu de platfome">Jeux Platform-Game
                </a>
            </div>
            <div>
                <h4>Tuto-bot-JS</h4>
                <p>
                    Un petit et simple tutoriel pour faire un bot
                    Discord en JavaScript.
                </p>
                <a class="link" href="https://github.com/Drosscend/Tuto-bot-JS" target="_blank"
                   title="Tuto Bot">Tuto-bot-JS
                </a>
            </div>
            <div>
                <h4>Détection-Visage</h4>
                <p>
                    Détection de visage à partir de vidéo ou d'image en
                    Python.
                </p>
                <a class="link" href="https://github.com/Drosscend/Detection-Visage" target="_blank"
                   title="Détection de visage">Détection-Visage
                </a>
            </div>
            <div>
                <h4>Générateur de mot de passe</h4>
                <p>
                    Site internet simple pour générer des mots de passe forts aléatoirement.
                </p>
                <a class="link" href="/Projets/Random_Password_Generator/index.html" target="_blank"
                   title="Random paswword generator">Générateur de mots de passe
                </a>
            </div>
            <div>
                <h4>Création et gestion d'un serveur discord</h4>
                <p>
                    Lieu de discussions entre différents formateurs et étudiants.
                </p>
            </div>
            <div>
                <h4>Serveur Discord</h4>
                <p>
                    Un des responsables du discord du DUT informatique de Blagnac (500 membres).
                </p>
            </div>
            <div>
                <h4>Publication</h4>
                <p>
                    Administration et publication d’articles sur un site associatif.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Compétences -->
<div id="compétences" class="section">

    <div class="container">

        <div>
            <h1>Mes compétences :</h1>
        </div>

        <div class="Compétence-sec">

            <div class="card">
                <div class="logo">
                    <i class="fab fa-html5"></i>
                </div>

                <div class="text">
                    <h2>HTML</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fab fa-css3"></i>
                </div>

                <div class="text">
                    <h2>CSS</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fas fa-database"></i>
                </div>

                <div class="text">
                    <h2>SQL</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fab fa-java"></i>
                </div>

                <div class="text">
                    <h2>JAVA</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fab fa-js-square"></i>
                </div>

                <div class="text">
                    <h2>JS</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fas fa-terminal"></i>
                </div>

                <div class="text">
                    <h2>BASH & BAT</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fas fa-file-word"></i>
                </div>

                <div class="text">
                    <h2>Bureautique</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fas fa-broadcast-tower"></i>
                </div>

                <div class="text">
                    <h2>Communication</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fas fa-hammer"></i>
                </div>

                <div class="text">
                    <h2>Maintenance</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fas fa-school"></i>
                </div>

                <div class="text">
                    <h2>Autodidacte</h2>
                </div>
            </div>

            <div class="card">
                <div class="logo">
                    <i class="fas fa-book-open"></i>
                </div>

                <div class="text">
                    <h2>Curieux</h2>
                </div>
            </div>
        </div>

        <p>
            Voici un lien pour voir ma personnalité sur le site 16personalities : <a
                    href="https://www.16personalities.com/fr/la-personnalite-isfj" class="link" target="_blank">Défenseur</a>
            :D
        </p>

    </div>
</div>

<!-- contact -->
<div id="contact" class="section">
    <div class="container">
        <h2>Vous pouvez me contacter ici :</h2>

        <div class="contact-section">
            <div class="contact-left">
                <a class="button" href="https://www.linkedin.com/in/kévin-véronési-29a9721b7" target="_blank"
                   title="Linkedin">
                    <i class="fab fa-linkedin"></i> <span> Linkedin</span>
                </a>
                <a class="button" href="https://github.com/Drosscend" target="_blank" title="Github">
                    <i class="fab fa-github"></i> <span> Github</span>
                </a>
                <a class="button" href="mailto:kevin.veronesipro@gmail.com" target="_blank" title="Mail">
                    <i class="fas fa-envelope"></i> <span> Mail</span>
                </a>
            </div>

            <div class="contact-right">
                <?php if ($success): ?>
                    <p class="success"><?= $success ?></p>
                <?php elseif ($error): ?>
                    <p class="error"><?= $error ?></p>
                <?php endif; ?>

                <form id="contact-form" method="POST">
                    <input name="name" type="text" class="feedback-input" placeholder="Votre nom" required
                           value="<?= $fields['name'] ?? null ?>"/>
                    <input name="email" type="text" class="feedback-input" placeholder="Votre email" required
                           value="<?= $fields['email'] ?? null ?>"/>
                    <textarea name="text" class="feedback-input" placeholder="Votre commentaire"
                              required><?= $fields['text'] ?? null ?></textarea>
                    <input type="hidden" name="contact">
                    <button type="submit" class="g-recaptcha" id="contact-button"
                            data-sitekey="<?= RECAPTCHA_SITE ?>"
                            data-callback="sendContact"
                            data-action="contact">Envoyer
                    </button>
                </form>
            </div>
        </div>


    </div>
</div>

<!-- footer -->
<footer>
        <span>Créé par
            <a href="mailto:kevin.veronesipro@gmail.com" target="_blank" title="Mail">Kévin Véronési - </a>
            <a href="/Pages_supp/Mentions_légales" title="Mail">Mentions légales</a>
        </span>
</footer>

<!-- cookies -->
<div class="cookies" style="display: none">
    <p>En continuant a naviguer sur ce site, vous acceptez l'utilisation de cookies.</p>
    <a class="button">Fermer</a>
</div>


<!-- jquery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- recaptcha -->
<script src="https://www.google.com/recaptcha/api.js"></script>
<!-- Icons -->
<script src="https://kit.fontawesome.com/f0dc2b6ac4.js" crossorigin="anonymous"></script>
<!-- animate.js -->
<script src="/data/js/anime.min.js"></script>
<!-- Captcha & navbar -->
<script src="/data/js/script.js"></script>

</body>

</html>