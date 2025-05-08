<?php
require __DIR__ . '/../../dbcon/dbcon.php';
require __DIR__ . '/../../dbcon/authentication.php';
require __DIR__ . '/../../dbcon/session_get.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Audit Trail</title>
  <link rel="stylesheet" href="../../src/output.css" />
  <link rel="icon" href="../../src/assets/images/iconswap.svg" type="image/svg">
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
          <a class="flex items-center bg-opacity-30 bg-white p-2 text-base font-medium rounded-lg"
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
              <h1 class="font-medium"><?= htmlspecialchars($userName) ?></h1>
              <h1 class="text-sm"><?= htmlspecialchars($userRole) ?></h1>
            </div>
            <i class="fa-solid fa-angle-down fa-sm pl-3"></i>
          </button>
          <div class="dropdown-menu absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
            <a href="accountsetting.php" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Account
              Settings</a>
            <a href="../../src/logout.php" id="logoutBtn" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
              Logout
            </a>

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
                <div class="flex justify-start mb-4">
                  <form class="flex flex-row items-center gap-0">

                    <select id="filterSelect"disabled
                      class="px-4 py-2 h-10 w-48 text-sm border border-gray-700 rounded-l-lg outline-none">
                      <option value="">Sort by Date</option>
                      <option value="asc">Date Ascending</option>
                      <option value="desc">Date Descending</option>
                    </select>

                    <input type="text" id="searchInput" placeholder="Search"
                      class="w-full h-10 p-2 border border-gray-700 shadow-sm sm:text-sm outline-none rounded-r-lg" />
                  </form>
                </div>

                <!-- Audit trail table -->
                <div class="w-full overflow-x-auto h-full border border-gray-300 rounded-lg shadow-md">
                  <table class="w-full bg-white">
                    <thead>
                      <tr class="bg-gray-200 border-b border-gray-400 text-sm text-left">
                        <th class="py-3 px-4 whitespace-nowrap">Date & Time</th>
                        <th class="py-3 px-4 whitespace-nowrap">User</th>
                        <th class="py-3 px-4 whitespace-nowrap">Action</th>
                        <th class="py-3 px-4 whitespace-nowrap">Details</th>
                      </tr>
                    </thead>
                    <tbody id="auditTableBody"></tbody>
                  </table>
                </div>



                <!-- Pagination -->
                <div class="pagination flex justify-end space-x-2 px-14 mb-4" id="pagination">
                  <button
                    class="prev-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
                    <i class="fa-solid fa-angle-left"></i>
                  </button>
                  <!-- Numbered buttons will be generated here by JS -->
                  <button
                    class="next-btn rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold">
                    <i class="fa-solid fa-angle-right"></i>
                  </button>
                </div>
            </div>
          </div>
</body>

