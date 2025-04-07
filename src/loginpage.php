<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../src/output.css">
    <title>Login Page</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- ✅ Add SweetAlert -->
</head>
<body class="flex flex-col min-h-screen w-full">
    <div id="main-container" class="flex flex-wrap min-h-screen">
        <div class="hidden py-2 md:flex flex-col justify-center bg-blue-950 w-1/2">
            <div class="flex flex-col items-center justify-center gap-4 h-full">
                <h4 class="text-white text-6xl font-medium text-center">PhoneSwap</h4>
                <p class="text-white text-base font-medium">A web-based phone swap tracking system</p>
            </div>
        </div>

        <div class="flex flex-col justify-center w-full min-h-screen md:w-1/2 mx-auto">
            <!-- ✅ Added id="loginForm" -->
            <form id="loginForm" method="POST"
                class="flex flex-col justify-center md:w-96 phone:w-3/4 mx-auto my-auto flex-1">
                <div class="login-top flex flex-col items-center gap-3 mb-5">
                    <p class="text-5xl font-bold text-blue-950 mb-5">Login</p>
                </div>
                <div class="relative mb-3">
                    <label for="email" class="block text-lg font-medium">Email</label>
                    <input type="email" id="email" name="email" required
                        class="rounded-md shadow-sm text-black text-base border border-gray-500 focus:outline-none focus:border-blue-900 block w-full py-3 px-2.5"
                        placeholder="Email">
                </div>
                <div class="relative mb-5">
                    <label for="password" class="block text-lg font-medium">Password</label>
                    <input type="password" id="password" name="password" required
                        class="rounded-md shadow-sm text-black text-base border border-gray-500 focus:outline-none focus:border-blue-900 block w-full py-3 px-2.5"
                        placeholder="Password">
                </div>
                <button type="submit"
                    class="text-white bg-blue-950 hover:opacity-90 font-medium rounded-full text-sm w-full px-5 py-2.5 text-center">
                    Login
                </button>
            </form>
        </div>
    </div>

    <!-- ✅ JavaScript for handling login with SweetAlert -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("loginForm").addEventListener("submit", function (e) {
            e.preventDefault(); // ✅ Prevent default form submission

            const formData = new FormData(this);

            fetch("../src/auth/login.php", { // ✅ Ensure correct path
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // ✅ Expect JSON response
            .then(data => {
                console.log(data); // Log the response for debugging
                if (data.success) {
                    // Redirect based on userType
                    let redirectUrl = "";
                    if (data.userType === 'admin') {
                        redirectUrl = "../admin/dashboard/dashboard.php"; // Admin dashboard
                    } else if (data.userType === 'TL') {
                        redirectUrl = "../teamleader/dashboard/dashboard.php"; // Team Leader dashboard
                    }

                    // Check if the redirectUrl is correctly set
                    console.log("Redirecting to:", redirectUrl);

                    Swal.fire({
                        icon: "success",
                        title: "Login Successful!",
                        text: data.message,
                        confirmButtonColor: "#3085d6",
                    }).then(() => {
                        // Trigger the redirection
                        window.location.href = redirectUrl; // ✅ Redirect based on userType
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed!",
                        text: data.error,
                        confirmButtonColor: "#d33",
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Oops!",
                    text: "Something went wrong. Please try again.",
                    confirmButtonColor: "#d33",
                });
            });
        });
    });
</script>


</body>
</html>
