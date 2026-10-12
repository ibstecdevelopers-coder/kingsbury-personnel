<?php
http_response_code(404);

include 'header.php';
?>

<?php include 'header.php'; ?>

<head>
    <title>Page Not Found | Kingsbury Personnel</title>

    <style>
        .error-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 60vh;
            text-align: center;
        }

        .error-page h1 {
            font-size: 6rem;
            margin-bottom: 1rem;
        }

        .error-page h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .error-page p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }

        .error-page a.btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #0b1f3a;
            color: #fff;
            text-decoration: none;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease;
        }

        .error-page a.btn:hover {
            background-color: #1a3b6c;
        }
    </style>
</head>
<main class="error-page">
    <div class="error-content">
        <h1>404</h1>

        <h2>Page Not Found</h2>

        <p>
            Sorry, the page you are looking for doesn't exist or may have been moved.
        </p>

        <a href="./index.php" class="btn">
            Back to Homepage
        </a>
    </div>
</main>

<?php include 'footer.php'; ?>