<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Account Settings</title>
  <link rel="icon" href="../src/assets/images/iconswap.svg" type="image/svg">
  <link rel="stylesheet" href="../src/output.css" />
  <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
  <style>
    .dropdown-menu {
      display: none;
    }

    .dropdown:focus-within .dropdown-menu {
      display: block;
    }
  </style>
</head>

<body>
  <div class="flex">

    <!-- Sidebar -->
    <div class="w-1/5 bg-blue-950 text-white h-screen p-4 fixed">
      <h1 class="text-4xl mb-6 mt-2 font-medium font-russo">PhoneSwap</h1>
      <ul>
        <li class="mb-4">
          <a class="flex items-center hover:bg-blue-700 p-2 text-base font-medium rounded-lg" href="dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-blue-700 p-2 text-base font-medium rounded-lg" href="audittrail.php">
            <i class="fas fa-list-alt mr-3"></i>
            Audit Trail
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-blue-700 p-2 text-base font-medium rounded-lg" href="swapphones.php">
            <i class="fa-solid fa-phone mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-blue-700 p-2 text-base font-medium rounded-lg" href="usermanagement.php">
            <i class="fas fa-users mr-3"></i>
            User Management
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="w-4/5 ml-auto">
      <!-- Navbar section -->
      <div class="fixed w-4/5 bg-white z-10 px-6 py-3 flex justify-between items-center shadow-md">
        <!-- Menubar -->
        <div class="flex flex-row items-center gap-4">
          <button class="text-black focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
          <h2 class="text-xl font-semibold mr-4">Account Settings</h2>
        </div>

        <div class="flex gap-4">
          <div class="flex flex-row items-center gap-4">
            <!-- Notification Bell -->
            <div class="relative inline-block text-left">
              <button class="relative text-2xl" aria-label="Notifications" id="notificationButton">
                <i class="fa-regular fa-bell"></i>
              </button>

              <!-- Dropdown Message Notification -->
              <div
                class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white border border-gray-400 ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                role="menu" aria-orientation="vertical" aria-labelledby="notificationButton" id="notificationDropdown">
                <div class="py-1" role="none">
                  <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                    <div class="flex">
                      <div>
                        <p class="font-medium">
                          New message from Yul Gatchalian
                        </p>
                        <p class="text-sm text-black-500">Lorem ipsum dolor sit amet.</p>
                        <p class="text-xs text-black-400">5 minutes ago</p>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                    <div class="flex">
                      <div class="mr-3">
                        <p class="font-medium">Cylie Gonzales</p>
                        <p class="text-sm text-black-500">
                          Lorem ipsum dolor sit amet.
                        </p>
                        <p class="text-xs text-black-400">1 hour ago</p>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                    <div class="flex">
                      <div class="mr-3">
                        <p class="font-medium">Kian David</p>
                        <p class="text-sm text-black-500">
                          Lorem ipsum dolor sit amet.
                        </p>
                        <p class="text-xs text-black-400">2 days ago</p>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                    <div class="flex">
                      <div class="mr-3">
                        <p class="font-medium">Miko Basilio</p>
                        <p class="text-sm text-black-500">
                          Lorem ipsum dolor sit amet.
                        </p>
                        <p class="text-xs text-black-400">2 days ago</p>
                      </div>
                    </div>
                  </a>
                  <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                    <div class="flex">
                      <div class="mr-3">
                        <p class="font-medium">Daniel Digo</p>
                        <p class="text-sm text-black-500">
                          Lorem ipsum dolor sit amet.
                        </p>
                        <p class="text-xs text-black-400">2 days ago</p>
                      </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Avatarbar -->
          <div class="relative dropdown">
            <button
              class="flex flex-row items-center gap-3 border border-black shadow-gray-700 shadow-sm bg-amber-400 text-black px-4 w-fit rounded-xl">
              <i class="fa-regular fa-user fa-xl"></i>
              <div class="flex flex-col items-start">
                <h1 class="font-medium">Emily Dav</h1>
                <h1 class="text-sm">Admin</h1>
              </div>
              <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
            </button>
            <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
              <a href="accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                Account Settings
              </a>
              <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                Logout
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="pt-22 py-6 laptop:px-12 phone:px-4">
        <!-- contents -->
        <div class="flex flex-col gap-1 items-end justify-center w-full mx-auto">
          <div class="flex flex-col gap-3 mx-auto py-4 w-full">
            <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
              <div class="flex justify-center">
                <!-- Profile Icon -->
                <div class="w-28 h-28 bg-gray-200 rounded-full flex items-center justify-center">
                  <span class="text-gray-500 text-3xl">&#128100;</span>
                </div>
              </div>

              <!-- Form -->
              <div class="flex flex-col gap-4 mt-4">
                <div class="flex laptop:flex-row phone:flex-col gap-4">
                  <div class="flex flex-col gap-2 w-full">
                    <label for="firstName" class="text-sm font-medium">First Name</label>
                    <input type="text" id="firstName" placeholder="Yul Grant"
                      class="border border-gray-700 p-2 rounded-lg text-black">
                  </div>
                  <div class="flex flex-col gap-2 w-full">
                    <label for="lastName" class="text-sm font-medium">Last Name</label>
                    <input type="text" id="lastName" placeholder="Gatchalian"
                      class="border border-gray-700 p-2 rounded-lg text-black">
                  </div>
                </div>
                <div class="flex laptop:flex-row phone:flex-col gap-4">
                  <div class="flex flex-col gap-2 w-full">
                    <label for="role" class="text-sm font-medium">Role</label>
                    <select id="role" id="role" placeholder="admin"
                      class="border border-gray-700 p-2 rounded-lg text-black">
                      <option value="Admin">Admin</option>
                      <option value="Team Leader">Team Leader</option>
                    </select>
                  </div>
                  <div class="flex flex-col gap-2 w-full">
                    <label for="id" class="text-sm font-medium">ID</label>
                    <input type="text" id="id" placeholder="PH0342"
                      class="border border-gray-700 p-2 rounded-lg text-black">
                  </div>
                </div>
                <div class="flex laptop:flex-row phone:flex-col gap-4">
                  <div class="flex flex-col gap-2 w-full">
                    <label for="email" class="text-sm font-medium">Email</label>
                    <input type="email" id="email" placeholder="yulgrant@gmail.com"
                      class="border border-gray-700 p-2 rounded-lg text-black">
                  </div>
                  <div class="flex flex-col gap-2 w-full">
                    <label for="contactNumber" class="text-sm font-medium">Contact Number</label>
                    <input type="tel" id="contactNumber" placeholder="099098362627"
                      class="border border-gray-700 p-2 rounded-lg text-black">
                  </div>
                </div>
              </div>

              <!-- Button -->
              <div class="flex justify-end space-x-2 mt-4">
                <a href="dashboard.php">
                  <button id="closeModalBtn"
                    class="w-24 px-4 py-2 shadow-md shadow-gray-300 bg-red-800 text-white border border-white-300 font-medium rounded-lg">
                    Back
                  </button>
                </a>
                <button
                  class="px-4 py-2 w-24 shadow-md shadow-gray-300 bg-amber-400 font-medium text-white border border-white rounded-lg">
                  Save
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</body>

<!-- Script for notification bell dropdown-->
<script>
  const notificationButton = document.getElementById("notificationButton");
  const notificationDropdown = document.getElementById(
    "notificationDropdown"
  );

  notificationButton.addEventListener("click", () => {
    notificationDropdown.classList.toggle("hidden");
  });
</script>

</html>