<?php
require __DIR__.'/../vendor/autoload.php';
use AmsApp\GlobalConstants;
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= GlobalConstants::SITE_TITLE; ?> helps roommates manage shared expenses seamlessly. Track your spending with ease!">
    <meta name="keywords" content="expense management, shared expenses, roommates, financial tracking">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../assets/style/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    <title><?= GlobalConstants::SITE_TITLE; ?></title>
    <style>
        .feature-card {
            height: 100%; /* Ensures all cards take the full height */
            display: flex;
            width: 100%;
            flex-direction: column; /* Arrange content vertically */
            justify-content: space-between; /* Distribute content evenly */
            height: 100%; /* Ensures all cards take the full height */
            padding: 20px; /* Adds consistent padding for better aesthetics */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow for visual consistency */
            border: 1px solid #ddd; /* Optional: Border for emphasis */
            border-radius: 8px; /* Optional: Rounded corners */
            background-color: #fff; /* Background color for clarity */

            /*background-color: #fff;*/
            /*border-radius: 10px;*/
            /*padding: 20px;*/
            /*box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);*/
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: scale(1.05);
        }

        .feature-title {
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Ensure cards are responsive and symmetric */
        @media (max-width: 768px) {
            .feature-card {
                padding: 15px;
                /* Reduce padding on smaller screens */
            }
        }

        @media (max-width: 576px) {
            .feature-card {
                padding: 10px;
                /* Further reduce padding on extra small screens */
            }
        }


        #quote {
            transition: font-size 0.3s ease, margin-top 0.3s ease, opacity 0.3s ease;
            font-weight: bold;
            font-size: large;

        }

        .faq-item {
            margin-bottom: 15px;
            /* Space between FAQs */
            border-bottom: 1px solid #e0e0e0;
            /* Light border for separation */
            padding: 10px 0;
            /* Padding around each FAQ */
        }

        .faq-question {
            cursor: pointer;
            /* Pointer on hover */
            display: flex;
            /* Flexbox for icon alignment */
            align-items: center;
            /* Center align items */
        }

        .icon {
            font-size: 1.5rem;
            /* Icon size */
            color: #007bff;
            /* Primary color */
            margin-right: 10px;
            /* Space between icon and text */
        }

        .collapse {
            padding: 10px 0;
            /* Padding for the answer text */
            color: #555;
            /* Text color for answers */
            font-size: 0.95rem;
            /* Slightly smaller font size */
        }

        /* footer */
        footer {
            background-color: #f8f9fa;
            /* Light background color */
            padding: 20px 0;
            /* Padding for top and bottom */
        }

        footer .list-inline-item {
            margin-right: 15px;
            /* Space between items */
        }

        footer .list-inline-item a {
            text-decoration: none;
            /* Remove underline */
            color: #007bff;
            /* Bootstrap primary color */
            transition: color 0.3s;
            /* Smooth color change */
        }

        footer .list-inline-item a:hover {
            color: #0056b3;
            /* Darker color on hover */
        }
    </style>

</head>

<body>
<?php include __DIR__.'/../components/header.php'; ?>
<div class="container text-center mt-5">
    <!-- HEADER -->
    <h1 class="ubuntu-regular">Ams Portal</h1>

    <!-- INTRO SECTION -->
    <div class="mt-4">
        <h2>Manage Your Daily Expenses with Ease</h2>
        <h3 class="lead" id="quote"></h3>
        <p class="mt-3"><?= GlobalConstants::SITE_TITLE; ?> is designed for roommates and friends to track and manage shared expenses seamlessly. Whether it’s rent, groceries, or utilities, our platform helps you stay organized and informed.</p>
    </div>

    <!-- CALL TO ACTION -->
    <div class="mt-4">
        <a href="login.php" class="btn btn-primary btn-lg">Login</a>
        <a href="signup.php" class="btn btn-secondary btn-lg">Sign Up</a>
    </div>
</div>

<!-- FEATURES SECTION -->
<!-- FEATURES SECTION -->
<!-- FEATURES SECTION -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Features</h2>
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="feature-card text-center">
                <h4 class="feature-title">Real-Time Email Notifications</h4>
                <p>Stay informed with instant email alerts for every expense recorded. Our platform sends real-time notifications directly to your inbox whenever a new expense is logged by you or your partners. No more guessing—always know where your money is going!</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="feature-card text-center">
                <h4 class="feature-title">Updated Partner Account Balances</h4>
                <p>Keep track of your finances effortlessly. Our system automatically updates the balance in each partner's account after every transaction, ensuring everyone is aware of their financial status. Transparency and accountability are just a click away!</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="feature-card text-center">
                <h4 class="feature-title">Instant Customizable Statement</h4>
                <p>Generate instant, detailed statements tailored to your needs. Customize your view to analyze spending habits and manage your finances better. It's your financial summary, your way!</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="feature-card text-center">
                <h4 class="feature-title">Split Bills</h4>
                <p>Effortlessly split bills among roommates and see who owes what in real-time.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="feature-card text-center">
                <h4 class="feature-title">Payment Reminders</h4>
                <p>Get notifications for upcoming payments and reminders to settle debts.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="feature-card text-center">
                <h4 class="feature-title">Track Expenses</h4>
                <p>Easily log and categorize your daily expenses with a user-friendly interface.</p>
            </div>
        </div>
    </div>
</div>

<!-- Join Now -->
<div class="container mt-5 text-center">
    <h2>Ready to Simplify Your Finances?</h2>
    <p>Join thousands of users and take control of your expenses today!</p>
    <a href="signup.php" class="btn btn-primary btn-lg">Get Started Now</a>
</div>