<!-- audit table -->
<script>
  function setupPaginationAndSorting(logs) {
    const rowsPerPage = 5;
    const tableBody = document.querySelector("#auditTableBody");
    const pagination = document.querySelector(".pagination");
    const prevBtn = pagination.querySelector(".prev-btn");
    const nextBtn = pagination.querySelector(".next-btn");

    let currentPage = 1;
    let currentLogs = [...logs];

    function renderTableRows(data) {
      tableBody.innerHTML = "";
      data.forEach(log => {
        const row = `
          <tr class="border-b text-sm user-row">
            <td class="py-3 px-4 whitespace-nowrap">${log.date}</td>
            <td class="py-3 px-4 whitespace-nowrap">${log.user}</td>
            <td class="py-3 px-4 whitespace-nowrap">${log.action}</td>
            <td class="py-3 px-4 whitespace-nowrap">${log.details}</td>
          </tr>`;
        tableBody.innerHTML += row;
      });
    }

    function paginateData(data) {
      const start = (currentPage - 1) * rowsPerPage;
      return data.slice(start, start + rowsPerPage);
    }

    function createPaginationButtons(data) {
      // Remove old buttons
      const oldButtons = pagination.querySelectorAll(".page-btn, .dots");
      oldButtons.forEach(btn => btn.remove());

      const totalPages = Math.ceil(data.length / rowsPerPage);
      if (totalPages === 0) {
        prevBtn.style.display = "none";
        nextBtn.style.display = "none";
        return;
      } else {
        prevBtn.style.display = "inline-block";
        nextBtn.style.display = "inline-block";
      }

      const maxVisibleButtons = 3;
      let startPage = Math.max(1, currentPage - 1);
      let endPage = Math.min(totalPages, startPage + maxVisibleButtons - 1);

      if (currentPage <= 2) {
        startPage = 1;
        endPage = Math.min(totalPages, maxVisibleButtons);
      } else if (currentPage >= totalPages - 1) {
        endPage = totalPages;
        startPage = Math.max(1, totalPages - maxVisibleButtons + 1);
      }

      if (startPage > 1) {
        addPageButton(1);
        if (startPage > 2) addDots();
      }

      for (let i = startPage; i <= endPage; i++) {
        addPageButton(i);
      }

      if (endPage < totalPages) {
        if (endPage < totalPages - 1) addDots();
        addPageButton(totalPages);
      }

      updatePaginationStyle();
    }

    function addPageButton(page) {
      const btn = document.createElement("button");
      btn.textContent = page;
      btn.className = "rounded-lg px-4 py-2 hover:bg-yellow-100 hover:border-black hover:font-semibold page-btn";
      if (page === currentPage) {
        btn.classList.add("bg-amber-400", "text-white");
      }
      btn.addEventListener("click", () => {
        currentPage = page;
        renderTableRows(paginateData(currentLogs));
        createPaginationButtons(currentLogs);
      });
      pagination.insertBefore(btn, nextBtn);
    }

    function addDots() {
      const dots = document.createElement("span");
      dots.textContent = "...";
      dots.className = "dots px-2";
      pagination.insertBefore(dots, nextBtn);
    }

    function updatePaginationStyle() {
      const buttons = pagination.querySelectorAll(".page-btn");
      buttons.forEach(btn => {
        if (parseInt(btn.textContent) === currentPage) {
          btn.classList.add("bg-amber-400", "text-white");
          btn.classList.remove("hover:bg-yellow-100");
        } else {
          btn.classList.remove("bg-amber-400", "text-white");
          btn.classList.add("hover:bg-yellow-100");
        }
      });
    }

    function applySortingAndSearch() {
      const sortValue = document.getElementById("filterSelect").value;
      const searchValue = document.getElementById("searchInput").value.toLowerCase();

      let filtered = [...logs];

      if (searchValue) {
        filtered = filtered.filter(log =>
          Object.values(log).some(val =>
            String(val).toLowerCase().includes(searchValue)
          )
        );
      }

      if (sortValue === "asc") {
        filtered.sort((a, b) => new Date(a.date) - new Date(b.date));
      } else if (sortValue === "desc") {
        filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
      }

      currentLogs = filtered;
      currentPage = 1;
      renderTableRows(paginateData(currentLogs));
      createPaginationButtons(currentLogs);
    }

    // Event Listeners
    document.getElementById("filterSelect").addEventListener("change", applySortingAndSearch);
    document.getElementById("searchInput").addEventListener("input", applySortingAndSearch);

    prevBtn.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        renderTableRows(paginateData(currentLogs));
        createPaginationButtons(currentLogs);
      }
    });

    nextBtn.addEventListener("click", () => {
      const maxPage = Math.ceil(currentLogs.length / rowsPerPage);
      if (currentPage < maxPage) {
        currentPage++;
        renderTableRows(paginateData(currentLogs));
        createPaginationButtons(currentLogs);
      }
    });

    applySortingAndSearch(); // Initial load
  }

  document.addEventListener("DOMContentLoaded", () => {
    fetch("../audit_log/fetch_user_audit.php")
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          setupPaginationAndSorting(data.data);
        } else {
          alert("Error: " + data.message);
        }
      })
      .catch(err => {
        console.error("Fetch error:", err);
        alert("An error occurred while fetching the data.");
      });
  });
</script>



</html>