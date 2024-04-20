<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- google font pridi -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pridi:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/font-pridi.css">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet" />
    <!-- Grid -->
    <link rel="stylesheet" href="./public/css/grid.css">
    <!-- My css -->
    <link rel="stylesheet" href="./public/css/style.css">
    <title><?= $title ?></title>
</head>

<body id="body">
    <!-- header first navigation-->
    <header id="header" class="header d-flex justify-content-center"><?= $navbar ?></header>
    <!-- article -->
    <article id="mainArticle">
        <!-- second navigation / subnavbar -->
        <div id="subNavbar"><?= $subNavbar ?></div>
        <!-- title-site -->
        <h1 class="title-site pridi-semibold">CinéBdd</h1>
        <!-- title article -->
        <h2 class="title-article pridi-semibold"><?= $second_title ?></h2>

        <div class="container">
            
            <div class="row">
                <!-- content request -->
                <?= $content ?>
            </div>
        </div>

    </article>
    <!-- sidenav lateral -->
    <nav id="sideNav" class="hidden-sideNav"><?= $sideNav ?></nav>
    <!-- navAdmin -->
    <div id="siteAds"> <?= $navAdmin ?></div>
    <footer id="pageFooter"><?= $footer ?></footer>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <!-- bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <!-- MDB -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.umd.min.js"></script>
    <!-- My script -->
    <script src="./public/js/script.js"></script>
</body>

</html>