<!-- Testimonials-->
<div class="container mt-5">
    <h2 class="text-center mb-4">What Our Users Say</h2>
    <div class="row">
        <div class="col-md-4">
            <blockquote class="blockquote text-center">
                <p>"<?= GlobalConstants::SITE_TITLE; ?> has changed the way we manage expenses! It's so easy to use."</p>
                <footer class="blockquote-footer">Abhishek Kumar</footer>
            </blockquote>
        </div>
        <div class="col-md-4">
            <blockquote class="blockquote text-center">
                <p>"Finally, I can keep track of shared bills without any hassle!"</p>
                <footer class="blockquote-footer">Abhay Kumar</footer>
            </blockquote>
        </div>
        <div class="col-md-4">
            <blockquote class="blockquote text-center">
                <p>"The instant notifications keep me informed about all expenses!"</p>
                <footer class="blockquote-footer">Abhishek Tripathi</footer>
            </blockquote>
        </div>
    </div>
</div>

<!-- End -->

<!-- How it work -->
<div class="container mt-5">
    <h2 class="text-center mb-4">How It Works</h2>
    <div class="row">
        <div class="col-md-4 text-center">
            <h4>Step 1: Sign Up</h4>
            <p>Create an account quickly and easily.</p>
        </div>
        <div class="col-md-4 text-center">
            <h4>Step 2: Add Expenses</h4>
            <p>Log your expenses and categorize them effortlessly.</p>
        </div>
        <div class="col-md-4 text-center">
            <h4>Step 3: Stay Updated</h4>
            <p>Receive real-time notifications and manage your finances.</p>
        </div>
    </div>
</div>





<!-- FAQ -->

<div class="container mt-5">
    <h2 class="text-center mb-4">Frequently Asked Questions</h2>

    <div class="faq-item">
        <div class="faq-question" data-toggle="collapse" data-target="#faq1" aria-expanded="false" aria-label="Toggle FAQ about <?= GlobalConstants::SITE_TITLE; ?>">
            <span class="icon">+</span>
            <strong>What is <?= GlobalConstants::SITE_TITLE; ?>?</strong>
        </div>
        <div id="faq1" class="collapse">
            <p><?= GlobalConstants::SITE_TITLE; ?> is a platform designed to help roommates and friends manage shared expenses easily.</p>
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-label="Toggle FAQ about <?= GlobalConstants::SITE_TITLE; ?>">
            <span class="icon">+</span>
            <strong>Is my data secure?</strong>
        </div>
        <div id="faq2" class="collapse">
            <p>Yes, we take data security very seriously and use encryption to protect your information.</p>
        </div>
    </div>
    <div class="faq-item">
        <div class="faq-question" data-toggle="collapse" data-target="#faq3" aria-expanded="false">
            <span class="icon">+</span>
            <strong>Can I access it on mobile?</strong>
        </div>
        <div id="faq3" class="collapse">
            <p>Absolutely! <?= GlobalConstants::SITE_TITLE; ?> is fully responsive and can be accessed from any mobile device.</p>
        </div>
    </div>
    <!-- Add more FAQ items as needed -->
</div>




<!-- Blog -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Resources & Tips</h2>
    <div class="row">
        <div class="col-md-4">
            <h5>Top 5 Tips for Managing Shared Expenses</h5>
            <p>Learn how to keep your finances in check with these helpful tips.</p>
            <a href="tips.php" class="btn btn-link disabled">Read More</a>
        </div>
        <div class="col-md-4">
            <h5>Understanding Your Monthly Budget</h5>
            <p>Get insights into creating and sticking to a budget.</p>
            <a href="budget.php" class="btn btn-link disabled">Read More</a>
        </div>
        <div class="col-md-4">
            <h5>Common Financial Mistakes</h5>
            <p>Avoid these pitfalls and improve your financial health.</p>
            <a href="mistakes.php" class="btn btn-link disabled">Read More</a>
        </div>
    </div>
</div>


<?php include __DIR__.'/../components/footer.php'; ?>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>
    const text = "Friends support each other— financially and emotionally.<br>Let’s make payments easy!";
    const quoteElement = document.getElementById("quote");

    const words = text.split(' '); // Split text into words
    const colors = ["#FF5733", "#0c0c96", "#3357FF", "#F1C40F", "#9B59B6", "#E74C3C", "#1ABC9C"]; // Predefined color palette
    let index = 0;
    const typingSpeed = 50; // Speed of typing in milliseconds


    function adjustLayout(typing) {
        if (typing) {
            quoteElement.style.fontSize = "1.5rem"; // Increase font size while typing
            quoteElement.style.marginTop = "20px"; // Add some margin
        } else {
            quoteElement.style.fontSize = ""; // Reset font size
            quoteElement.style.marginTop = ""; // Reset margin
        }
    }


    function type() {
        adjustLayout(true); // Adjust layout for typing effect
        if (index < words.length) {
            const span = document.createElement('span'); // Create a span for each word
            span.innerHTML = (index === 0 ? '' : ' ') + words[index]; // Use innerHTML for <br>
            span.style.color = colors[index % colors.length]; // Assign a color from the palette
            quoteElement.appendChild(span); // Append the word span to the quoteElement
            quoteElement.style.opacity = 1; // Fade in the text
            index++;
            setTimeout(type, typingSpeed);
        } else {
            setTimeout(() => {
                quoteElement.innerHTML = ""; // Clear the text
                index = 0; // Reset index
                type(); // Restart typing animation
                // Fade out effect
                quoteElement.style.opacity = 0;
            }, 10000); // Wait for 1 second before restarting
        }
    }

    window.onload = function() {
        type(); // Start typing animation when the page loads
    };
</script>


</body>

</html>