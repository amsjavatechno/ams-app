<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .content-wrapper {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            max-width: 1200px;
        }
        .quotes-container {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .quotes-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
        }
        .quotes-container p {
            font-size: 1.2em;
            color: #333;
            line-height: 1.5;
        }
        .form-container {
            flex: 1;
            max-width: 400px;
            padding: 20px;
            margin-right: 10%;
        }
        @media (max-width: 768px) {
            .content-wrapper {
                flex-direction: column;
            }
            .form-container {
                margin: 0 auto;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    <!-- Quotes Section -->
    <div class="quotes-container">
        <p>Manage Your Daily Expenses with Ease</p>
        <p>Friends support each other—financially and emotionally.</p>
        <p>Let’s make payments easy!</p>
        <p>AmsPortal is designed for roommates and friends to track and manage shared expenses seamlessly. Whether it’s rent, groceries, or utilities, our platform helps you stay organized and informed.</p>
        <img src="../../images/ams-logo.png" width="150" height="50" style="display: flex;align-items: center" alt="Inspirational Image">
    </div>

    <!-- Registration Form -->
    <div class="form-container">
        <form class="p-4 border rounded bg-light">
            <h3 class="text-center">Register</h3>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" required>
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <div id="recaptcha"></div>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script>
    $(document).ready(function () {
        $("form").on("submit", function (e) {
            e.preventDefault();
            alert("Registration form submitted!");
        });
    });
</script>
</body>
</html>
