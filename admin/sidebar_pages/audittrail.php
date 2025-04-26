<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Audit Trail</title>
  <link rel="stylesheet" href="../../src/output.css" />
  <script src="https://kit.fontawesome.com/10d593c5dc.js" crossorigin="anonymous"></script>
  <script src="../../scripts/script.js"></script>
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
            href="../dashboard/dashboard.php">
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
        <li class="mb-4">
          <a class="flex items-center hover:bg-opacity-30 hover:bg-white p-2 text-base font-medium rounded-lg"
            href="user_audit.php">
            <i class="fas fa-list-alt mr-3"></i>
            User Audit Log
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
            <a href="../accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account Settings</a>
            <a href="../../src/logout.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
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

          <!-- Pagination -->
          <div class="pagination flex justify-end space-x-2 px-14 mb-4" id="pagination">
            <button class="prev-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
              <i class="fa-solid fa-angle-left"></i>
            </button>
            <!-- Numbered buttons will be generated here by JS -->
            <button class="next-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
              <i class="fa-solid fa-angle-right"></i>
            </button>
          </div>
        </div>
      </div>
</body>

<!-- audit table -->
<script>
  function setupPagination() {
  const rowsPerPage = 5;
  const tableRows = document.querySelectorAll(".user-row");
  const totalPages = Math.ceil(tableRows.length / rowsPerPage);

  const pagination = document.querySelector(".pagination");
  const prevBtn = pagination.querySelector(".prev-btn");
  const nextBtn = pagination.querySelector(".next-btn");

  let currentPage = 1;
  let paginationButtons = [];

  if (totalPages === 0) {
    prevBtn.style.display = "none";
    nextBtn.style.display = "none";
    return;
  } else {
    prevBtn.style.display = "inline-block"; // Ensure buttons are shown
    nextBtn.style.display = "inline-block"; // Ensure buttons are shown
  }

  // Add the pagination buttons (1, 2, 3, etc.)
  function createPaginationButtons() {
    paginationButtons.forEach(btn => btn.remove());
    paginationButtons = [];

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.className = "rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold page-btn";

      // Insert the button before the "next" button
      pagination.insertBefore(btn, nextBtn);

      // Add click event for each page
      btn.addEventListener("click", () => {
        currentPage = i;
        showPage(currentPage);
      });

      paginationButtons.push(btn);
    }
  }

  // Show the table rows for the current page
  function showPage(page) {
    const start = (page - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    tableRows.forEach((row, index) => {
      row.style.display = index >= start && index < end ? "" : "none";
    });

    paginationButtons.forEach((btn, i) => {
      if ((i + 1) === page) {
        btn.classList.add("bg-amber-400", "text-white");
        btn.classList.remove("hover:bg-yellow-100");
      } else {
        btn.classList.remove("bg-amber-400", "text-white");
        btn.classList.add("hover:bg-yellow-100");
      }
    });
  }

  // Event listener for the prev button
  prevBtn.addEventListener("click", () => {
    if (currentPage > 1) {
      currentPage--;
      showPage(currentPage);
    }
  });

  // Event listener for the next button
  nextBtn.addEventListener("click", () => {
    if (currentPage < totalPages) {
      currentPage++;
      showPage(currentPage);
    }
  });

  createPaginationButtons();  // Create the page buttons
  showPage(currentPage);      // Show the first page
}

document.addEventListener("DOMContentLoaded", function () {
  fetch("../audit_log/fetch_audit.php")
    .then(response => response.json())
    .then(data => {
      console.log("Raw Response:", data);

      if (data.success) {
        const tableBody = document.querySelector("#auditTableBody");
        if (!tableBody) {
          console.error("Error: Table body with ID 'auditTableBody' not found.");
          return;
        }

        tableBody.innerHTML = "";

        data.data.forEach(log => {
          const row = `
            <tr class="border-b text-sm user-row">
              <td class="py-3 px-4 whitespace-nowrap">${log.date}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.user}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.serial_number}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.model}</td>
              <td class="py-3 px-4 whitespace-nowrap">${log.action}</td>
            </tr>
          `;
          tableBody.innerHTML += row;
        });

        // Once rows are added, set up pagination
        setupPagination();

      } else {
        console.error("Failed to fetch audit logs:", data.message);
      }
    })
    .catch(error => {
      console.error("Fetch Error:", error);
    });
});
</script>

</html>