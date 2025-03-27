<?php
require __DIR__ . '/../dbcon/dbcon.php';
require __DIR__ . '/../dbcon/authentication.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Audit Trail</title>
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
          <a class="flex items-center hover:bg-blue-700 p-2 text-base font-medium rounded-lg"
            href="../admin/dashboard/dashboard.php">
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
          <h2 class="text-xl font-semibold mr-4">Audit Trail</h2>
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
              <a href="accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account Settings</a>
              <a href="../src/logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
            </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="pt-22 py-6 laptop:px-12 phone:px-4">
        <!-- contents -->
        <div class="flex flex-col gap-1 items-end justify-center w-full mx-auto">
          <div class="flex flex-col gap-3 mx-auto py-4 w-full">
            <!-- Filter -->
            <div class="items-start w-full">
              <form method="GET" class="flex flex-row items-center">
                <select name="filter" id="filterSelect"
                  class="px-4 py-2 h-10 w-48 text-sm border border-gray-700 rounded-l-lg outline-none"></select>
                <input type="text" name="search" id="searchInput" placeholder="Search" value
                  class="w-1/3 h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
              </form>
            </div>

            <!-- Audit trail table -->
            <div class="w-full overflow-x-auto h-full border border-gray-300 rounded-lg shadow-md">
              <table class="w-full bg-white pl-7">
                <thead>
                  <tr class="bg-gray-200 border-b border-gray-400 text-sm text-left px-4">
                    <th class="py-3 px-4 whitespace-nowrap">
                      Date & Time
                    </th>
                    <th class="py-3 px-4 whitespace-nowrap">User</th>
                    <th class="py-3 px-4 whitespace-nowrap">Serial Device</th>
                    <th class="py-3 px-4 whitespace-nowrap">Device Model</th>
                    <th class="py-3 px-4 whitespace-nowrap">Action</th>
                  </tr>
                </thead>
                <tbody id="auditTableBody"> <!-- ✅ Add tbody with an ID -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- audit table -->
          <script>
            document.addEventListener("DOMContentLoaded", function () {
              fetch("fetch_audit.php")
                .then(response => response.json())
                .then(data => {
                  console.log("Raw Response:", data);

                  if (data.success) {
                    const tableBody = document.querySelector("#auditTableBody"); // ✅ Ensure correct tbody ID
                    if (!tableBody) {
                      console.error("Error: Table body with ID 'auditTableBody' not found.");
                      return;
                    }

                    tableBody.innerHTML = ""; // Clear previous content

                    data.data.forEach(log => {
                      const row = `
            <tr class="border-b text-sm">
              <td class="py-3 px-4 whitespace-nowrap">${log.date}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.user}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.serial_number}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.model}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.action}</td>
            </tr>
          `;
                      tableBody.innerHTML += row;
                    });
                  } else {
                    console.error("Failed to fetch audit logs:", data.message);
                  }
                })
                .catch(error => {
                  console.error("Fetch Error:", error);
                });
            });
          </script>























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
</body>

</html>