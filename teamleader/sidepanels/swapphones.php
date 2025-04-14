<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../queries/phone_query.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Swap Phones</title>
    <link rel="stylesheet" href="../../src/output.css" />
    <script
      src="https://kit.fontawesome.com/10d593c5dc.js"
      crossorigin="anonymous"
    ></script>
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
            href="../dashboard/dashboard.php">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg"
            href="swapphones.php">
            <i class="fa-solid fa-arrows-rotate mr-3"></i>
            Swap Phones
          </a>
        </li>
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="../sidepanels/usermanagement.php">
            <i class="fa-solid fa-user-group mr-3"></i>
            User Management
          </a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="w-4/5 ml-auto">
      <!-- Navbar section -->
      <div class="fixed w-4/5 bg-gray-200 z-10 px-6 py-3 flex justify-between items-center">
        <!-- Menubar -->
        <div class="flex flex-row items-center gap-4">
          <button class="text-black focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
          <h2 class="text-xl font-semibold mr-4">Dashboard</h2>
        </div>

        <div class="flex gap-4">
          <div class="flex flex-row items-center gap-4">
            <!-- Notification Bell -->
            <div class="relative inline-block text-left">

              <!-- Avatarbar -->
              <div class="relative dropdown">
                <button
                  class="flex flex-row items-center gap-3 border border-black shadow-gray-700 shadow-sm bg-amber-400 text-black px-4 w-fit rounded-xl">
                  <i class="fa-regular fa-user fa-xl"></i>
                  <div class="flex flex-col items-start">
                    <h1 class="font-medium"><?= htmlspecialchars($userName) ?></h1>
                    <h1 class="text-sm"><?= htmlspecialchars($userRole) ?></h1>
                  </div>
                  <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
                </button>
                <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
                  <a href="../accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account
                    Settings</a>
                  <a href="../../src/logout.php" id="logoutBtn" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                    Logout
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="pt-22 py-6 laptop:px-10 phone:px-6">
        <!-- contents -->
            <div class="flex flex-col gap-1 items-end justify-center w-full mx-auto">
              <div class="flex flex-col gap-3 mx-auto py-4 w-full">
                <!-- navig section, filter, search and export button -->
                <div class="flex laptop:flex-row phone:flex-col gap-3 justify-between">
                  <div class="flex flex-row gap-5 border-b border-black">
                      <a href="swapphones.html" class="font-semibold laptop:text-lg phone:text-sm border-b-2 border-black">Swap Phones</a>
                      <a href="swappedphones.html" class="font-semibold laptop:text-lg phone:text-sm hover:border-b-2 hover:border-black">Swapped Phones</a>
                  </div>
                  <div class="flex flex-row gap-4">
                    <!-- Filter and Search -->
                    <div class="flex laptop:flex-row phone:flex-col gap-2 w-full">
                      <div class="flex justify-start">
                        <form method="" class="flex flex-row items-center">
                          <select name="filter" id="filterSelect"
                            class="px-4 py-2 h-10 w-36 text-sm border border-gray-700 rounded-l-lg outline-none">
                              <option value="">Select Filter</option>
                              <option value="">Device Model</option>
                              <option value="">Serial Number</option>
                              <option value="">Status</option>
                              <option value="">Assigned</option>
                              <option value="">Report</option>
                          </select>
                          <input type="text" name="" id="" placeholder="Search" value
                            class="w-2/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg"/>
                        </form>
                      </div>
                      <div class="flex ml-auto gap-2">
                        <button class="flex items-center gap-2 border border-white bg-blue-950 hover:bg-blue-950 hover:bg-opacity-95 text-white px-4 py-2 rounded-lg shadow-md">
                          <i class="fa-solid fa-filter"></i></i><span>Export</span>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
  
                <!-- Swap Phones Table -->
                <div class="w-full overflow-x-auto h-full border border-gray-300 rounded-lg shadow-md">
                  <table class="w-full bg-white pl-7">
                    <thead>
                      <tr class="bg-gray-200 border-b border-gray-400 text-sm text-left px-4">
                        <th class="py-3 px-4 border-b">
                          <input
                            type="checkbox"
                            onclick="toggleSelectAll(this)"
                          />
                        </th>
                        <th class="py-3 px-4 whitespace-nowrap">Device Model</th>
                        <th class="py-3 px-4 whitespace-nowrap">Serial Number</th>
                        <th class="py-3 px-4 whitespace-nowrap">Status</th>
                        <th class="py-3 px-4 whitespace-nowrap">Team Member</th>
                        <th class="py-3 px-4 whitespace-nowrap"></th>
                      </tr> 
                    </thead>
                    <tbody>
                      <tr class=" border-b">
                        <td class="py-2 px-4 whitespace-nowrap">
                          <input type="checkbox" />
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Iphone 8</td>
                        <td class="py-5 px-4 whitespace-nowrap">
                            I8-2024110023
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Table 1</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                            <span class="text-green-800 bg-green-100 border border-green-800 rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">Active</span>
                        </td>
    
                        <td class="py-5 px-4 whitespace-nowrap">Yul Grant Gatchalian</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <button class="flex flex-row gap-2 items-center border font-semibold border-black bg-amber-400 hover:bg-amber-600 text-black px-6 py-1.5 rounded-full shadow-lg">
                            Swap
                          </button>
                        </td>
                      </tr>
                      <tr class=" border-b">
                        <td class="py-2 px-4 whitespace-nowrap">
                          <input type="checkbox" />
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Iphone 8</td>
                        <td class="py-5 px-4 whitespace-nowrap">
                            I8-2024110023
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Table 2</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                            <span class="text-green-800 bg-green-100 border border-green-800 rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">Active</span>
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Cylie Gonzales</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <button class="flex flex-row gap-2 items-center border font-semibold border-black bg-amber-400 hover:bg-amber-600 text-black px-6 py-1.5 rounded-full shadow-lg">
                            Swap
                          </button>
                        </td>
                      </tr>
                      <tr class=" border-b">
                        <td class="py-2 px-4 whitespace-nowrap">
                          <input type="checkbox" />
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Iphone 8</td>
                        <td class="py-5 px-4 whitespace-nowrap">
                            I8-2024110023
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Table 2</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                            <span class="text-green-800 bg-green-100 border border-green-800 rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">Active</span>
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Kian David</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <button class="flex flex-row gap-2 items-center border font-semibold border-black bg-amber-400 hover:bg-amber-600 text-black px-6 py-1.5 rounded-full shadow-lg">
                            Swap
                          </button>
                        </td>
                      </tr>
                      <tr class=" border-b">
                        <td class="py-2 px-4 whitespace-nowrap">
                          <input type="checkbox" />
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Iphone 8</td>
                        <td class="py-5 px-4 whitespace-nowrap">
                            I8-2024110023
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Table 2</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                            <span class="text-green-800 bg-green-100 border border-green-800 rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">Active</span>
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Miko Basilio</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                          <button class="flex flex-row gap-2 items-center border font-semibold border-black bg-amber-400 hover:bg-amber-600 text-black px-6 py-1.5 rounded-full shadow-lg">
                            Swap
                          </button>
                        </td>
                      </tr>
                      <tr class=" border-b">
                        <td class="py-2 px-4 whitespace-nowrap">
                          <input type="checkbox" />
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Iphone 8</td>
                        <td class="py-5 px-4 whitespace-nowrap">
                            I8-2024110023
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Table 1</td>
                        <td class="py-2 px-4 whitespace-nowrap">
                            <span class="text-green-800 bg-green-100 border border-green-800 rounded-full bg-opacity-100 py-2 px-6 font-medium shadow-lg">Active</span>
                        </td>
                        <td class="py-5 px-4 whitespace-nowrap">Yul Grant Gatchalian</p> 
                        <td class="py-2 px-4 whitespace-nowrap">
                          <button class="flex flex-row gap-2 items-center border font-semibold border-black bg-amber-400 hover:bg-amber-600 text-black px-6 py-1.5 rounded-full shadow-lg">
                            Swap
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex space-x-2">
              <button
                class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold"
              >
              <i class="fa-solid fa-angle-left"></i>
              </button>
              <button
                class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold"
              >
                1
              </button>
              <button
                class="border border-gray-300 rounded-lg px-4 py-2 hover:bg-yellow-800 bg-yellow-600 text-white font-medium"
              >
                2
              </button>
              <button
                class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold"
              >
                3
              </button>
              <button
                class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold"
              >
                4
              </button>
              <button
                class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold"
              >
                5
              </button>
              <button
                class="rounded-lg px-4 py-2 hover:bg-blue-50 hover:font-semibold"
              >
              <i class="fa-solid fa-angle-right"></i>
              </button>
            </div>
      </div>
    </div>
  </body>

   <!-- Notification Bell Dropdown-->
   <script>
    const notificationButton = document.getElementById("notificationButton");
    const notificationDropdown = document.getElementById(
      "notificationDropdown"
    );

    notificationButton.addEventListener("click", () => {
      notificationDropdown.classList.toggle("hidden");
    });
  </script>

  <!-- Checkbox script -->
  <script>
    function toggleSelectAll(source) {
      checkboxes = document.querySelectorAll('input[type="checkbox"]');
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source) checkboxes[i].checked = source.checked;
      }
    }
  </script>

</html>