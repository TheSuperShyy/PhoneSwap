<?php
require __DIR__ . '/../dbcon/dbcon.php';
require __DIR__ . '/../queries/phone_query.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Management</title>
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
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="swapphones.html">
            <i class="fa-solid fa-arrows-rotate mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg"
            href="usermanagement.html">
            <i class="fa-solid fa-user-group mr-3"></i>
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
          <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Settings</a>
            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
          </div>
          <h2 class="text-xl font-semibold mr-4">User Management</h2>
        </div>

        <div class="flex flex-row items-center gap-4">
          <!-- Notification Bell -->
          <div class="relative inline-block text-left">
            <button class="relative text-2xl" aria-label="Notifications" id="notificationButton">
              <i class="fa-regular fa-bell"></i>
            </button>

            <!-- Notification Bell -->
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
                      <p class="text-sm text-black-500">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                      <p class="text-xs text-black-400">5 minutes ago</p>
                    </div>
                  </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                  <div class="flex">
                    <div class="mr-3">
                      <p class="font-medium">Cylie Gonzales</p>
                      <p class="text-sm text-black-500">
                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
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
                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
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
                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      </p>
                      <p class="text-xs text-black-400">2 days ago</p>
                    </div>
                  </div>
                </a>
                <a href="#" class="block px-4 py-2 text-sm text-black-700 hover:bg-gray-100" role="menuitem">
                  <div class="flex">
                    <div class="mr-3">
                      <p class="font-medium">Yul Grant Gatchalian</p>
                      <p class="text-sm text-black-500">
                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                      </p>
                      <p class="text-xs text-black-400">2 days ago</p>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>

          <!-- profile -->
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
              <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
              <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Settings</a>
              <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
            </div>
          </div>
        </div>
      </div>

      <div class="pt-22 py-6 laptop:px-10 phone:px-6">
        <!-- contents -->
        <div class="flex flex-col gap-1 items-end justify-center w-full mx-auto">
          <div class="flex flex-col gap-3 mx-auto py-4 w-full">
            <!-- Filter -->
            <div class="flex laptop:flex-row phone:flex-col gap-2 w-full">
              <div class="flex justify-start">
                <form method="" class="flex flex-row items-center">
                  <select name="filter" id="filterSelect"
                    class="px-4 py-2 h-10 w-48 text-sm border border-gray-700 rounded-l-lg outline-none"></select>
                  <input type="text" name="" id="" placeholder="Search" value
                    class="w-full h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                </form>
              </div>
              <div class="flex ml-auto">
                <div class="flex justify-end gap-2">
                  <button id="openModalBtn" class="border border-black bg-blue-950 text-white px-4 py-2 rounded-lg">
                    <i class="fa-solid fa-circle-plus"></i>
                    Add User
                  </button>
                </div>
              </div>
            </div>

            <!-- User Management Table -->
            <div class="rounded-lg shadow-md">
              <div class="w-full overflow-x-auto h-full rounded-lg">
                <table class="w-full bg-white">
                  <thead class="bg-gray-200">
                    <tr class="bg-gray-200 border-b border-gray-400 text-sm text-left px-4">
                      <th class="py-3 px-4 border-b whitespace-nowrap">HFID</th>
                      <th class="py-3 px-4 border-b whitespace-nowrap">Complete Name</th>
                      <th class="py-3 px-4 border-b whitespace-nowrap">Position</th>
                      <th class="py-3 px-4 border-b whitespace-nowrap">Email</th>
                      <th class="py-3 px-4 border-b whitespace-nowrap">Assigned Table</th>
                      <th class="py-3 px-4 border-b"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($users as $user): ?>
                      <tr class="border-b text-left">
                        <td class="py-2 px-4 whitespace-nowrap"><?php echo $user['hfId']; ?></td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                        </td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <?php echo htmlspecialchars($user['userType'] == 'TM' ? 'Team Member' : $user['userType']); ?>
                        </td>
                        <td class="py-2 px-4 whitespace-nowrap"><?php echo $user['username']; ?></td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <?php echo htmlspecialchars('table' . ' ' . $user['table']); ?>
                        </td>
                        <td class="text-center space-x-2">
                          <div class="flex flex-row py-2 px-4 gap-1">
                            <button
                              class="editUserBtn flex flex-row gap-2 items-center border border-white bg-amber-400 hover:bg-amber-600 text-white px-3 py-1.5 rounded-full"
                              data-hfId="<?php echo htmlspecialchars($user['hfId'] ?? ''); ?>"
                              data-firstname="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>"
                              data-lastname="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>"
                              data-email="<?php echo htmlspecialchars($user['username'] ?? ''); ?>"
                              data-table="<?php echo htmlspecialchars($user['table'] ?? ''); ?>"
                              data-role="<?php echo htmlspecialchars($user['userType'] ?? ''); ?>">
                              <i class="fa-solid fa-pen"></i> Edit
                            </button>

                            <button
                              class="deleteUserBtn flex flex-row gap-2 items-center border border-white shadow-md bg-red-600 hover:bg-red-500 text-white px-3 py-1.5 rounded-full"
                              data-id="<?php echo $user['hfId']; ?>">
                              <i class="fa-solid fa-trash"></i> Delete
                            </button>

                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Modal for EDIT USER -->
            <div id="myModal1" 
              class="fixed inset-0 flex justify-center items-center hidden bg-black bg-opacity-50 z-50 pt-24 pb-24 h-full laptop:px-80 laptop:w-full phone:w-full phone:px-4">
              <div class="bg-white border border-gray-600 rounded-lg px-6 py-6 shadow-lg relative h-fit w-full">
                <div class="flex justify-center">
                  <div class="w-28 h-28 bg-gray-200 rounded-full flex items-center justify-center">
                    <span class="text-gray-500 text-3xl">&#128100;</span>
                  </div>
                </div>
                <span class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 cursor-pointer text-2xl"
                  id="closeModalBtn1">&times;</span>

                <div class="flex flex-col gap-4 mt-4">
                  <!-- Name Fields -->
                  <div class="flex laptop:flex-row phone:flex-col gap-4">
                    <div class="flex flex-col gap-2 w-full">
                      <label for="first_name" class="text-sm font-medium">First Name</label>
                      <input type="text" name="first_name" class="border border-gray-700 p-2 rounded-lg text-black"
                        placeholder="<?php echo htmlspecialchars($user['first_name'] ?? ''); ?>" />
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                      <label for="last_name" class="text-sm font-medium">Last Name</label>
                      <input type="text" name="last_name" class="border border-gray-700 p-2 rounded-lg"
                        placeholder="<?php echo htmlspecialchars($user['last_name'] ?? ''); ?>" />
                    </div>
                  </div>

                  <!-- Email & Table Number -->
                  <div class="flex laptop:flex-row phone:flex-col gap-4">
                    <div class="flex flex-col gap-2 w-full">
                      <label for="email" class="text-sm font-medium">Email</label>
                      <input type="email" name="email" class="border border-gray-700 p-2 rounded-lg"
                        placeholder="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" />
                    </div>
                    <div class="flex flex-col gap-2 w-full">
                      <label for="table" class="text-sm font-medium">Table Number</label>
                      <input type="text" name="table" class="border border-gray-700 p-2 rounded-lg"
                        placeholder="<?php echo htmlspecialchars($user['table'] ?? ''); ?>" />
                    </div>
                  </div>

                  <!-- Role Selection -->
                  <div class="flex laptop:flex-row phone:flex-col gap-4">
                    <div class="flex flex-col gap-2 w-full">
                      <label for="role" class="text-sm font-medium">Role</label>
                      <select name="role" class="border border-gray-700 p-2 rounded-lg">
                        <option value="TM" <?php echo (isset($user['userType']) && $user['userType'] == 'TM') ? 'selected' : ''; ?>>Team Member</option>
                      </select>
                    </div>
                  </div>
                </div>
                
                <!-- Buttons -->
                <div class="flex justify-end space-x-2 mt-4">
                  <button
                    class="w-28 px-4 py-2 shadow-md shadow-gray-300 text-white bg-red-600 border border-white font-medium rounded-lg">
                    Deactivate
                  </button>
                  <button
                    class="px-4 py-2 w-24 shadow-md shadow-gray-300 bg-amber-400 font-medium text-white border border-white rounded-lg">
                    Save
                  </button>
                </div>
              </div>
            </div>

            <!-- Pagination -->
            <div class="flex space-x-2">
              <button class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold">
                <i class="fa-solid fa-angle-left"></i>
              </button>
              <button class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold">
                1
              </button>
              <button
                class="border border-gray-300 rounded-lg px-4 py-2 hover:bg-yellow-800 bg-yellow-600 text-white font-medium">
                2
              </button>
              <button class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold">
                3
              </button>
              <button class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold">
                4
              </button>
              <button class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold">
                5
              </button>
              <button class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold">
                <i class="fa-solid fa-angle-right"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>

