<header>
    <div class="container">
        <h1 class="logo">Creative Web Solutions</h1>
        <nav>
            <ul>
                <li><a href="index.php" class="<?= basename($_SERVER['PHP_SELF'])=='index.php'?'active':'' ?>">Home</a></li>
                <li><a href="about.php" class="<?= basename($_SERVER['PHP_SELF'])=='about.php'?'active':'' ?>">About</a></li>
                <li><a href="services.php" class="<?= basename($_SERVER['PHP_SELF'])=='services.php'?'active':'' ?>">Services</a></li>
                <li><a href="portfolio.php" class="<?= basename($_SERVER['PHP_SELF'])=='portfolio.php'?'active':'' ?>">Portfolio</a></li>
                <li><a href="contact.php" class="<?= basename($_SERVER['PHP_SELF'])=='contact.php'?'active':'' ?>">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>