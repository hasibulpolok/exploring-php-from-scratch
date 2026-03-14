<?php include('header.php'); ?>

<main>
    <section class="contact">
        <h2>Contact Us</h2>
        <p>Have a project in mind? Send us a message.</p>
        <form action="#" method="post">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="btn">Send Message</button>
        </form>
    </section>
</main>

<?php include('footer.php'); ?>