<!-- Modal - ADD USER -->
<script>
  const modal = document.getElementById("myModal");
  const openModalBtn = document.getElementById("openModalBtn");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const modalCancelButton = document.getElementById("modalCancelButton");

  openModalBtn.addEventListener("click", () => {
    modal.classList.remove("hidden");
  });

  closeModalBtn.addEventListener("click", () => {
    modal.classList.add("hidden");
  });

  modalCancelButton.addEventListener("click", () => {
    modal.classList.add("hidden");
  });
</script>

<!-- Modal1 - EDIT USER -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const modal1 = document.getElementById("myModal1");
    const openModalBtn1 = document.getElementById("openModalBtn1");
    const closeModalBtn1 = document.getElementById("closeModalBtn1");
    const modalCancelButton1 = document.getElementById("modalCancelButton1");

    if (!modal1) {
      console.error("Error: Modal not found!");
      return;
    }

    if (openModalBtn1) {
      openModalBtn1.addEventListener("click", () => {
        modal1.classList.remove("hidden");
      });
    } else {
      console.error("Error: Open modal button not found!");
    }

    if (closeModalBtn1) {
      closeModalBtn1.addEventListener("click", () => {
        modal1.classList.add("hidden");
      });
    } else {
      console.error("Error: Close modal button not found!");
    }

    if (modalCancelButton1) {
      modalCancelButton1.addEventListener("click", () => {
        modal1.classList.add("hidden");
      });
    } else {
      console.error("Error: Modal cancel button not found!");
    }
  });

</script>


<script>
  // Ensure script runs after the DOM is fully loaded
  document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editUserBtn");
    const modal = document.getElementById("myModal1");
    const closeModalBtn = document.getElementById("closeModalBtn1");

    // Ensure modal exists before proceeding
    if (!modal) {
      console.error("Error: Modal not found!");
      return;
    }

    editButtons.forEach(button => {
      button.addEventListener("click", function () {
        // Get hfId to ensure only 1 user is edited
        const hfId = button.getAttribute("data-hfid");
        if (!hfId) {
          console.error("Error: No hfId found!");
          return;
        }

        // Select input fields safely
        const firstNameInput = modal.querySelector("[name='first_name']");
        const lastNameInput = modal.querySelector("[name='last_name']");
        const emailInput = modal.querySelector("[name='email']");
        const tableInput = modal.querySelector("[name='table']");
        const roleDropdown = modal.querySelector("[name='role']");

        // Set values safely
        if (firstNameInput) firstNameInput.value = button.getAttribute("data-firstname") || "";
        if (lastNameInput) lastNameInput.value = button.getAttribute("data-lastname") || "";
        if (emailInput) emailInput.value = button.getAttribute("data-email") || "";
        if (tableInput) tableInput.value = button.getAttribute("data-table") || "";
        if (roleDropdown) roleDropdown.value = button.getAttribute("data-role") || "";

        // Show modal
        modal.classList.remove("hidden");
      });
    });

    // Close modal event (check if button exists)
    if (closeModalBtn) {
      closeModalBtn.addEventListener("click", function () {
        modal.classList.add("hidden");
      });
    } else {
      console.error("Error: Close button not found!");
    }
  });

</script>

</html>